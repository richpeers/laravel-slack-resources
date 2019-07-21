<?php

namespace Richpeers\LaravelSlackResources\Models;

use Illuminate\Database\Eloquent\Model;

class SlackResource extends Model
{
    /**
     * @var string
     */
    protected $table = 'slack_resources';

    /**
     * @var array
     */
    protected $fillable = [
        'url',
        'source',
        'meta'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(SlackTag::class, 'slack_resource_tag', 'resource_id', 'tag_id');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getSourceAttribute($value)
    {
        return \json_decode($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getMetaAttribute($value)
    {
        return \json_decode($value);
    }
}
