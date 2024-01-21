<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        TelegramBotApiContract::class => TelegramBotApi::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* Model::shouldBeStrict(!app()->isProduction());

        if (app()->isProduction()) {

            DB::listen(function ($query) {
                if ($query->time > 1) {
                    logger()
                        ->channel('telegram')
                        ->debug('Query time = ' . $query->time, [$query->sql]);
                }
            });

            $kernel = app(Kernel::class);

            $kernel->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()
                        ->channel('telegram')
                        ->debug('whenReqestLifecycleLongerThan: ' . request()->url());
                }
            );
        } */

        /* DB::beforeExecuting(function($query, $params){
            echo '<div>';
            var_dump($query);
            var_dump($params);
            echo '<hr>';
            echo '</div>';
        }); */
    }
}
