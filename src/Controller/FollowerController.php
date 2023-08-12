<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FollowerController extends AbstractController
{
    #[Route('/follow/{id}', name: 'app_follow')]
    public function follow(User $userToFollow,
                           ManagerRegistry $managerRegistory,
                           Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($userToFollow->getId() !== $currentUser->getId()) {
            $currentUser->addFollow($userToFollow);
            $managerRegistory->getManager()->persist($currentUser);
            $managerRegistory->getManager()->flush();
        }
        return $this->redirect($request->headers->get('referer'));

    }

    #[Route('/unfollow/{id}', name: 'app_unfollow')]
    public function unfollow(User $userToUnfollow,
                             ManagerRegistry $managerRegistory,
                             Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if ($userToUnfollow->getId() !== $currentUser->getId()) {
            $currentUser->removeFollow($userToUnfollow);
            $managerRegistory->getManager()->persist($currentUser);
            $managerRegistory->getManager()->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
