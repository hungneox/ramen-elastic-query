<?php

namespace Neox\Ramen\Elastic\Query;

use Neox\Ramen\Elastic\ElasticQueryService;

class Builder
{

    /**
     * @var Query
     */
    protected $query;

    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    /**
     * @param string $db
     *
     * @return $this
     */
    public function use(string $db)
    {
        $this->query->setCollection($db);

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return $this
     */
    public function select($columns = ['*'])
    {
        $columns = is_array($columns) ? $columns : func_get_args();

        $this->query->setFields($columns);

        return $this;
    }

    /**
     * @param string $table
     *
     * @return $this
     */
    public function from(string $table)
    {
        $this->query->setType($table);

        return $this;
    }

    /**
     * @param      $column
     * @param null $operator
     * @param null $value
     *
     * @return $this
     */
    public function where($column, $operator = '=', $value = '')
    {
        $this->query->addMust(new WhereClause($column, $operator, $value))->setAction(Query::ACTION_BOOLEAN_QUERY);

        return $this;
    }

    /**
     * @param      $column
     * @param null $operator
     * @param null $value
     *
     * @return $this
     */
    public function orWhere($column, $operator = null, $value = null)
    {
        $this->query->addShould(new WhereClause($column, $operator, $value))->setAction(Query::ACTION_BOOLEAN_QUERY);

        return $this;
    }

    /**
     * @param $size
     *
     * @return $this
     */
    public function limit($size)
    {
        $this->query->setSize($size);

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function skip($value)
    {
        return $this->offset($value);
    }

    /**
     * @param $offset
     *
     * @return $this
     */
    public function offset($offset)
    {
        $this->query->setFrom($offset);

        return $this;
    }

    /**
     * @param $column
     * @param $order
     *
     * @return $this
     */
    public function orderBy($column, $order)
    {
        $this->query->setOrder([
            'column' => $column,
            'order'  => $order,
        ]);

        return $this;
    }

    public function find($id, $key = '_id', $columns = ['*'])
    {
        $this->query->setId($id)
                    ->setPrimaryKey($key)
                    ->setFields($columns)
                    ->setAction(Query::ACTION_MATCH_BY_KEY);

        return $this->execute();
    }

    public function delete($id, $column = '_id')
    {
        $this->query->setId($id)
                    ->setPrimaryKey($column)
                    ->setAction(Query::ACTION_DELETE_BY_KEY);

        return $this->execute();
    }

    public function count()
    {

    }

    public function deleteRaw(array $query)
    {
        $this->query['deleteRaw'] = $query;
    }

    public function execute()
    {
        /** @var ElasticQueryService $processor */
        $service = app(ElasticQueryService::class);

        return $service->execute($this->query);
    }

    public function get()
    {
        if ($this->query->getAction() === null) {
            $this->query->setAction(Query::ACTION_MATCH_ALL);
        }

        return $this->execute();
    }
}
