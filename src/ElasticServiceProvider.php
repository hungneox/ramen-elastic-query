<?php

namespace Neox\Ramen\Elastic;

use Laravel\Lumen\Application;
use Illuminate\Support\ServiceProvider;
use Nord\Lumen\Elasticsearch\Contracts\ElasticsearchServiceContract;
use Nord\Lumen\Elasticsearch\ElasticsearchServiceProvider;

class ElasticServiceProvider extends ServiceProvider
{
    const CONFIG_KEY = 'elasticsearch';

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->configure(self::CONFIG_KEY);
        $this->registerBindings();
    }
    /**
     * Register bindings.
     */
    protected function registerBindings()
    {
        if (!$this->app->has(ElasticsearchServiceContract::class)) {
            $this->app->register(
                ElasticsearchServiceProvider::class
            );
        }

        $this->app->singleton(ElasticService::class, function (Application $app) {
            return new ElasticService($app->make(ElasticsearchServiceProvider::class));
        });
    }
}
