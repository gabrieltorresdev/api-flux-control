<?php

namespace App\Http\Controllers;

use App\Core\Application\User\Action\ListUsersAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, ListUsersAction $action): JsonResponse
    {
        $dados = $action->execute();

        return $this->jsonResponse(200, 'Users returned successfully!', $dados);
    }
}
