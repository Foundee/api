<?php

namespace App\Security;

use App\Exception\AccountBannedException;
use App\Security\User;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPostAuth(UserInterface $user)
    {
    }

    public function checkPreAuth(UserInterface $user)
    {
        $allowLogin = true;

        $currentDate = date('Y-m-d H:i:s');
        $currentDate = date('Y-m-d H:i:s', strtotime($currentDate));

        foreach ($user->getBans() as $ban) {
            $startDate = date('Y-m-d H:i:s', strtotime($ban->getStartTime()));
            $endDate = date('Y-m-d H:i:s', strtotime($ban->getEndTime()));
			
            if (($currentDate >= $startDate) && ($currentDate <= $endDate)){
                $allowLogin = false;
                break;
            }
        }
		
        if (!$allowLogin) {
            throw new AccountBannedException();
        }
    }
}