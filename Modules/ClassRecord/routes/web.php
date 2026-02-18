<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    // PDF and import routes will be added here; teacher routes in teacher.php
});
