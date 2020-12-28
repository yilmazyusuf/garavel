<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 19.03.2020
 * Time: 16:43
 */

namespace Garavel\Filter;


class ParamRuleStorage extends \SplObjectStorage
{

    /**
     * @return array
     */
    protected function all(): array
    {
        $temp = array();
        foreach ($this as $param) {
            $temp[] = $param;
        }

        return $temp;
    }

}