<?php

namespace Richpeers\LaravelSlackResources\Models;

use Illuminate\Database\Eloquent\Model;

class SlackTag extends Model
{
    /**
     * @var string
     */
    protected $table = 'slack_tags';

    /**
     * @var array
     */
    protected $fillable = [
        'body'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function resources()
    {
        return $this->belongsToMany(SlackResource::class, 'slack_resource_tag', 'tag_id', 'resource_id');
    }
}
