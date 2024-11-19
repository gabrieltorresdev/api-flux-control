<?php

namespace App\Http\Controllers;

use Core\Application\UseCases\User\ListUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, ListUserUseCase $useCase): JsonResponse
    {
        $dados = $useCase->execute();

        return $this->jsonResponse(200, 'Users returned successfully!', $dados);
    }
}
