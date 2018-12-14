<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;

class AdminController extends Controller
{

        public function __construct()

        {
            $this->middleware('auth');
        }

        public function admin()

        {
            $questions = Question::paginate(6);
            return view('home')->with('questions', $questions);
        }

}


