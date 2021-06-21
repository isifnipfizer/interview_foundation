<?php

namespace App\Http\Controllers;

use App\Http\Traits\TokenTrait;
use Illuminate\Http\Request;

/**
 * The main dashboard controller of the application.
 */
class HomeController extends Controller
{
    use TokenTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ["gtoken" => $this->getDecryptedToken()]);
    }
}
