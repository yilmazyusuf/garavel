<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 26.03.2020
 * Time: 13:07
 */

namespace Garavel\Filter;


class FilterDump
{

    /**
     * @var null
     */
    public $attribute_name = null;
    /**
     * @var null
     */
    public $attribute_value = null;

    /**
     * @var null
     */
    public $prefix = null;
    /**
     * @var bool
     */
    public $is_prefix_used = false;
    /**
     * @var null
     */
    public $filter_method = null;
    /**
     * @var bool
     */
    public $is_fomatted = false;
    /**
     * @var null
     */
    public $formatted_value = null;
    /**
     * @var null
     */
    public $default_value = null;
    /**
     * @var bool
     */
    public $is_default_value_used = false;
    /**
     * @var bool
     */
    public $is_validated = true;
    /**
     * @var array
     */
    public $error_messsages = [];


    public function getDumpResponse() :array
    {
        return [
            'is' => [
                'valid' => $this->is_validated,
                'prefix_used' => $this->is_prefix_used,
                'default_value_used' => $this->is_prefix_used,
                'formatted' => $this->is_fomatted,
            ],
            'name' => $this->attribute_name,
            'prefix' => $this->prefix,
            'method' => $this->filter_method,
            'value' => [
                'attribute' => $this->attribute_value,
                'formatted' => $this->formatted_value,
                'default' => $this->default_value
            ],
            'error_messages' => $this->error_messsages
        ];
    }


}