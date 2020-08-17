<?php

namespace App\Events;

use App\Models\Ad;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class newAdForPage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Ad
     */
    public $ad;

    /**
     * Create a new event instance.
     *
     * @param Ad $ad
     */
    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('newAdChannel.'.$this->ad->id);
    }

    public function broadcastAs()
    {
        return 'newAdEvent';
    }

    public function broadcastWith()
    {
        $ad = $this->ad;

        $html = view("layouts.user.sections.requestAdItem",compact("ad"))->render();

        return [
            'result' => $html,
        ];
    }

}
