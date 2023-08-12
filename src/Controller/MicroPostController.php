<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $repo): Response
    {

        return $this->render('micro_post/index.html.twig', [
            'posts' => $repo->findAllWithComments(),
        ]);
    }

    #[Route('/micro-post/top-liked', name: 'app_micro_post_top_liked')]
    public function topLiked(MicroPostRepository $repo): Response
    {

        return $this->render('micro_post/top_liked.html.twig', [
            'posts' => $repo->findAllWithMinLikes(2),
        ]);
    }

    #[Route('/micro-post/follows', name: 'app_micro_post_follows')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function follows(MicroPostRepository $repo): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        // フォローっユーザーの投稿
        return $this->render('micro_post/follows.html.twig', [
            'posts' => $repo->findAllByAuthors(
                $currentUser->getFollows()
            ),
        ]);
    }

    #[Route('/micro-post/{id}', name: 'app_micro_post_show_one')]
    #[IsGranted(MicroPost::VIEW, 'post')]
    public function showOne(MicroPost $post): Response
    {

        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);

    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    #[IsGranted('ROLE_WRITER')]
    public function add(Request $request, MicroPostRepository $repo):Response
    {
        $form = $this->createForm(MicroPostType::class, new MicroPost());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var MicroPost $post */
            $post = $form->getData();
            $post->setCreated(new \DateTime());
            $post->setAuthor($this->getUser());
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
    #[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
    #[IsGranted(MicroPost::EDIT, 'post')]
    public function edit(MicroPost $post, Request $request, MicroPostRepository $repo):Response
    {

        $form = $this->createForm(MicroPostType::class, $post);
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var MicroPost $post */
            $post = $form->getData();
            $repo->add($post, true);
            $this->addFlash(
                'success',
                '更新しました！'
            );
            return $this->redirectToRoute('app_micro_post');

        }
        return $this->render(
            'micro_post/edit.html.twig',
            [
                'form' => $form,
            ]
        );

    }

    #[Route('/micro-post/{post}/comment', name: 'app_micro_post_comment')]
    #[IsGranted('ROLE_COMMENTER')]
    public function addComment(MicroPost $post, Request $request, CommentRepository $repo):Response
    {

        $form = $this->createForm(CommentType::class, new Comment());
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setCreated(new \DateTime());
            $comment->setAuthor($this->getUser());
            $repo->add($comment, true);
            $this->addFlash(
                'success',
                'コメントを投稿しました！'
            );
            return $this->redirectToRoute('app_micro_post_show_one', ['id' => $post->getId()]);
        }
        return $this->render(
            'micro_post/comment.html.twig',
            [
                'form' => $form,
                'post' => $post
            ]
        );

    }
}
