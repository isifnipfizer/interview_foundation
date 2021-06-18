<?php
namespace App\Http\Traits;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

trait TokenTrait
{
    public function storeToken(Request $request)
    {
        $validated = $request->validate([
            'gtoken' => 'required|string',
        ]);
        if (!$validated) {
            return false;
        }
        Auth::user()->github_token = Crypt::encryptString($request->gtoken);
        Auth::user()->save();
        return response()->json(["gtoken" => $this->getDecryptedToken()]);
    }

    public function getDecryptedToken()
    {
        return !isset(Auth::user()->github_token)?'':Crypt::decryptString(Auth::user()->github_token);
    }
}
