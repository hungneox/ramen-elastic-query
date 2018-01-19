<?php

namespace Neox\Ramen\Elastic;

use Neox\Ramen\Elastic\Query\Query;
use Nord\Lumen\Elasticsearch\Contracts\ElasticsearchServiceContract;

/**
 * Class ElasticQueryService
 * @package Neox\Ramen\Elastic
 */
class ElasticQueryService
{
    protected $client;

    /**
     * ElasticService constructor.
     *
     * @param ElasticsearchServiceContract $client
     */
    public function __construct(ElasticsearchServiceContract $client)
    {
        $this->client = $client;
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
        $queryBuilder = $this->client->createQueryBuilder();

        $esQuery  = $queryBuilder
            ->createTermQuery()
            ->setField($query->getPrimaryKey())
            ->setValue($query->getId());

        $search = $this->client->createSearch()
                                ->setIndex($query->getCollection())
                                ->setType($query->getType())
                                ->setQuery($esQuery)
                                ->setSource($query->getFields())
                                ->setSize($query->getSize())
                                ->setPage(1);

        // Execute the search to retrieve the results
        return $this->client->execute($search);
    }

    /**
     * @return array
     */
    protected function deleteById(Query $query)
    {
        return $this->client->deleteByQuery([
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
