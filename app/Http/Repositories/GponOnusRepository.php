<?php

namespace App\Http\Repositories;

class GponOnusRepository implements \App\Http\Interfaces\GponOnusRepositoryInterface

{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getOnus()
    {
        return \App\Models\GponOnus::orderByDesc('collection_date')->get();
    }
}
