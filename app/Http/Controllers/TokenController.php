<?php

namespace App\Http\Controllers;

use App\Http\Traits\TokenTrait;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    use TokenTrait;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return $this->storeToken($request);
    }
}
