<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDO;

class AvisController extends AbstractController
{
    /**
     * @Route("/ajouter-avis", name="ajouter_avis", methods={"POST"})
     */
    public function ajouterAvis(Request $request): Response
    {
        // Récupérer les données du formulaire
        $pseudo = $request->request->get('pseudo');
        $commentaire = $request->request->get('commentaire');
        $isVisible = false; 

        // Récupérer la connexion PDO à partir du service de base de données
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia','root','');

        // Requête SQL préparée pour l'insertion des données
        $stmt = $pdo->prepare("INSERT INTO avis (pseudo, commentaire, isVisible) VALUES (?, ?, ?)");
        $result = $stmt->execute([$pseudo, $commentaire, $isVisible]);

        if ($result) {
            // Ajouter un message flash pour succès
            $this->addFlash('success', 'Votre avis a été ajouté avec succès !');
        } else {
            // Ajouter un message flash pour erreur
            $this->addFlash('error', 'Une erreur s\'est produite lors de l\'ajout de votre avis. Veuillez réessayer.');
        }

        return $this->redirectToRoute('contactpage'); 
    }

        /**
         * @Route("/afficher-avis", name="afficher_avis", methods={"GET"})
         */
        public function afficherAvis(): Response
    {
        // Récupérer la connexion PDO à partir du service de base de données
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');

        // Requête SQL pour récupérer tous les avis
        $stmt = $pdo->query("SELECT * FROM avis");
        $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // S'assurer que $avis est toujours un tableau
        if (!$avis) {
            $avis = [];
        }

        // Renvoyer les avis à une vue
        return $this->render('base_board', [
            'avis' => $avis,
        ]);
    }
}
