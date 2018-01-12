<?php

namespace Neox\Ramen\Elastic\Query;

class Builder
{

    protected $columns = ['*'];

    /**
     * The current query value bindings.
     *
     * @var array
     */
    public $bindings = [
        'select' => [],
        'join'   => [],
        'where'  => [],
        'order'  => [],
    ];

    protected $data;

    public function select($columns = ['*'])
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();

        return $this;
    }

    public function join()
    {
        return $this;
    }

    public function where()
    {
        return $this;
    }

    public function limit()
    {
        return $this;
    }

    public function skip($value)
    {
        return $this->offset($value);
    }

    public function offset($value)
    {
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

    }

    public function count()
    {

    }

    public function deleteRaw(array $query)
    {

    }

    public function get()
    {
        return collect($this->data);
    }
}
