<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;
use App\Repository\MessageRepository;

class TemplateMessageController extends AbstractController
{
    private $menu = 'message';

    #[Route('/template/message', name: 'app_template_message')]
    public function index(MessageRepository $messageRepository): Response
    {
         $all_message = $messageRepository->findAll();

        return $this->render('template_message/index.html.twig', [
            'menu' => $this->menu,
            'messages' => $all_message,
        ]);
    }
}
