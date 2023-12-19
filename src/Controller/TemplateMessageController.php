<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateMessageController extends AbstractController
{
    #[Route('/template/message', name: 'app_template_message')]
    public function index(): Response
    {
        return $this->render('template_message/index.html.twig', [
            'menu' => 'templateMessage',
        ]);
    }
}
