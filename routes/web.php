<?php

/**
 * Web Routes
 */

Route::get('/{any?}', 'AppController')->where('any', '.*');
