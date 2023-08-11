<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\User;
use App\Repository\MicroPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LikeController extends AbstractController
{
    #[Route('/like/{id}', name: 'app_like')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function like(MicroPost $post, Request $request, MicroPostRepository $repo): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $post->addLikedBy($user);
        $repo->add($post, true);
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/unlike/{id}', name: 'app_unlike')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function unlike(MicroPost $post, Request $request, MicroPostRepository $repo): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $post->removeLikedBy($user);
        $repo->add($post, true);
        return $this->redirect($request->headers->get('referer'));
    }
}
