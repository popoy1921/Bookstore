<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{    
    /**
     * function to create a user and create a token
     *
     * @param  Request $oRequest
     * @return void
     */
    public function registerUser(Request $oRequest)
    {
        // basic validation for the inputs can be moved to a request handler
        $aValidations = array(
            'name'      => 'required|string|max:80',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|min:8',
            'role'      => 'required|string|in:admin,user',
        );
        $oValidator = FacadesValidator::make($oRequest->all(), $aValidations);

        if ($oValidator->fails() === true) {
            return response()->json(['error' => $oValidator->errors()], 422);
        }

        $aUserData = array(
            'name'      => $oRequest->name,
            'email'     => $oRequest->email,
            'password'  => Hash::make($oRequest->password),
            'role'      => $oRequest->role,
        );

        $oUser = User::create($aUserData);
        $aReturnData = array(
            'token'   => $oUser->createToken('auth_token')->plainTextToken,
            'message' => 'You registered Successfully!',
        );
        return response()->json($aReturnData, 201);
    }
    
    /**
     * Login user and create a token for the user
     *
     * @param  Request $oRequest
     * @return void
     */
    public function loginUser(Request $oRequest) 
    {
        // basic validation for the inputs can be moved to a request handler
        $aValidations = array(
            'email'     => 'required|string|email',
            'password'  => 'required|string|min:8',
        );

        $oValidator = FacadesValidator::make($oRequest->all(), $aValidations);
        if ($oValidator->fails() === true) {
            return response()->json(['error' => $oValidator->errors()], 422);
        }

        $oUser = User::where('email', $oRequest->email)->first();
        if (isNull($oUser) === true) {
            return response()->json(['error' => 'Invalid Credentials.'], 401);
        }
        
        if (Hash::check($oRequest->password, $oUser->password) === false) {
            return response()->json(['error' => 'Invalid Credentials.'], 401);
        }

        $aReturnData = array(
            'token'   => $oUser->createToken('auth_token')->plainTextToken,
            'message' => 'You Logged In Successfully!',
        );
        return response()->json($aReturnData, 201);
    }
    
    /**
     * logout the user and desrtoy the token
     *
     * @param  mixed $oRequest
     * @return void
     */
    public function logoutUser(Request $oRequest)
    {
        $oRequest->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'User Logged Out Successfully!'], 200);
    }
}
