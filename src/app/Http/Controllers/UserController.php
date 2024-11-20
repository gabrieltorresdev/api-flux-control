<?php

namespace App\Http\Controllers;

use App\Core\Application\User\Action\ListUserAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, ListUserAction $action): JsonResponse
    {
        $dados = $action->execute();

        return $this->jsonResponse(200, 'Users returned successfully!', $dados);
    }
}
