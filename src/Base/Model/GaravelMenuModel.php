<?php

namespace Garavel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
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
class GaravelMenuModel extends Model {

    use SoftDeletes;
    use Scopes;

    protected $table = "adminlte_menus";

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }


}
