<?php

namespace App\Http\Controllers;

use App\Core\Application\Transaction\Action\CreateTransactionAction;
use App\Core\Application\Transaction\Action\ListTransactionAction;
use App\Core\Application\Transaction\DTO\Create\InCreateTransaction;
use App\Core\Application\Transaction\DTO\List\InListTransaction;
use App\Http\Requests\CreateTransactionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request, ListTransactionAction $action): JsonResponse
    {
        $data = $action->execute(InListTransaction::from($request));
        return $this->jsonResponse(200, 'Data returned successfully!', $data);
    }

    public function create(CreateTransactionRequest $request, CreateTransactionAction $action): JsonResponse
    {
        $data = $action->execute(InCreateTransaction::from($request));

        return $this->jsonResponse(201, 'Data created successfully!', $data);
    }
}
