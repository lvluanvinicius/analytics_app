<?php
namespace App\Http\Controllers;

use App\Traits\AdvancedQueries;
use App\Traits\JsonResponseTrait;

abstract class Controller
{
    use JsonResponseTrait, AdvancedQueries;
}
