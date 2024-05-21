<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDO;

class FoodController extends AbstractController
{
    /**
     * @Route("/enregistrer_consommation", name="enregistrer_consommation", methods={"POST"})
     */
    public function enregistrer_consommation(Request $request): Response
    {
        // Récupérer les données du formulaire
        $animal = $request->request->get('animal');
        $date = $request->request->get('date');
        $heure = $request->request->get('heure');
        $typeNourriture = $request->request->get('typeNourriture');
        $quantite = $request->request->get('quantite');

        // Récupérer la connexion PDO à partir du service de base de données
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia','root','');

        // Requête SQL préparée pour l'insertion des données
        $stmt = $pdo->prepare("INSERT INTO consommation_nourriture (animal, date, heure, type_nourriture, quantite) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([$animal, $date, $heure, $typeNourriture, $quantite]);

        if ($result) {
            // Ajouter un message flash pour succès
            $this->addFlash('success', 'La consommation de nourriture a été enregistrée avec succès !');
        } else {
            // Ajouter un message flash pour erreur
            $this->addFlash('error', 'Une erreur s\'est produite lors de l\'enregistrement de la consommation de nourriture. Veuillez réessayer.');
        }


        return $this->redirectToRoute('base_board');
    }
}
