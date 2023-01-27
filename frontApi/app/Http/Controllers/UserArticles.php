<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserArticles extends Controller
{
    public function article(){
        return view('userArticle.userArticle');
    }
}
