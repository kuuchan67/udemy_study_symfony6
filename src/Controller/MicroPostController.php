<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    public function add(Request $request, MicroPostRepository $repo):Response
    {
        $microPost = new MicroPost();
        $form = $this->createFormBuilder($microPost)
            ->add("title")
            ->add("text")
            ->add('submit', SubmitType::class, [
                'label' => "投稿"
            ])
            ->getForm()
            ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var MicroPost $post */
            $post = $form->getData();
            $post->setCreated(new \DateTime());
            $repo->add($post, true);
            $this->addFlash(
                'success',
                '投稿されました！'
            );
            return $this->redirectToRoute('app_micro_post');

        }
        return $this->render(
            'micro_post/add.html.twig',
            [
                'form' => $form,
            ]
        );


    }
}
