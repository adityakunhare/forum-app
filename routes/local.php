<?php

use App\Support\PostFixtures;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function(){

    Route::get('post-autofill', function(){
        return PostFixtures::getFixtures()->random(); 
    })->name('local.autofill');
});

Route::middleware('web')->group(function(){

});
