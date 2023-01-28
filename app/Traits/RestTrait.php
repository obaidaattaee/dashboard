<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait RestTrait
{

    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/v'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {
        return request()->is('api/*');
    }


    public function sendResponse($data, $message = "success", $code = 200)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
            'code' => $code
        ]);
    }


    public function sendError($message = "something went wrong", $errorMessages = [], $code = 500)
    {
        return response()->json([
            'status' => false,
            'error_messages' => $errorMessages,
            'message' => $message,
            'code' => $code
        ] , $code);
    }
}
