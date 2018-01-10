<?php

namespace Neox\Ramen\Elastic;

use Nord\Lumen\Elasticsearch\Contracts\ElasticsearchServiceContract;

/**
 * Class ElasticService
 * @package Neox\Ramen\Elastic
 */
class ElasticService
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
}
