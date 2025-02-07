<?php
namespace App\Http\Controllers;

use App\Traits\AdvancedQueries;
use App\Traits\JsonResponseTrait;

abstract class Controller
{
    use JsonResponseTrait, AdvancedQueries;

    protected function generateCacheKey(array $attr, array $options): string
    {
        return md5(json_encode([$attr, $options]));
    }
}
