<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDO;

class RapportVeterinaireController extends AbstractController
{
    /**
     * @Route("/afficher-rapports-veterinaires", name="afficher_rapports_veterinaires", methods={"GET"})
     */
    public function afficherRapportsVeterinaires(): Response
    {
        // Récupérer la connexion PDO à partir du service de base de données
        $pdo = new PDO('mysql:host=localhost;dbname=nom_de_votre_base_de_donnees', 'nom_utilisateur', 'mot_de_passe');

        // Requête SQL pour récupérer tous les rapports vétérinaires
        $stmt = $pdo->query("SELECT * FROM rapport_veterinaire");
        $rapportsVeterinaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // S'assurer que $rapportsVeterinaires est toujours un tableau
        if (!$rapportsVeterinaires) {
            $rapportsVeterinaires = [];
        }

        // Renvoyer les rapports vétérinaires à une vue
        return $this->render('rapport_veterinaire/liste.html.twig', [
            'rapportsVeterinaires' => $rapportsVeterinaires,
        ]);
    }
}
