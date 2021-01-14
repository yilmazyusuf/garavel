<?php
/**
 *
 *
 * @category
 * @package
 * @author yusuf.yilmaz
 * @since  : 13.01.2021
 */

namespace Garavel\Base\ViewComponents;


use Illuminate\Database\Eloquent\Collection;

interface SelectBoxImplementation {
    /**
     * @return Collection
     */
    public function getData() : Collection;
}