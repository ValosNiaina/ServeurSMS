<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageFormType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/message')]
class MessageController extends AbstractController
{
    private $menu = 'message';

    #[Route('/', name: 'app_message')]
    public function index(MessageRepository $messageRepository): Response
    {
        $all_message = $messageRepository->findAll();

        return $this->render('message/index.html.twig', [
            'menu' => $this->menu,
            'messages' => $all_message,
        ]);
    }

    #[Route('/add', name: 'app_Add_message', methods: ['GET', 'POST'])]
    public function addContact(Request $request, EntityManagerInterface $em): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageFormType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('app_message'); 
        }

        return $this->render('message/form.html.twig', [
            'form' => $form->createView(),
            'menu' => $this->menu,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_Delete_message')]
    public function deleteMessage(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_message');
    }
}
