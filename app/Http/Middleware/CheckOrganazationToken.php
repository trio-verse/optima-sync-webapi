<?php

namespace App\Http\Middleware;

use App\Helper\V1\ApiResponse;
use App\Models\Organization;
use App\Services\OrgSecureCryptService;
use App\Singleton\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrganazationToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->route('token');
        $orgId = OrgSecureCryptService::decrypt($token);

        if (! $orgId) {
            return ApiResponse::notFound('Invalid or malformed token.', 404);
        }

        $organization = Organization::find($orgId);

        if (! $organization) {
            return ApiResponse::notFound('Organization not found.', 404);
        }
        app(TenantManager::class)->setOrganizationId($organization->id);

        return $next($request);

    }
}
