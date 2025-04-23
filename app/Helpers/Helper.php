<?php

use Illuminate\Support\Facades\Route;

function set_active($route) {
    $active = 'actives';
    if(is_array($route)){
        foreach ($route as $r) {
            if(Route::is($r)) {
                return $active;
            }
        }
    }else{
        if(Route::is($route)) {
            return $active;
        }
    }
}
function set_home_active($route) {
    $active = 'active';
    if(is_array($route)){
        foreach ($route as $r) {
            if(Route::is($r)) {
                return $active;
            }
        }
    }else{
        if(Route::is($route)) {
            return $active;
        }
    }
}
