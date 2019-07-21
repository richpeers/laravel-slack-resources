<?php

namespace Richpeers\LaravelSlackResources\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Richpeers\LaravelSlackResources\Services\FetchLinkMeta\FetchLinkMeta;

class QueueFetchLinkMeta implements ShouldQueue
{
    /**
     * @var \Richpeers\LaravelSlackResources\Models\SlackResource
     */

    public $link;

    /**
     * Create the event listener.
     *
     * @param FetchLinkMeta $link
     * @return void
     */
    public function __construct(FetchLinkMeta $link)
    {
        $this->link = $link;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $url = $event->slackResource->url;

        $meta = $this->link->getData($url);

        $event->slackResource->update([
            'meta' => json_encode($meta)
        ]);
    }
}
