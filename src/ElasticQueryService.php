<?php

namespace Neox\Ramen\Elastic;

use Neox\Ramen\Elastic\Query\Query;
use Nord\Lumen\Elasticsearch\Contracts\ElasticsearchServiceContract;
use Nord\Lumen\Elasticsearch\Search\Query\QueryDSL;

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
            case Query::ACTION_MATCH_ALL:
                return $this->matchAll($query);
                break;
            case Query::ACTION_DELETE_BY_KEY:
                return $this->deleteById($query);
                break;
            case Query::ACTION_BOOLEAN_QUERY:
                return $this->booleanQuery($query);
                break;
            default:

        }
    }

    /**
     * @param Query $query
     *
     * @return \Nord\Lumen\Elasticsearch\Search\Search
     */
    protected function createSearch(Query $query)
    {
        return $this->client->createSearch()
                   ->setIndex($query->getCollection())
                   ->setType($query->getType())
                   ->setSource($query->getFields())
                   ->setSize($query->getSize())
                   ->setPage(1);
    }

    /**
     * @param Query $query
     *
     * @return array
     */
    protected function findById(Query $query)
    {
        $queryBuilder = $this->client->createQueryBuilder();

        $esQuery = $queryBuilder
            ->createTermQuery()
            ->setField($query->getPrimaryKey())
            ->setValue($query->getId());

        $search = $this->createSearch($query)->setQuery($esQuery);

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

    /**
     * @param $query
     */
    protected function matchAll($query)
    {
        $search = $this->createSearch($query);

        // Execute the search to retrieve the results
        return $this->client->execute($search);
    }

    /**
     * @param $query
     */
    protected function booleanQuery(Query $query)
    {
        $queryBuilder = $this->client->createQueryBuilder();

        $esQuery = $queryBuilder->createBoolQuery();

        foreach($query->getMustClauses() as $must) {
            $esQuery->addMust($this->createTermQuery($must));
        }

        foreach($query->getShouldClauses() as $should) {
            $esQuery->addShould($this->createTermQuery($should));
        }

        $search = $this->createSearch($query)->setQuery($esQuery);

        // Execute the search to retrieve the results
        return $this->client->execute($search);
    }

    /**
     * @param array $must
     *
     * @return QueryDSL
     */
    protected function createTermQuery(array $must): QueryDSL
    {
        return $this->client->createQueryBuilder()
            ->createTermQuery()
            ->setField($must['field'])
            ->setValue($must['value']);
    }

}
