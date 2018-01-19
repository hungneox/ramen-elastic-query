<?php

namespace Neox\Ramen\Elastic\Query;

/**
 * Class WhereClause
 * @package Neox\Ramen\Elastic\Query
 */
class WhereClause
{

    protected $field;

    protected $operator;

    protected $value;

    public function __construct($field, $operator, $value)
    {
        $this->field    = $field;
        $this->operator = $operator;
        $this->value    = $value;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     *
     * @return WhereClause
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $operator
     *
     * @return WhereClause
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return WhereClause
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
