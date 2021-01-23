<?php

namespace App\Http\Traits;

trait ApiResponser
{
    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json(
            [
                "success" => true,
                "message" => $message,
                "data" => $data,
            ],
            $code
        );
    }

    protected function errorResponse($message = null, $code = 404)
    {
        return response()->json(
            [
                "success" => false,
                "message" => $message,
                "data" => null,
            ],
            $code
        );
    }
}
