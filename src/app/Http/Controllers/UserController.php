<?php

namespace App\Http\Controllers;

use App\Core\Application\User\Action\ListUsersAction;
use App\Core\Application\User\Action\GetUserStatusAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request, ListUsersAction $action): JsonResponse
    {
        $dados = $action->execute();

        return $this->ok('Users returned successfully!', $dados);
    }

    public function status(Request $request, GetUserStatusAction $action): JsonResponse
    {
        $status = $action->execute(Auth::id());
        return $this->ok('User status returned successfully!', [
            'userStatus' => $status
        ]);
    }
}
