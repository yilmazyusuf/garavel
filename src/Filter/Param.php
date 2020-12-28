<?php

namespace Garavel\Filter;


class Param
{


    private $name           = null;
    private $method         = null;
    private $prefix         = null;
    private $format         = null;
    private $rules          = null;
    private $defaultValue   = null;
    private $attributeValue = null;
    private $isDefaultValueUsed = false;

    /**
     * Param constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->setName($name );
    }

    /**
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param mixed $rules
     * @return Param
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
        return $this;
    }





    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this|Param
     */
    private function setName($name) : Param
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return Param
     */
    public function setMethod($method) : Param
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param mixed $prefix
     * @return $this|Param
     */
    public function setPrefix($prefix) : Param
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     * @return $this|Param
     */
    public function setFormat($format) : Param
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     * @return Param
     */
    public function setDefaultValue($defaultValue) : Param
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * @return null
     */
    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    /**
     * @param null $attributeValue
     * @return Param
     */
    public function setAttributeValue($attributeValue)
    {
        $this->attributeValue = $attributeValue;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsDefaultValueUsed(): bool
    {
        return $this->isDefaultValueUsed;
    }

    /**
     * @param boolean $isDefaultValueUsed
     * @return Param
     */
    public function setIsDefaultValueUsed(bool $isDefaultValueUsed): Param
    {
        $this->isDefaultValueUsed = $isDefaultValueUsed;
        return $this;
    }






}