<?php

Route::when( '*', 'csrf', ['post', 'put', 'patch', 'delete'] );
Route::get( '/', 'HomeController@index' );
Route::get( '/login', 'HomeController@login' );
Route::post( '/login', 'HomeController@postLogin' );

Route::group( ['prefix' => 'admin', 'before' => 'auth'], function() {

    Route::group( ['prefix' => 'super'], function() {
        Route::get( '/logout', 'SuperAdminController@logout' );

        Route::group( ['before'=>'existing.system'], function() {
            Route::get( '/create/system', 'SuperAdminController@system' );
            Route::post( '/create/system', 'SuperAdminController@postSystem' );
        });

        Route::group( ['before'=>'existing.user'], function() {
            Route::get( '/activate', 'SuperAdminController@activate' );
            Route::post( '/activate', 'SuperAdminController@postActivate' );
        });

        Route::group( ['before' => 'new.user|new.system'], function() {
            Route::get( '/', 'SuperAdminController@index' );
            Route::get( '/lists', 'SuperAdminController@lists' );
            Route::get( '/create', 'SuperAdminController@create' );
            Route::post( '/create', 'SuperAdminController@postCreate' );
            Route::get( '/update/{id}', 'SuperAdminController@update' );
            Route::post( '/update', 'SuperAdminController@postUpdate' );
            Route::get( '/delete/{id}', 'SuperAdminController@delete' );
            Route::get( '/profile', 'SuperAdminController@profile' );
            Route::post( '/profile', 'SuperAdminController@postProfile' );

            Route::group( ['prefix' => 'transaction'], function() {
                Route::get( '/', 'SuperAdminTransactionController@index' );

                Route::group( ['before' => 'transaction.complete'], function() {
                    Route::get( '/process/{id}', 'SuperAdminTransactionController@process' );
                    Route::post( '/process', 'SuperAdminTransactionController@postProcess' );
                });
            });

            Route::group( ['prefix' => 'report'], function() {
                Route::get( '/user/excel', 'SuperAdminReportController@userExcel' );
                Route::get( '/user/pdf', 'SuperAdminReportController@userPdf' );
                Route::get( '/transaction/excel', 'SuperAdminReportController@transactionExcel');
                Route::get( '/transaction/pdf', 'SuperAdminReportController@transactionPdf');
            });

        });
    });

    Route::group( ['prefix' => 'regular'], function() {
        Route::get( '/logout', 'RegularAdminController@logout' );

        Route::group( ['before'=>'existing.user'], function() {
            Route::get( '/activate', 'RegularAdminController@activate' );
            Route::post( '/activate', 'RegularAdminController@postActivate' );
        });

        Route::group( ['before' => 'new.user'], function() {
            Route::get( '/', 'RegularAdminController@index' );
            Route::get( '/lists', 'RegularAdminController@lists' );
            Route::get( '/create', 'RegularAdminController@create' );
            Route::post( '/create', 'RegularAdminController@postCreate' );
            Route::get( '/update/{id}', 'RegularAdminController@update' );
            Route::post( '/update', 'RegularAdminController@postUpdate' );
            Route::get( '/delete/{id}', 'RegularAdminController@delete' );
            Route::get( '/profile', 'RegularAdminController@profile' );
            Route::post( '/profile', 'RegularAdminController@postProfile' );

            Route::group( ['prefix'=>'transaction'], function() {
                Route::get( '/', 'RegularAdminTransactionController@index' );

                Route::group( ['before'=>'transaction.complete'], function() {
                    Route::get( '/process/{id}', 'RegularAdminTransactionController@process' );
                    Route::post( '/process', 'RegularAdminTransactionController@postProcess' );
                });
            });

            Route::group( ['prefix' => 'report'], function() {
                Route::get( '/user/excel', 'RegularAdminReportController@userExcel' );
                Route::get( '/user/pdf', 'RegularAdminReportController@userPdf' );
                Route::get( '/transaction/excel', 'RegularAdminReportController@transactionExcel');
                Route::get( '/transaction/pdf', 'RegularAdminReportController@transactionPdf');
            });

        });
    });
});

Route::group( ['prefix' => 'user', 'before' => 'auth'], function(){

    Route::group( ['prefix' => 'ultimate'], function(){
        Route::get( '/logout', 'UltimateUserController@logout' );

        Route::group( ['before'=>'existing.user'], function() {
            Route::get( '/activate', 'UltimateUserController@activate' );
            Route::post( '/activate', 'UltimateUserController@postActivate' );
        });

        Route::group( ['before' => 'new.user'], function() {
            Route::get( '/', 'UltimateUserController@index' );
            Route::get( '/lists', 'UltimateUserController@lists' );
            Route::get( '/create', 'UltimateUserController@create' );
            Route::post( '/create', 'UltimateUserController@postCreate' );
            Route::get( '/update/{id}', 'UltimateUserController@update' );
            Route::post( '/update', 'UltimateUserController@postUpdate' );
            Route::get( '/delete/{id}', 'UltimateUserController@delete' );
            Route::get( '/profile', 'UltimateUserController@profile' );
            Route::post( '/profile', 'UltimateUserController@postProfile' );
            Route::get( '/account', 'UltimateUserAccountController@index');
            Route::get( '/account/payment', 'UltimateUserAccountController@payment');
            Route::post( '/account/payment', 'UltimateUserAccountController@postPayment');
        });

        Route::group( ['prefix' => 'report'], function() {
            Route::get( '/user/excel', 'UltimateUserReportController@userExcel' );
            Route::get( '/user/pdf', 'UltimateUserReportController@userPdf' );
            Route::get( '/transaction/excel', 'UltimateUserReportController@transactionExcel');
            Route::get( '/transaction/pdf', 'UltimateUserReportController@transactionPdf');
        });
    });

    Route::group( ['prefix'=>'regular'], function() {
        Route::get( '/logout', 'RegularUserController@logout' );

        Route::group( ['before'=>'existing.user'], function() {
            Route::get( '/activate', 'RegularUserController@activate' );
            Route::post( '/activate', 'RegularUserController@postActivate' );
        });

        Route::group( ['before' => 'new.user'], function() {
            Route::get( '/', 'RegularUserController@index' );
            Route::get( '/lists', 'RegularUserController@lists' );
            Route::get( '/create', 'RegularUserController@create' );
            Route::post( '/create', 'RegularUserController@postCreate' );
            Route::get( '/update/{id}', 'RegularUserController@update' );
            Route::post( '/update', 'RegularUserController@postUpdate' );
            Route::get( '/delete/{id}', 'RegularUserController@delete' );
            Route::get( '/profile', 'RegularUserController@profile' );
            Route::post( '/profile', 'RegularUserController@postProfile' );
            Route::get( '/account', 'RegularUserAccountController@index');
            Route::get( '/account/payment', 'RegularUserAccountController@payment');
            Route::post( '/account/payment', 'RegularUserAccountController@postPayment');
        });

        Route::group( ['prefix' => 'report'], function() {
            Route::get( '/user/excel', 'RegularUserReportController@userExcel' );
            Route::get( '/user/pdf', 'RegularUserReportController@userPdf' );
            Route::get( '/transaction/excel', 'RegularUserReportController@transactionExcel');
            Route::get( '/transaction/pdf', 'RegularUserReportController@transactionPdf');
        });
    });


});