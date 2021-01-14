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


abstract class SelectBoxAbstract {

    public $class = '';
    public $id = 'select_box_id';
    public $name = 'select_box_name';
    public $isMultiple = false;
    public $useSelect2 = false;
    public $constructMap = [
        'value' => 'id',
        'text'  => 'name'
    ];

    /*
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view('adminlte::components.selectbox', ['selectBox' => $this]);
    }
}