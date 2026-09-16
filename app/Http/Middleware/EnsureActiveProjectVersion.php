<?php

namespace App\Http\Middleware;

use App\Http\Resources\V1\ProjectManagment\ProjectVersionResource;
use App\Models\Project;
use App\Models\ProjectVersion;
use App\Services\ProjectManagment\ProjectVersionService;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveProjectVersion
{
    public function __construct(
        protected ProjectVersionService $versionService
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Only intercept mutating HTTP methods (POST, PUT, PATCH, DELETE)
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $next($request);
        }

        // 2. Extract Project model or Project ID from route
        $projectParam = $request->route('project') ?? $request->route('project_id');

        if (!$projectParam) {
            return $next($request);
        }

        $project = $projectParam instanceof Project
            ? $projectParam
            : Project::find($projectParam);

        if (!$project) {
            return $next($request);
        }

        // 3. Determine target version (explicit version parameter or project's current version)
        $versionParam = $request->route('version') ?? $request->route('id');
        $targetVersion = null;

        if ($versionParam && $request->is('*/versions/*')) {
            $targetVersion = $versionParam instanceof ProjectVersion
                ? $versionParam
                : $project->versions()->find($versionParam);
        }

        if (!$targetVersion) {
            $targetVersion = $project->currentVersion ?? $project->active_version;
        }

        $newBranchedVersion = null;

        // 4. If target version is frozen, branch a new version using ProjectVersionService
        if ($targetVersion && $targetVersion->freeze) {
            $newBranchedVersion = $this->versionService->branchVersion($targetVersion, [
                'change_description' => 'Automatically branched upon ' . $request->method() . ' request to ' . $request->path(),
            ]);

            // Store newly branched version in request context
            $request->attributes->set('branched_new_version', $newBranchedVersion);

            // Refresh project relationship in route context
            $project->refresh();
            if ($projectParam instanceof Project) {
                $projectParam->refresh();
            }
        }

        // 5. Proceed to downstream request execution
        $response = $next($request);

        // 6. Enrich JSON response to notify frontend if a new version was opened
        if ($newBranchedVersion && $response instanceof JsonResponse) {
            $responseData = $response->getData(true);

            if (is_array($responseData)) {
                $responseData['version_branched'] = true;
                $responseData['new_version'] = (new ProjectVersionResource($newBranchedVersion))->resolve();

                $response->setData($responseData);
            }
        }

        return $response;
    }
}
