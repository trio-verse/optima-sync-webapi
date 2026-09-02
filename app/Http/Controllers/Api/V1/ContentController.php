<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\ChangeContentStatusRequest;
use App\Http\Requests\Content\ConfirmContentCostRequest;
use App\Http\Requests\Content\StoreContentRequest;
use App\Http\Requests\Content\UpdateContentRequest;
use App\Http\Resources\V1\ContentResource;
use App\Models\Campaign;
use App\Models\Content;
use App\Services\Marketing\Content\ChangeContentStatusService;
use App\Services\Marketing\Content\ConfirmContentCostService;
use App\Services\Marketing\Content\CreateContentService;
use App\Services\Marketing\Content\GetCampaignContentService;
use App\Services\Marketing\Content\UpdateContentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


/**
 * @group Content
 */

class ContentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private GetCampaignContentService $get_campaign_content_service,
        private CreateContentService $create_content_service,
        private UpdateContentService $update_content_service,
        private ConfirmContentCostService $confirm_content_cost_service,
        private ChangeContentStatusService $change_content_status_service
    ) {
    }
    /**
     * Content list.
     * Display a listing of campaign content.
     */
    public function index(Request $request, Campaign $campaign)
    {
        $this->authorize('viewAny', [Content::class, $campaign]);
        $validated = $request->only([
            'per_page',
            'page',
            'sort',
            'order',
        ]);
        $contents  = $this->get_campaign_content_service->getContent($campaign , $validated);
        return ApiResponse::pagination(ContentResource::collection($contents), 'contents retrieved successfully');
    }

    /**
     * Store content.
     */
    public function store(StoreContentRequest $request)
    {
        $this->authorize('create', [Content::class, $request->campaign]);
        try {
            $content = $this->create_content_service->createContent($request->user(), $request->validated());
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
        return ApiResponse::success(new ContentResource($content), 'Content created successfully');
    }

    /**
     * Display content.
     */
    public function show(Campaign $campaign, Content $content)
    {
        $this->authorize('view', [$campaign, $content]);
        $content->loadMissing(['channel', 'campaign']);
        return ApiResponse::success(new ContentResource($content));
    }


    /**
     * Update content.
     */
    public function update(UpdateContentRequest $request, Campaign $campaign, Content $content)
    {

        try {
            $isUpdated = $this->update_content_service->update($request->user(), $campaign, $content, $request->validated());

            if (!$isUpdated) {
                return ApiResponse::error('Content update failed', 422);
            }
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
        return ApiResponse::success(new ContentResource($content), 'Content updated successfully');
    }

    /**
     * Confirm content cost.
     * Admin only: accept the current cost as-is, or replace it, then confirm.
     */
    public function confirmCost(ConfirmContentCostRequest $request, Campaign $campaign, Content $content)
    {
        try {
            $content = $this->confirm_content_cost_service->confirm(
                $request->user(),
                $campaign,
                $content,
                $request->validated()
            );
        } catch (ValidationException $e) {
            throw $e;
        } catch (AuthorizationException $e) {
            return ApiResponse::forbidden($e->getMessage());
        } catch (\Exception $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        }

        return ApiResponse::success(new ContentResource($content), 'Content cost confirmed successfully');
    }

    /**
     * Change content status.
     * Enforces the role-based transition matrix and stamps status metadata.
     */
    public function changeStatus(ChangeContentStatusRequest $request, Campaign $campaign, Content $content)
    {
        try {
            $content = $this->change_content_status_service->changeStatus(
                $request->user(),
                $campaign,
                $content,
                $request->validated('status')
            );
        } catch (AuthorizationException $e) {
            return ApiResponse::forbidden($e->getMessage());
        } catch (\Exception $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        }

        return ApiResponse::success(new ContentResource($content), 'Content status changed successfully');
    }

    /**
     * Remove content.
     */
    public function destroy(Campaign $campaign, Content $content)
    {
        $this->authorize('delete', $content);
        if ($campaign->contents()->where('id', $content->id)->exists()) {
            $content->delete();
        }
        return ApiResponse::success([], 'Content deleted successfully');
    }
}
