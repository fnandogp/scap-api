<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'removal_request_id',
        'name',
        'extension',
        'mime',
        'path',
        'size'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function removalRequest()
    {
        return $this->belongsTo(RemovalRequest::class);
    }
}
