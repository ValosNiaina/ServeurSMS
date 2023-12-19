<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    private $menu = 'contact';

    #[Route('/', name: 'app_contact')]
    public function index(ContactRepository $contactRepository): Response
    {
        $all_contact = $contactRepository->findAll();

        return $this->render('contact/index.html.twig', [
            'menu' => $this->menu,
            'contacts' => $all_contact,
        ]);
    }

    #[Route('/add', name: 'app_Add_contact', methods: ['GET', 'POST'])]
    public function addContact(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('app_contact'); 
        }

        return $this->render('contact/form.html.twig', [
            'form' => $form->createView(),
            'menu' => $this->menu,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_Edit_contact')]
    public function editContact(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/form.html.twig', [
            'form' => $form->createView(),
            'contact' => $contact,
            'menu' => $this->menu,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_Delete_contact')]
    public function deleteContact(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contact');
    }
}
