<?php

namespace App\Http\Controllers;

use App\Core\Application\TransactionCategory\Action\CreateTransactionCategoryAction;
use App\Core\Application\TransactionCategory\DTO\Create\InCreateTransactionCategory;
use App\Http\Requests\CreateTransactionCategoryRequest;
use Illuminate\Http\JsonResponse;

class TransactionCategoryController extends Controller
{
    public function create(CreateTransactionCategoryRequest $request, CreateTransactionCategoryAction $action): JsonResponse
    {
        $result = $action->execute(InCreateTransactionCategory::from($request));

        return $this->jsonResponse(201, 'Transaction Category created successfully!', $result);
    }
}
