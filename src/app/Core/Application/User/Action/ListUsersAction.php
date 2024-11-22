<?php

namespace App\Core\Application\User\Action;

use App\Core\Application\User\DTO\List\OutListUsers;
use App\Core\Domain\Repository\IUserRepository;
use Exception;

readonly class ListUsersAction
{
    public function __construct(private IUserRepository $userRepository)
    {}

    /**
     * @return OutListUsers[]
     * @throws Exception
     */
    public function execute(): array
    {
        return OutListUsers::arrayOf($this->userRepository->findAll());
    }
}
