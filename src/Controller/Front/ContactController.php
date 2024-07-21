<?php

namespace  App\Controller\Front;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/front/contact', 'front_contact_')]
class ContactController  extends AbstractController
{
    #[Route('/form' , name: 'form')]
    public function  form ( Request $request): Response
    {
        $contactDTO = new ContactDTO();
        $form = $this->createForm(ContactType::class, $contactDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            return  $this->redirectToRoute('front_contact_confirmation');
        }


        return $this->render('front/contact/form.html.twig', ['form' => $form]);
    }

    #[Route('/confirmation' , name: 'confirmation')]
    public function confirmation(): Response
    {
        return $this->render('front/contact/confirmation.html.twig');
    }
}