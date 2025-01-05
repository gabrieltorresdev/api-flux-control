<?php

namespace App\Http\Controllers;

use App\Core\Application\Transaction\Action\CreateTransactionAction;
use App\Core\Application\Transaction\Action\DeleteTransactionAction;
use App\Core\Application\Transaction\Action\ListTransactionAction;
use App\Core\Application\Transaction\Action\GetTransactionSummaryAction;
use App\Core\Application\Transaction\Action\UpdateTransactionAction;
use App\Core\Application\Transaction\DTO\Create\InCreateTransaction;
use App\Core\Application\Transaction\DTO\Delete\InDeleteTransaction;
use App\Core\Application\Transaction\DTO\List\InListTransaction;
use App\Core\Application\Transaction\DTO\Summary\InGetTransactionSummary;
use App\Core\Application\Transaction\DTO\Update\InUpdateTransaction;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request, ListTransactionAction $action): JsonResponse
    {
        $data = $request->all();
        $data['userId'] = Auth::id();

        $result = $action->execute(InListTransaction::from($data));
        return $this->ok('Data returned successfully!', $result);
    }

    public function create(CreateTransactionRequest $request, CreateTransactionAction $action): JsonResponse
    {
        $data = $request->validated();
        $data['userId'] = Auth::id();

        $result = $action->execute(InCreateTransaction::from($data));
        return $this->created('Data created successfully!', $result);
    }

    public function update(string $id, UpdateTransactionRequest $request, UpdateTransactionAction $action): JsonResponse
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data['userId'] = Auth::id();

        $result = $action->execute(InUpdateTransaction::from($data));
        return $this->ok('Data updated successfully!', $result);
    }

    public function delete(string $id, DeleteTransactionAction $action): Response
    {
        $data = [
            'userId' => Auth::id(),
            'id' => $id
        ];

        $action->execute(InDeleteTransaction::from($data));
        return $this->noContent();
    }

    public function getSummary(Request $request, GetTransactionSummaryAction $action): JsonResponse
    {
        $data = $request->all();
        $data['userId'] = Auth::id();

        $result = $action->execute(InGetTransactionSummary::from($data));
        return $this->ok('Data returned successfully!', $result);
    }
}
