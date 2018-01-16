<?php

namespace Neox\Ramen\Elastic\Query;

use Nord\Lumen\Elasticsearch\Contracts\ElasticsearchServiceContract;

class Builder
{
    /**
     * The current query value bindings.
     *
     * @var array
     */
    public $query = [
        'use'     => [], // database. collection
        'columns' => ['*'], // select
        'from'    => [], // table, type
        'where'   => [],
        'order'   => [],
        'offset'  => [],
        'delete'  => []
    ];

    protected $data;

    protected $search;

    /**
     * Builder constructor.
     *
     * @param ElasticsearchServiceContract $service
     */
    public function __construct(ElasticsearchServiceContract $service)
    {
        $this->search = $service;
    }

    public function select($columns = ['*'])
    {
        $this->query['columns'] = is_array($columns) ? $columns : func_get_args();

        return $this;
    }

    //public function join()
    //{
    //    return $this;
    //}

    public function from(string $table)
    {
        $this->query['from'] = $table;

        return $this;
    }

    public function where($column, $operator = null, $value = null)
    {
        $this->query['wheres'][] = [
            'field'    => $column,
            'operator' => $operator,
            'value'    => $value,
        ];

        return $this;
    }

    public function orWhere($column, $operator = null, $value = null)
    {
        $this->query['orWheres'][] = [
            'field'    => $column,
            'operator' => $operator,
            'value'    => $value,
        ];

        return $this;
    }

    public function limit($size)
    {
        $this->query['limit'] = $size;

        return $this;
    }

    public function skip($value)
    {
        return $this->offset($value);
    }

    public function offset($offset)
    {
        $this->query['offset'] = $offset;

        return $this;
    }

    public function orderBy($column, $oder)
    {
        return $this;
    }

    public function find($id, $columns = ['*'])
    {

    }

    public function delete($id)
    {
        $this->query['delete'][] = $id;
    }

    public function count()
    {

    }

    public function deleteRaw(array $query)
    {
        $this->query['deleteRaw'] = $query;
    }

    public function get()
    {
        return collect($this->data);
    }
}
