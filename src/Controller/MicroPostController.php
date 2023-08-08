<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $repo): Response
    {

        return $this->render('micro_post/index.html.twig', [
            'posts' => $repo->findAll(),
        ]);
    }
    #[Route('/micro-post/{id}', name: 'app_micro_post_show_one')]
    public function showOne(MicroPost $microPost): Response
    {

        return $this->render('micro_post/show.html.twig', [
            'post' => $microPost,
        ]);

    }
}
