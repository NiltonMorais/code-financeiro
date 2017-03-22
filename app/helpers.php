<?php
function isRouteActive($name){
    return \Illuminate\Support\Facades\Route::currentRouteNamed($name);
}