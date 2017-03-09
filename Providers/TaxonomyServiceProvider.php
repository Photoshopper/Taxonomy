<?php

namespace Modules\Taxonomy\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;

class TaxonomyServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    public function boot()
    {
        $this->publishConfig('taxonomy', 'permissions');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Taxonomy\Repositories\VocabularyRepository',
            function () {
                $repository = new \Modules\Taxonomy\Repositories\Eloquent\EloquentVocabularyRepository(new \Modules\Taxonomy\Entities\Vocabulary());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Taxonomy\Repositories\Cache\CacheVocabularyDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Taxonomy\Repositories\TermRepository',
            function () {
                $repository = new \Modules\Taxonomy\Repositories\Eloquent\EloquentTermRepository(new \Modules\Taxonomy\Entities\Term());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Taxonomy\Repositories\Cache\CacheTermDecorator($repository);
            }
        );
// add bindings


    }
}
