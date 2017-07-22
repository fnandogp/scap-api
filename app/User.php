<?php

namespace App;

use App\Repositories\MandateRepository;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'enrollment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'is_department_chief'
    ];

    public function getIsDepartmentChiefAttribute()
    {
        $repo = new MandateRepository;

        return $repo->isActive($this->attributes['id']);
    }

    /**
     * RemovalRequest that have been created by the user
     */
    public function removalRequests()
    {
        return $this->hasMany(RemovalRequest::class);
    }

    /**
     * Mandates of the user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mandates()
    {
        return $this->hasMany(Mandate::class);
    }
}
