<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class DemoController extends Controller
{
    public function index(): View
    {

        $folders = Storage::disk('demo')->directories();

        return view('demos.index', compact('folders'));
    }

    public function fileList(String $folder): View
    {
        $files = Storage::disk('demo')->allFiles($folder);

        return view('demos.file-list', compact('folder', 'files'));
    }

    public function fileDetails(String $folder, String $file): View
    {
        // if(!view()->exists($folder.'.'.$file){
        // }
        return view('demos.' . $folder . '.' . $file);
    }

}
