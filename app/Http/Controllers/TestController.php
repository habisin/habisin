<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class TestController extends Controller
{
    public function index() {
        $result = Storage::disk("s3")->put("test.txt", "This is a test file.");

        dd($result);
    }
}
