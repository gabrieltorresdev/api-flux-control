<?php

namespace Core\Application\UseCases\User;

use Core\Application\Dtos\User\List\OutputListUserDto;
use Core\Domain\Repositories\UserRepositoryInterface;
use Exception;

readonly class ListUserUseCase
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {}

    /**
     * @return OutputListUserDto[]
     * @throws Exception
     */
    public function execute(): array
    {
        $resultado = $this->userRepository->listar();

        return OutputListUserDto::arrayOf($resultado);
    }
}
