<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact", methods={"GET", "POST"})
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $title = $request->request->get('title');
            $messageContent = $request->request->get('message');

            // Validation simple 
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($title) && !empty($messageContent)) {
                // Créer et envoyer l'e-mail
                $emailMessage = (new Email())
                    ->from($email)
                    ->to('mateosouquet@gmail.com')
                    ->subject($title)
                    ->text($messageContent);

                $mailer->send($emailMessage);

                // Ajouter un message flash pour succès
                $this->addFlash('success', 'Votre message a été envoyé avec succès !');

                // Rediriger vers la page de contact
                return $this->redirectToRoute('contactpage');
            } else {
                // Ajouter un message flash pour erreur de validation
                $this->addFlash('error', 'Veuillez remplir tous les champs correctement.');
            }
        }

        // Afficher le formulaire de contact
        return $this->render('contactpage.html.twig');
    }
}
