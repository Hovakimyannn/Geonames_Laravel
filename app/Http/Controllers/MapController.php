<?php

namespace App\Http\Controllers;

use File;

class MapController extends Controller
{
    public function store()
    {
        $content = File::get();
    }
}
