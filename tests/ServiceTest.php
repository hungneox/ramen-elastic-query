<?php

namespace Neox\Ramen\Elastic\Tests;

use Neox\Ramen\Elastic\ElasticQueryService;
use Neox\Ramen\Elastic\Query\Builder;
use Neox\Ramen\Elastic\Query\Query;
use Nord\Lumen\Elasticsearch\Contracts\ElasticsearchServiceContract;
use Nord\Lumen\Elasticsearch\Search\Query\QueryBuilder;
use Nord\Lumen\Elasticsearch\Search\Search;

class ServiceTest extends TestCase
{
    public function testFindById()
    {
        $client = $this->getMockBuilder(ElasticsearchServiceContract::class)
                             ->disableOriginalConstructor()
                             ->getMockForAbstractClass();

        $client->expects($this->any())
                     ->method('createQueryBuilder')
                     ->willReturn(new QueryBuilder());

        $client->expects($this->any())
                     ->method('createSearch')
                     ->willReturn(new Search());

        $service = new ElasticQueryService($client);

        $builder = new Builder($service, new Query());

        $result = $builder
            ->use('content') // collection
            ->from('article') // type
            ->find('TIYKtQX', '_id', ['id', 'title', 'description']);


        $query = $builder->getQuery();

        $this->assertEquals('TIYKtQX', $query->getId());
        $this->assertEquals('article', $query->getType());
        $this->assertEquals('content', $query->getCollection());
        $this->assertEquals(['id', 'title', 'description'], $query->getFields());
    }
}
