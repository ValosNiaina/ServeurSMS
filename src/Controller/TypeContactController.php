<?php

namespace App\Controller;

use App\Entity\TypeContact;
use App\Form\TypeContactForm;
use App\Repository\TypeContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typeContact')]
class TypeContactController extends AbstractController
{
    private $menu = 'typeContact';

    #[Route('/', name: 'app_type_contact')]
    public function index(TypeContactRepository $typeContactRepository): Response
    {
        $all_type_contact = $typeContactRepository->findAll();

        return $this->render('type_contact/index.html.twig', [
            'menu' => $this->menu,
            'typeContacts' => $all_type_contact,
        ]);
    }

    #[Route('/add', name: 'app_Add_type_contact', methods: ['GET', 'POST'])]
    public function addTypeContact(Request $request, EntityManagerInterface $em): Response
    {
        $type_contact = new TypeContact();
        $form = $this->createForm(TypeContactForm::class, $type_contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($type_contact);
            $em->flush();

            return $this->redirectToRoute('app_type_contact'); // Redirige vers la liste des clients par exemple
        }

        return $this->render('type_contact/form.html.twig', [
            'form' => $form->createView(),
            'menu' => $this->menu,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_Edit_type_contact')]
    public function editTypeContact(Request $request, TypeContact $type_contact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeContactForm::class, $type_contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_contact'); // Redirige vers la liste des clients par exemple
        }

        return $this->render('type_contact/form.html.twig', [
            'form' => $form->createView(),
            'typeContact' => $type_contact,
            'menu' => $this->menu,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_Delete_type_contact')]
    public function deleteTypeContact(Request $request, TypeContact $type_contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type_contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($type_contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_contact');
    }
}
