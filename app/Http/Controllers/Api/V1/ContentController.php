<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\StoreContentRequest;
use App\Http\Requests\Content\UpdateContentRequest;
use App\Http\Resources\V1\ContentResource;
use App\Models\Campaign;
use App\Models\Content;
use App\Services\Marketing\Content\CreateContentService;
use App\Services\Marketing\Content\updateContentService;
use App\Services\Marketing\ContentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private CreateContentService $create_content_service,
        private updateContentService $update_content_service
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('viewAny', [Content::class, $campaign]);
        $campaign->load('contents');
        return ApiResponse::success(ContentResource::collection($campaign->contents()->latest()->get()), 'contents retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Campaign $campaign, Content $content)
    {
        $this->authorize('view', [$campaign, $content]);
        $content->loadMissing(['channel', 'campaign']);
        return ApiResponse::success(new ContentResource($content));
    }


    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
