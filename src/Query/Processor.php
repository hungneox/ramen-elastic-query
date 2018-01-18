<?php

namespace Neox\Ramen\Elastic\Query;

use Nord\Lumen\Elasticsearch\Contracts\ElasticsearchServiceContract;

class Processor
{
    /**
     * @var ElasticsearchServiceContract
     */
    protected $service;

    /**
     * Processor constructor.
     *
     * @param ElasticsearchServiceContract $service
     */
    public function __construct(ElasticsearchServiceContract $service)
    {
        $this->service = $service;
    }

    public function execute(Query $query)
    {
        switch ($query->getAction()) {
            case Query::ACTION_MATCH_BY_KEY:
                return $this->findById($query);
                break;
            case Query::ACTION_DELETE_BY_KEY:
                return $this->deleteById($query);
                break;
            default:

        }
    }

    protected function findById(Query $query)
    {
        $queryBuilder = $this->service->createQueryBuilder();

        $esQuery  = $queryBuilder
                        ->createTermQuery()
                        ->setField($query->getPrimaryKey())
                        ->setValue($query->getId());

        $search = $this->service->createSearch()
                          ->setIndex($query->getCollection())
                          ->setType($query->getType())
                          ->setQuery($esQuery)
                          ->setSize($query->getSize())
                          ->setPage(1);

        // Execute the search to retrieve the results
        return $this->service->execute($search);
    }

    /**
     * @return array
     */
    protected function deleteById(Query $query)
    {
        return $this->service->deleteByQuery([
            'index' => $query->getCollection(),
            'type'  => $query->getType(),
            'body'  => [
                'query' => [
                    'term' => [
                        $query->getPrimaryKey() => $query->getId(),
                    ],
                ],
            ],
        ]);
    }
}
