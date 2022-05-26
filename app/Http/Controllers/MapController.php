<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MapController extends Controller
{
    public function store()
    {
        $content = Storage::disk()->get('RU.txt');
        dd($content);
        $content = explode("\n", $content);
        array_pop($content);
        $arr = [];
        foreach ($content as $item) {
            $arr[] = explode("\t", $item);
        }


    }

    public function fill()
    {
        $file = '../../../RU/';
        var_dump($file);


    }
}
