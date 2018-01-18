<?php

namespace Neox\Ramen\Elastic;

use Laravel\Lumen\Application;
use Illuminate\Support\ServiceProvider;
use Neox\Ramen\Elastic\Query\Processor;
use Nord\Lumen\Elasticsearch\Contracts\ElasticsearchServiceContract;

class ElasticServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        if (!$this->app->has(ElasticsearchServiceContract::class)) {
            $this->app->register(\Nord\Lumen\Elasticsearch\ElasticsearchServiceProvider::class);
        }

        $this->app->singleton(ElasticService::class, function (Application $app) {
            return new ElasticService($app->make(ElasticsearchServiceContract::class));
        });

        $this->app->singleton(Processor::class, function (Application $app) {
            return new Processor($app->make(ElasticsearchServiceContract::class));
        });
    }
}
