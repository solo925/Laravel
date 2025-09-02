<?php

Route::middleware('auth:sanctum')->get('/me',function(Request  $request){
    return $request->user();
});
