<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Enumerable;
use JsonSerializable;
use Traversable;

abstract class Controller
{
    protected function jsonResponse(int $status, string $message, $data = []): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $this->convertToArray($data)], $status);
    }

    private static function convertToArray($data): array
    {
        return match(true) {
            is_array($data) => $data,
            $data instanceof Enumerable => $data->all(),
            $data instanceof Arrayable => $data->toArray(),
            $data instanceof Jsonable => json_decode($data->toJson(), true),
            $data instanceof JsonSerializable => (array)$data->jsonSerialize(),
            $data instanceof Traversable => iterator_to_array($data),
            default => (array)$data
        };
    }
}
