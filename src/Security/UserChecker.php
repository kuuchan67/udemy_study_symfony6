<?php

namespace App\Security;


use App\Entity\User;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{


    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        if (null === $user->getBannedUntil()) {
            return;
        }


        $now = new \DateTime();

        // その日付まではbanという意味
        if ($now < $user->getBannedUntil()) {
            throw new AccessDeniedException('この会員はアクセスできません');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
        if (null === $user->getBannedUntil()) {
            return;
        }


        $now = new \DateTime();

        if ($now < $user->getBannedUntil()) {
            throw new AccessDeniedException('この会員はアクセスできません');
        }
    }
}