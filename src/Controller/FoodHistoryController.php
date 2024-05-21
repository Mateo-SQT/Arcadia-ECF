<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDO;

class FoodHistoryController extends AbstractController
{
    /**
     * @Route("/afficher-historique-nourriture", name="afficher_historique_nourriture", methods={"GET"})
     */
    public function afficherHistoriqueNourriture(Request $request): Response
    {
        // Récupérer l'animal sélectionné depuis le formulaire
        $animalId = $request->request->get('animalSelection');

        // Connexion à la base de données avec PDO
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');

        // Requête SQL pour récupérer l'historique de consommation de nourriture pour l'animal sélectionné
        $stmt = $pdo->prepare("SELECT * FROM historique_nourriture WHERE animal_id = ?");
        $stmt->execute([$animalId]);
        $historiqueNourriture = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Passer les données à la vue Twig pour affichage
        return $this->render('veterinire_board', [
            'historiqueNourriture' => $historiqueNourriture,
        ]);
    }
}
