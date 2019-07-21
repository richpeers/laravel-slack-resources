<?php

namespace Richpeers\LaravelSlackResources\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Log;
use Richpeers\LaravelSlackResources\Models\SlackResource;

class SlackResourceSaved
{
    use Dispatchable, SerializesModels;

    /**
     * @var SlackResource
     */
    public $slackResource;

    /**
     * Create a new event instance.
     *
     * @param SlackResource $slackResource
     * @return void
     */
    public function __construct(SlackResource $slackResource)
    {
        $this->slackResource = $slackResource;
    }
}
