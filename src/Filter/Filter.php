<?php

namespace Garavel\Filter;

use Exception;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;


/**
 * @todo   More Methods, Tests
 * Eloquent Collectionların filitrelenmesini sağlar
 * @author Yusuf Yılmaz
 * Class Filter
 * @package App\Classes\Common\CollectionFilter
 */
abstract class Filter extends ParamRuleStorage implements iFilter
{


    private $filterSource;
    protected $params = [];


    public const METHOD_EQUAL = 'equal';
    public const METHOD_GREATER_THAN = 'greaterThan';
    public const METHOD_SMALLER_THAN = 'smallerThan';
    public const METHOD_WHEREIN = 'whereIn';
    public const METHOD_LIKE = 'like';
    public const METHOD_HAVING_EQUAL = 'havingEqual';

    /**
     * Filitrelenmek istenen değerin adı
     */
    public const PARAM_NAME = 'name';

    /**
     *Uygulanacak filitrenin kuralları (Laravel Validation)
     */
    public const PARAM_RULES = 'rules';

    /**
     *Filitre Metodu
     */
    public const PARAM_METHOD = 'method';

    /**
     * Parametre adı farklı ise
     */
    public const PARAM_PREFIX = 'prefix';

    /**
     * Parametre varsayılan değeri
     */
    public const PARAM_DEFAULT_VALUE = 'default_value';

    /**
     * Parametre varsayılan değeri
     */
    public const PARAM_FORMAT_VALUE = 'format';



    private $dump = [];


    /**
     * Eloquent Collection set ediliyor
     * Filter constructor.
     *
     * @param $filterSource
     *
     * @throws Exception
     */
    public function __construct($filterSource)
    {
        $this->filterSource = new FilterSource();
        $this->filterSource->setSource($filterSource);
        $this->apply();
    }

    /**
     * @throws Exception
     */
    private function apply()
    {

        $getFilters = $this->initFilters();

        foreach ($getFilters as $filterParamObject) {

            $filterObject = $this->getFilterParam($filterParamObject);
            $attributeName = $filterObject->getName();
            $defaultValue = $filterObject->getDefaultValue();
            $attributeValue = null;

            if (is_null($attributeName)) {
                throw new Exception('Parameter Name required');
            }

            if (is_null($filterObject->getMethod())) {
                throw new Exception('Method Name  or Method Clousure required');
            }


            if (request()->has($attributeName)) {
                $attributeValue = request()->input($attributeName);
            }

            //Check Default
            if (is_null($attributeValue) && !is_null($defaultValue)) {
                request()->request->set($attributeName, $defaultValue);
                $attributeValue = request()->input($attributeName);
                $filterObject->setIsDefaultValueUsed(true);
            }


            $filterObject->setAttributeValue($attributeValue);
            $filterData = new FilterData($this->filterSource, $filterObject);
            $filteredCollection = $filterData->getFilterSource();

            $dump = $filterData->getFilterDump();
            $this->setDump($dump);

            if (is_null($attributeValue)) {
                continue;
            }

            $this->filterSource = $filteredCollection;

        }

        return $this->filterSource;

    }

    private function initFilters() : array
    {

        $filters = $this->filters();

        if (count($filters) == 0) {
            throw new Exception('Filter array must contain minimum 1 element');
        }

        foreach ($filters as $filter) {

            if (!isset($filter[self::PARAM_NAME])) {
                throw new Exception('Parameter name required (FILTER::PARAM_NAME)');
            }


            if (!isset($filter[self::PARAM_METHOD])) {
                throw new Exception("Parameter method required (FILTER::PARAM_METHOD) for '{$filter[self::PARAM_NAME]}'");
            }


            $filterParam = new Param($filter[self::PARAM_NAME]);
            $filterParam->setMethod($filter[self::PARAM_METHOD]);

            if (isset($filter[self::PARAM_RULES])) {
                $filterParam->setRules($filter[self::PARAM_RULES]);
            }

            if (isset($filter[self::PARAM_PREFIX])) {
                $filterParam->setPrefix($filter[self::PARAM_PREFIX]);
            }

            if (isset($filter[self::PARAM_DEFAULT_VALUE])) {
                $filterParam->setDefaultValue($filter[self::PARAM_DEFAULT_VALUE]);
            }

            if (isset($filter[self::PARAM_FORMAT_VALUE])) {
                $filterParam->setFormat($filter[self::PARAM_FORMAT_VALUE]);
            }

            parent::attach($filterParam);

        }

        return parent::all();
    }


    /**
     * @return EloquentBuilder
     */
    public function getEloquentBuilder(): EloquentBuilder
    {
        return $this->getFiltered();
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->getFiltered();
    }

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->getFiltered();
    }

    private function getFiltered()
    {
        return $this->filterSource->getSource();
    }


    /**
     * @param $param
     *
     * @return Param
     */
    private function getFilterParam($param): Param
    {
        return $param;
    }

    /**
     * @return array
     */
    public function getDump(): array
    {
        return dd($this->dump);
    }

    /**
     * @param array $dump
     */
    private function setDump(array $dump)
    {
        $this->dump[] = $dump;
    }

}
