<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class Controller
{
    protected function jsonResponse(int $status, string $message, $data = []): JsonResponse
    {
        if ($data instanceof LengthAwarePaginator) {
            return response()->json($this->formatPaginatedResponse($message, $data));
        }

        return response()->json(['message' => $message, 'data' => $data], $status);
    }

    private function formatPaginatedResponse(string $message, LengthAwarePaginator $paginatedData): array
    {
        return [
            'message' => $message,
            'data' => $paginatedData->items(),
            'meta' => [
                'current_page' => $paginatedData->currentPage(),
                'last_page' => $paginatedData->lastPage(),
                'per_page' => $paginatedData->perPage(),
                'total' => $paginatedData->total(),
                'from' => $paginatedData->firstItem(),
                'to' => $paginatedData->lastItem(),
            ],
        ];
    }

    protected function created(string $message, $data = []): JsonResponse
    {
        return $this->jsonResponse(201, $message, $data);
    }

    protected function ok(string $message, $data = []): JsonResponse
    {
        return $this->jsonResponse(200, $message, $data);
    }

    protected function noContent(): Response
    {
        return response()->noContent();
    }
}
