<?php

namespace App\Controller;

use App\Entity\TypeMessage;
use App\Form\MessageFormType;
use App\Repository\TypeMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class TypeMessageController extends AbstractController
{
    private $menu = 'typeMessage';

    #[Route('/type/message', name: 'app_type_message')]
    public function index(TypeMessageRepository $typeMessageRepository): Response
    {
        $all_type_message = $typeMessageRepository->findAll();

        return $this->render('type_message/index.html.twig', [
            'menu' => $this->menu,
            'typeMessage' => $all_type_message,
        ]);
    }
    
    #[Route('/add/type/message', name: 'app_Add_type_message', methods: ['GET', 'POST'])]
    public function addMessageContact(Request $request, EntityManagerInterface $em): Response
    {
        $type_message = new TypeMessage();
        $form = $this->createForm(MessageFormType::class, $type_message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($type_message);
            $em->flush();

            return $this->redirectToRoute('app_type_message'); // Redirige vers la liste des clients par exemple
        }

        return $this->render('type_message/form.html.twig', [
            'form' => $form->createView(),
            'menu' => $this->menu,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_Edit_type_message')]
    public function editTypeMessage(Request $request, TypeMessage $type_message, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessageFormType::class, $type_message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_message'); // Redirige vers la liste des clients par exemple
        }

        return $this->render('type_message/form.html.twig', [
            'form' => $form->createView(),
            'typeMessage' => $type_message,
            'menu' => $this->menu,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_Delete_type_message')]
    public function deleteTypeMessage(Request $request, TypeMessage $type_message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type_message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($type_message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_message');
    }
}
