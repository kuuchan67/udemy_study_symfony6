<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    private $messages = [
        ['message' => 'Hello', 'created' => '2022/06/12'],
        ['message' => 'Hi', 'created' => '2022/04/12'],
        ['message' => 'Bye!', 'created' => '2021/05/12']
    ];
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
//        return new Response(implode(',', array_slice($this->message, 0, $limit)));

        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
            'messages' => $this->messages,
            'limit' => 3
        ]);
    }

    #[Route('/message/{id<\d+>}', name: 'app_message')]
    public function showOne(int $id)
    {
        return $this->render("hello/show_one.html.twig", [
            "message" => $this->messages[$id]
        ]);
//        return new Response($this->message[$id]);
    }
}
