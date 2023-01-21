<?php

namespace App\Services;

class ApiResponseService{
    static public function makeResponse(
        int $status_code,
        bool $success,
        array $result,
        $errors,
    ){
        return response()->json([
            'statusCode' => $status_code,
            'success' => $success,
            'result' => $result,
            'errors' => $errors,
        ], $status_code);
    }
}