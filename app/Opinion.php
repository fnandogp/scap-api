<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    protected $fillable = [
        'removal_request_id',
        'user_id',
        'type',
        'reason'
    ];

    /**
     * The removal request that the opinion belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function removalRequest()
    {
        return $this->belongsTo(RemovalRequest::class);
    }

    /**
     * The author of the opinion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
