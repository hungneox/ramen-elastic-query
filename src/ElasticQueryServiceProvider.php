<?php

namespace Neox\Ramen\Elastic;

use Laravel\Lumen\Application;
use Illuminate\Support\ServiceProvider;
use Neox\Ramen\Elastic\Query\Builder;
use Neox\Ramen\Elastic\Query\Query;
use Nord\Lumen\Elasticsearch\Contracts\ElasticsearchServiceContract;

class ElasticQueryServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        if (!$this->app->has(ElasticsearchServiceContract::class)) {
            $this->app->register(\Nord\Lumen\Elasticsearch\ElasticsearchServiceProvider::class);
        }

        $this->app->singleton(ElasticQueryService::class, function (Application $app) {
            return new ElasticQueryService($app->make(ElasticsearchServiceContract::class));
        });

        $this->app->bind('es', function(Application $app)  {
            return new Builder($app->make(ElasticQueryService::class), new Query());
        });
    }
}
