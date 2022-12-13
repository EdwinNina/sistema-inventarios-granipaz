<?php

namespace App\Providers;

use App\Models\DetalleCompra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Observers\ProductoStockObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function($view){
            $user_role = mb_strtolower(Auth::user()?->role->nombre);
            $view->with('check_user_role', $user_role === 'administrador' ? true : false);
        });
    }
}
