<?php

namespace App\Providers;

use App\Models\OrderList;
use App\Models\Service;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
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

        if (Schema::hasTable('services')) {

            $servicesList = Service::all();

            View::composer('*', function ($view) use ($servicesList) {
                $view->with(compact('servicesList'));
            });

        }

        if (Schema::hasTable('order_list')) {

            view()->composer('layouts.website-main', function ($view)
            {
                if(auth()->user()){
                    $orderList = OrderList::where('user_id', auth()->user()->id)
                        ->whereNull('order_id')
                        ->get();

                    $view->with(compact('orderList'));
                }
            });

        }

    }
}