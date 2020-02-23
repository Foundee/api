<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AccountBannedException extends AccountStatusException
{
    public function getMessageKey()
    {
        return 'Account banned.';
    }
}