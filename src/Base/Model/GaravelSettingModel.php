<?php

namespace Garavel\Model;

use Garavel\Eloquent\Scopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class GaravelSettingModel extends Model {

    use SoftDeletes;
    use Scopes;

    protected $table = "settings";


}
