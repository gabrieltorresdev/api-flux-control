<?php

namespace App\Http\Controllers;

use App\Core\Application\TransactionCategory\Action\CreateTransactionCategoryAction;
use App\Core\Application\TransactionCategory\Action\DeleteTransactionCategoryAction;
use App\Core\Application\TransactionCategory\Action\ListTransactionsCategoriesAction;
use App\Core\Application\TransactionCategory\Action\GetTransactionCategoryByNameAction;
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

    public function getByName(string $name, GetTransactionCategoryByNameAction $action): JsonResponse
    {
        $result = $action->execute($name);

        return $this->jsonResponse(200, 'Transaction Category found successfully!', $result);
    }

    public function delete(string $id, DeleteTransactionCategoryAction $action): JsonResponse
    {
        $action->execute($id);

        return $this->jsonResponse(200, 'Transaction Category deleted successfully!');
    }
}
