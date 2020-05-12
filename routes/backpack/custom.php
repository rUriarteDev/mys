<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
    ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () {
    //Route::get('/congruencia/fundamental', 'CongruenciaFundamental@formularioCargaCF')->name('formularioCargaCF');
    //Route::post('/congruencia/fundamental/calcular', 'CongruenciaFundamental@calcularCF')->name('calcularCF');
    // custom admin routes
    Route::get('charts/grafico-resultado', 'Charts\GraficoResultadoChartController@response');
}); // this should be the absolute last line of this file