<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HoraireController extends AbstractController
{
    /**
     * @Route("/save-hours", name="save_hours", methods={"POST"})
     */
    public function saveHours(Request $request): Response
    {
        // Récupérer les données du formulaire
        $horaires = $request->request->all();

        // Afficher les données pour vérification
        dump($horaires);

        
        // Redirection vers la page de contact
        return $this->redirectToRoute('contactpage', ['horaires' => $horaires]);
    }
}
