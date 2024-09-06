<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgetPasswordController extends Controller
{
    public function send_reset_password_email(Request $request){
        try{
            $email=User::where('email',$request->email)->first();
            if($email){
                $response =Password::sendResetLink($request->only('email'));
                if($response ==Password::RESET_LINK_SENT){
                    return response()->json(['status'=>true,'message'=>'Reset Password email has been sent successfully'],JsonResponse::HTTP_OK);
                }
                else{
                    return response()->json(['status'=>false,'message'=>'Something went wrong!'],JsonResponse::HTTP_BAD_REQUEST);
                }
            }
        }
        catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()],JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
