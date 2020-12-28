<?php

namespace Garavel\Filter;


/**
 * Üsüt sınıflarda belirlenen Collection burdaki metodlar ile filitrelernir
 * Trait Methods
 * @package App\Classes\Common\CollectionFilter
 */
trait Methods
{

    /**
     * Collection kümesinde verilen $key parametresi için eşitlik arar
     * @param $collection
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function equal($collection, $key, $value)
    {
        $collection = $collection->where($key, '=',$value);
        return $collection;
    }

    /**
     * Collection kümesinde verilen $key parametresi için büyük eşitlik arar
     * @param $collection
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function greaterThan($collection, $key, $value)
    {
        $collection = $collection->where($key, '>=', $value);
        return $collection;
    }

    /**
     * Collection kümesinde verilen $key parametresi için küçük eşitlik arar
     * @param $collection
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function smallerThan($collection, $key, $value)
    {
        $collection = $collection->where($key, '<=', $value);
        return $collection;
    }

    /**
     * Collection kümesinde verilen $key parametresi için küçük eşitlik arar
     * @param $collection
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function whereIn($collection, $key, $value)
    {
        $value = explode(',',$value);
        $collection = $collection->whereIn($key, $value);
        return $collection;
    }


    /**
     * Collection kümesinde verilen $key parametresi için benzerlerini bulur
     * @param $collection
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function like($collection, $key, $value)
    {
        $collection = $collection->where($key, 'LIKE', '%'.$value.'%');
        return $collection;
    }

    public static function havingEqual($collection, $key, $value)
    {
        $collection = $collection->having($key, '=', $value);
        return $collection;
    }




}