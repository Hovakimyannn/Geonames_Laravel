<?php

namespace App\Http\Controllers;

use File;

class MapController extends Controller
{
    public function store()
    {
        $content = File::get();
    }

    public function fill()
    {
        $file = '../../../RU/';
        var_dump($file);


    }
}
