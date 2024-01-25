<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Employee;
use App\Traits\ResponseApi;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{

    use ResponseApi;

    public function login(LoginRequest $request)
    {
        try{
            if(!Auth::guard('api')->attempt($request->only(['email','password'])))
            {
                return $this->responseError('Password & Email does not match with', 401);
            }
            
            $employee = Employee::where('email', $request->email)->first();
            $token = $employee->createToken('restaurant')->plainTextToken;
            return $this->responseSuccess('employee logged In successfully',$token);

        }catch(Throwable $th){
            return $this->responseException($th->getMessage());
        }
    }

    public function update(LoginRequest $request)
    {
        try{
            $employee = Auth::user();
            $employee->update($request->all());
            return $this->responseSuccess('successfully!',[]);
        }catch(Throwable $th){
            return $this->responseException($th->getMessage());
        }
    }
}
