<?php

namespace App\Http\Controllers;

use App\Core\Application\TransactionCategory\Action\CreateTransactionCategoryAction;
use App\Core\Application\TransactionCategory\Action\ListTransactionsCategoriesAction;
use App\Core\Application\TransactionCategory\DTO\Create\InCreateTransactionCategory;
use App\Core\Application\TransactionCategory\DTO\List\InListTransactionsCategories;
use App\Http\Requests\CreateTransactionCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionCategoryController extends Controller
{
    public function index(Request $request, ListTransactionsCategoriesAction $action): JsonResponse
    {
        $result = $action->execute(InListTransactionsCategories::from($request));

        return $this->jsonResponse(200, 'Transactions Categories returned successfully!', $result);
    }
    public function create(CreateTransactionCategoryRequest $request, CreateTransactionCategoryAction $action): JsonResponse
    {
        $result = $action->execute(InCreateTransactionCategory::from($request));

        return $this->jsonResponse(201, 'Transaction Category created successfully!', $result);
    }
}
