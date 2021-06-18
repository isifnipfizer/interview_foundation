<?php

namespace App\Http\Controllers;

use App\Http\Traits\TokenTrait;
use Illuminate\Http\Request;
use GrahamCampbell\GitHub\Facades\GitHub;

class GithubRepositories extends Controller
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
        try {
            $authenticate = GitHub::authenticate($this->getDecryptedToken(), '', 'access_token_header');
            $repos = GitHub::api('current_user')->starring()->all();
            return response()->json($repos);
        } catch (\Exception $ex) {
            return response()->json(["error_message" => $ex->getMessage()], 500);
        }
    }
}
