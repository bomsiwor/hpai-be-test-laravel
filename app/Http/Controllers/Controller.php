<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;

abstract class Controller
{
    private function baseResponse(string $message, mixed $data, int $code)
    {
        return response()->json([
            "message" => $message,
            "data" => $data
        ], $code);
    }

    public function successResponse(?string $message = null, mixed $data = null, ?int $code = 200)
    {
        // Default Message
        $message ??= "Success";

        // Validate code
        // THrow error if code is not success
        if ($code < 200 || $code > 300) {
            throw new Exception("Response code is not valid for success");
        }

        // Use baseResponse to return response
        return $this->baseResponse($message, $data, $code);
    }

    public function errorResponse(?string $message = null, mixed $data = null, int|string|null $code = null)
    {
        // Default Message
        $message ??= "Success";

        // Set code to 400 if null or string
        if (is_string($code) || !$code) {
            $code = 400;
        }

        // Validate code
        // THrow error if code is not success
        if ($code > 200 && $code < 300) {
            throw new Exception("Response code is not valid for error");
        }

        // Use baseResponse to return response
        return $this->baseResponse($message, $data, $code);
    }
}
