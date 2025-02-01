<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class OnuInventoryController extends Controller
{
    public function index(): InertiaResponse
    {
        return Inertia::render('Application/OnuInventory/Index');
    }
}
