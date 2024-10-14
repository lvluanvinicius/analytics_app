<?php

use Illuminate\Support\Facades\Route;

Route::view("{path?}", 'components.frontend')->where('path', '.*')->name("app.frontend");
