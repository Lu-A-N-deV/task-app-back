<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class BaseController extends Controller
{
    protected function validationErrorsResponse($validator): JsonResponse
    {
        return response()->json([
            'message' => 'Ocurrió un error al validar los datos',
            'errors' => $validator->errors()
        ], 422);
    }

    protected function notFoundResponse(string $message = 'Recurso no encontrado'): JsonResponse
    {
        return response()->json(['message' => $message], 404);
    }

    protected function serverErrorResponse(string $action, \Exception $e): JsonResponse
    {
        return response()->json([
            'message' => "Error al: $action",
            'error' => $e->getMessage()
        ], 500);
    }

    protected function successResponse(string $message, int $status = 200): JsonResponse
    {
        return response()->json(['message' => $message], $status);
    }
}
