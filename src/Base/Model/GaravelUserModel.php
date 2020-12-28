<?php

namespace Garavel\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Garavel\Eloquent\Mutators;
use Garavel\Eloquent\Scopes;

/**
 *
 *
 * @category Base
 * @package  TMD Core
 * @author   yusuf.yilmaz
 * @since    : 22.01.2020
 *
 * @method static Scopes status(int $status)
 */
class GaravelUserModel extends Authenticatable {

    use Notifiable;
    use SoftDeletes;
    use Scopes;
    use Mutators;
    use HasRoles;

    protected  $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guard_name = 'web';

    /**
     * Scope a query to only include active users.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->whereStatus(1)->whereNull('deleted_at');
    }


}
