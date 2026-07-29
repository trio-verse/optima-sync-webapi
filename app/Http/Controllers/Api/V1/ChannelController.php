<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Channel\StoreChannelRequest;
use App\Http\Requests\Channel\UpdateChannelRequest;
use App\Http\Resources\V1\ChannelResource;
use App\Models\Channel;
use App\Services\ChannelService;
use Illuminate\Http\Request;

class ChannelController extends Controller
{

    public function __construct(
        protected ChannelService $channel_service
    ) {}
     /**
     * Display a listing of the channels
     * this endpoint display all channels from DB
     * response get all channels
     */
    public function index()
    {
        $channels = $this->channel_service->getAllChannels();
        return ApiResponse::success(ChannelResource::collection($channels), 'Channels fetched succsesfully');
    }



    /**
     * create channel
     * this endpoint create new channel
     * response new channel
     */
    public function store(StoreChannelRequest $request)
    {
        $channel = $this->channel_service->createChannel($request->validated());
        return ApiResponse::response(new ChannelResource($channel), 'The channel was created succsesfully', 201);
    }


    /**
     * Update channel
     * this endpoint update channel data
     * response updated channel data
     */
    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $is_updated = $this->channel_service->updateChannel($request->validated(), $channel);
        if ($is_updated) {
            return ApiResponse::response(new ChannelResource($channel), 'The channel was updated succsesfully', 200);;
        } else   return ApiResponse::error(null, "bad request", 400);
    }

    /**
     * Delete channel
     * this endpoint delete channel data from DB
     * response remove the specified channel from DB
     */
    public function destroy(Channel $channel)
    {
        $this->channel_service->deleteChannel($channel);

        return ApiResponse::success(
            null,
            'Channel deleted successfully',
            200
        );
    }
}
