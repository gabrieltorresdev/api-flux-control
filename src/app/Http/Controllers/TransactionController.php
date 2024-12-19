<?php

namespace App\Http\Controllers;

use App\Core\Application\Transaction\Action\CreateTransactionAction;
use App\Core\Application\Transaction\Action\DeleteTransactionAction;
use App\Core\Application\Transaction\Action\ListTransactionAction;
use App\Core\Application\Transaction\Action\GetTransactionSummaryAction;
use App\Core\Application\Transaction\Action\UpdateTransactionAction;
use App\Core\Application\Transaction\DTO\Create\InCreateTransaction;
use App\Core\Application\Transaction\DTO\List\InListTransaction;
use App\Core\Application\Transaction\DTO\Summary\InGetTransactionSummary;
use App\Core\Application\Transaction\DTO\Update\InUpdateTransaction;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function update(string $id, UpdateTransactionRequest $request, UpdateTransactionAction $action): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = $id;

        $result = $action->execute(InUpdateTransaction::from($data));
        return $this->jsonResponse(200, 'Data updated successfully!', $result);
    }

    public function delete(string $id, DeleteTransactionAction $action): JsonResponse
    {
        $action->execute($id);
        return $this->jsonResponse(200, 'Data deleted successfully!');
    }

    public function getSummary(Request $request, GetTransactionSummaryAction $action): JsonResponse
    {
        $data = $action->execute(InGetTransactionSummary::from($request));
        return $this->jsonResponse(200, 'Data returned successfully!', $data);
    }
}
