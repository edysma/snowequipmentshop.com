<?php

Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'taxes', 'as' => 'tax.'], function () {
            Route::resource('', 'TaxController')->parameters(['' => 'tax']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'TaxController@deletes',
                'permission' => 'tax.destroy',
            ]);

            Route::get('add-country-tax', [
                'as'         => 'addCountryTax',
                'uses'       => 'TaxController@addCountryTax',
                'permission' => 'tax.index',
            ]);
            Route::post('add-country-tax', [
                'as'         => 'saveCountryTax',
                'uses'       => 'TaxController@saveCountryTax',
                'permission' => 'tax.index',
            ]);
            Route::get('edit-country-tax/{id}', [
                'as'         => 'editCountryTax',
                'uses'       => 'TaxController@editCountryTax',
                'permission' => 'tax.index',
            ]);

            Route::post('edit-country-tax/{id}', [
                'as'         => 'updateCountryTax',
                'uses'       => 'TaxController@updateCountryTax',
                'permission' => 'tax.index',
            ]);

            Route::get('delete-country-tax/{id}', [
                'as'         => 'deleteCountryTax',
                'uses'       => 'TaxController@deleteCountryTax',
                'permission' => 'tax.destroy',
            ]);
        });
    });
});
