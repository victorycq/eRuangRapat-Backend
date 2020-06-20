<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function success($data, $code){
        return response()->json(['data' => $data], $code);
    }
    public function error($message, $code){
        return response()->json(['message' => $message], $code);
    }
    public function parseToken()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return array('message' => 'user_not_found', 'code' => 404);
            }
    
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    
            return array('message' => 'token_expired', 'code' => $e->getStatusCode());
    
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    
            return array('message' => 'token_invalid', 'code' => $e->getStatusCode());
    
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
    
            return array('message' => 'token_absent', 'code' => $e->getStatusCode());
    
        }
        // the token is valid and we have found the user via the sub claim
        return $user;
    }
}
