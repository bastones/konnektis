<?php

/**
 * API Routes
 */

Route::apiResource('people', 'PersonController')->only(['index', 'store', 'destroy']);
