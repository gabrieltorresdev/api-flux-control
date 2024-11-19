<?php

namespace Core\Application\Dtos\User\List;

use App\Shared\ObjectAbstract;

class OutputListUserDto extends ObjectAbstract
{
    public string $id;
    public string $name;
    public string $email;
}
