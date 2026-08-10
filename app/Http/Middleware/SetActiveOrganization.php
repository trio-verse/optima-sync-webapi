<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use App\Singleton\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SetActiveOrganization
{

    public function __construct(protected TenantManager $tenantManager)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Get Organization ID from Header (or route/query string)
        $orgId = $request->header('X-Organization-Id') ?? $request->route('organization_id');

        if (!$orgId) {
            return response()->json(['message' => 'Organization context required (X-Organization-Id header missing).'], 400);
        }
        $user = $request->user();
        $isAdmin = Organization::where('id',$orgId)->where('user_id', $user->id)->exists();
        $isMember = DB::table("organization_members")->where("organization_id", $orgId)->where("user_id", $user->id)->exists();

        if (!$isMember && !$isAdmin) {
            return response()->json(['message' => 'Unauthorized access to this organization.'], 403);
        }

        $this->tenantManager->setOrganizationId((int) $orgId);

        return $next($request);
    }
}
