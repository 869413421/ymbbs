<?php

namespace App\Providers;

//use App\Observers\ReplyObserver;
use App\Models\Link;
use App\Models\Reply;
use App\Observers\LinkObserver;
use App\Observers\ReplyObserver;
use App\Observers\TopicObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\Topic;

//use App\Models\Reply;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale('zh');
        Topic::observe(TopicObserver::class);
        Reply::observe(ReplyObserver::class);
        Link::observe(LinkObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
    }
}
