<?php

namespace App\Controllers;

use App\Core\App;

class PageController {
    public function index()
    {
        $words = App::get('database')->selectAll('words', $_SESSION['user']['id'], 'desc');

        /** returning json for rest api call
         *  return response($words, 200);
         */

        return view('index', compact('words'));
    }
}