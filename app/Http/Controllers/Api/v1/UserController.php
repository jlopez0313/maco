<?php 

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller {

    public function getAdmin( Request $request )
    {
        $user = User::where('roles_id', '1')->first();

        if ($user && \Hash::check( $request->password, $user->password ) ) {

            return new UserResource($user);

        } else {
            return null;
        }

    }
}
