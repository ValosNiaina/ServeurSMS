<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeMessageController extends AbstractController
{
    #[Route('/type/message', name: 'app_type_message')]
    public function index(): Response
    {
        return $this->render('type_message/index.html.twig', [
            'menu' => 'typeMessage',
        ]);
    }
}
