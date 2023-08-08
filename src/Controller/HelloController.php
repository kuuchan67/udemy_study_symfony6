<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    private $messages = ["Hi", "Hello", "Goobye"];
    #[Route('/{limit?3}', name: 'app_index')]
    public function index(int $limit): Response
    {
//        return new Response(implode(',', array_slice($this->message, 0, $limit)));

        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
            'messages' => array_slice($this->messages, 0, $limit)
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
