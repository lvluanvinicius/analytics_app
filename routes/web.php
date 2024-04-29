<?php

use Illuminate\Support\Facades\Route;

Route::view("app/{path?}", 'components.frontend')->where('path', '.*')->name("react.website.my-invoices");
