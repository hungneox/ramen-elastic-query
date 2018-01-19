<?php

namespace Neox\Ramen\Elastic\Query;

class Query
{

    public const ACTION_MATCH_BY_KEY   = 'match';
    public const ACTION_MATCH_ALL      = 'match_all';
    public const ACTION_DELETE_BY_KEY  = 'delete';
    public const ACTION_BOOLEAN_QUERY  = 'boolean';
    public const ACTION_FULLTEXT_QUERY = 'fulltext';

    protected $action;

    protected $id;

    protected $primaryKey;

    protected $collection;

    protected $fields = ['*'];

    protected $type;

    protected $musts = [];

    protected $shoulds = [];

    protected $order;

    protected $page;

    protected $from;

    protected $size;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey ?? '_id';
    }

    /**
     * @param mixed $primaryKey
     *
     * @return Query
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param mixed $collection
     */
    public function setCollection($collection): void
    {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return WhereClause[]
     */
    public function getMustClauses()
    {
        return $this->musts;
    }

    /**
     * @param mixed $musts
     */
    public function addMust($must)
    {
        $this->musts[] = $must;

        return $this;
    }

    /**
     * @return WhereClause[]
     */
    public function getShouldClauses()
    {
        return $this->shoulds;
    }

    /**
     * @param mixed $should
     */
    public function addShould($should)
    {
        $this->shoulds[] = $should;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     *
     * @return Query
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    public function setAction($action)
    {
        if ($this->action === null) {
            $this->action = $action;
        }

        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }
}
