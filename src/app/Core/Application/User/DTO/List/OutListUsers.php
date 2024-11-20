<?php

namespace App\Core\Application\User\DTO\List;

use App\Shared\ObjectAbstract;

class OutListUsers extends ObjectAbstract
{
    public string $id;
    public string $name;
    public string $email;
}
