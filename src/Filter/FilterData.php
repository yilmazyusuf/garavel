<?php

namespace Garavel\Filter;


class FilterData
{
    private $filterSource;
    private $filterParamObject;
    private $validationErrorMessages;
    /**
     * @var FilterDump
     */
    private $filterDump;

    use Methods;

    /**
     * FilterData constructor.
     *
     * @param FilterSource $filterSource
     * @param Param $filterParamObject
     */
    public function __construct(FilterSource $filterSource, Param $filterParamObject)
    {
        $this->setFilterSource($filterSource);
        $this->setFilterParamObject($filterParamObject);
        $this->applyFilter();
    }


    public function applyFilter()
    {
        $this->filterDump = new FilterDump();

        $filterSource = $this->getFilterSource();

        $paramObject = $this->getFilterParamObject();
        $rules = $paramObject->getRules();
        $attributeName = $paramObject->getName();
        $attributeValue = $paramObject->getAttributeValue();

        $defaultValue = $paramObject->getDefaultValue();
        $method = $paramObject->getMethod();
        $prefix = $paramObject->getPrefix();
        $format = $paramObject->getFormat();

        $this->filterDump->attribute_name = $attributeName;
        $this->filterDump->attribute_value = $attributeValue;
        $this->filterDump->filter_method = $method;
        $this->filterDump->default_value = $defaultValue;




        if (!is_null($rules)) {

            $ruleParams = [$attributeName => $rules];
            $isRuleFailed = $this->isRulesFailed($ruleParams);

            if ($isRuleFailed === true) {
                $this->filterDump->is_validated = false;
                $this->filterDump->error_messsages = $this->getValidationErrorMessages();
                return;
            }
        }

        if($paramObject->isIsDefaultValueUsed()){
            $this->filterDump->is_default_value_used = true;

        }

        if (!is_null($prefix)) {
            $attributeName = $prefix;
            $this->filterDump->prefix = $prefix;
            $this->filterDump->is_prefix_used = true;
        }


        if (!is_null($format) && $this->isClosure($format) === true) {
            $attributeValue = call_user_func($format, $attributeValue);
            $this->filterDump->attribute_value = $attributeValue;
            $this->filterDump->is_fomatted = true;
            $this->filterDump->formatted_value = $attributeValue;

        }

        if (is_null($attributeValue)) {
            $this->filterDump->error_messsages = ['Attribute value empty'];
            return;
        }


        if ($this->isClosure($method) === true) {
            $source = call_user_func_array($method, [$filterSource->getSource(), $attributeValue]);
        } else {
            $source = Methods::$method($filterSource->getSource(), $attributeName, $attributeValue);
        }

        $filtered = $filterSource->setSource($source);
        $this->setFilterSource($filtered);

        return $this;

    }


    private function isRulesFailed(array $rules) : bool
    {

        $validator = validator(request()->all(), $rules);
        $this->setValidationErrorMessages($validator->errors()->messages());
        return $validator->fails();

    }



    public function getFilterSource() : FilterSource
    {
        return $this->filterSource;
    }

    /**
     * @param mixed $filterSource
     *
     * @return FilterData
     */
    private function setFilterSource(FilterSource $filterSource)
    {
        $this->filterSource = $filterSource;

        return $this;
    }


    private function isClosure($t)
    {

        if (is_string($t)) {
            return false;
        }

        $reflection = new \ReflectionFunction($t);
        return $reflection->isClosure();


    }

    /**
     * @return Param
     */
    private function getFilterParamObject(): Param
    {
        return $this->filterParamObject;
    }

    /**
     * @param Param $filterParamObject
     */
    private function setFilterParamObject(Param $filterParamObject)
    {
        $this->filterParamObject = $filterParamObject;
    }

    /**
     * @return FilterDump
     */
    public function getFilterDump(): array
    {
        return $this->filterDump->getDumpResponse();
    }

    /**
     * @return mixed
     */
    private function getValidationErrorMessages()
    {
        return $this->validationErrorMessages;
    }

    /**
     * @param mixed $validationErrorMessages
     * @return FilterData
     */
    private function setValidationErrorMessages($validationErrorMessages)
    {
        $this->validationErrorMessages = $validationErrorMessages;
        return $this;
    }






}
