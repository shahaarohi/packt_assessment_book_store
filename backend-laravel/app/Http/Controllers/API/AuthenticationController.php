<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
   
class AuthenticationController extends BaseController
{
    /**
     * Admin Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user();
            $success['token'] = $user->createToken('ApiToken')->plainTextToken;
            $success['name'] = $user->name;
            $success['isAdmin'] = $user->is_admin;
   
            return $this->sendResponse($success, 'Login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Invalid email or password.']);
        } 
    }
}