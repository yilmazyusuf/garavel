<?php
/**
 *
 *
 * @category
 * @package
 * @author yusuf.yilmaz
 * @since  : 23.03.2020
 */



namespace Garavel\Filter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

class FilterSource {

    private $source = null;

    /**
     * @return EloquentBuilder|Collection|QueryBuilder
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param null $source
     *
     * @return FilterSource
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }






}

