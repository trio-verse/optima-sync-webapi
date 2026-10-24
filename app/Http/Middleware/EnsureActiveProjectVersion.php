<?php

namespace App\Http\Middleware;

use App\Http\Resources\V1\ProjectManagment\ProjectVersionResource;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveProjectVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // The mutation service records this only after its transaction succeeds.
        $newBranchedVersion = $request->attributes->get('branched_new_version');
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
