<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDO;

class HabitatController extends AbstractController
{
    /**
     * @Route("/enregistrer-habitat", name="enregistrer_habitat", methods={"GET", "POST"})
     */
    public function enregistrerHabitat(Request $request): Response
    {
        // Connexion à la base de données avec PDO
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');

        // Récupérer les habitats depuis la base de données
        $stmt = $pdo->query("SELECT * FROM habitat");
        $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Traitement du formulaire s'il est soumis
        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire
            $habitat = $request->request->get('habitat');
            $etatHabitat = $request->request->get('etatHabitat');
            $ameliorationHabitat = $request->request->get('ameliorationHabitat');

            // Préparation de la requête SQL pour insérer les données
            $stmt = $pdo->prepare("INSERT INTO habitat (nom, description, commentaire_habitat) VALUES (?, ?, ?)");
            $result = $stmt->execute([$habitat, $etatHabitat, $ameliorationHabitat]);

            if ($result) {
                // Ajouter un message flash pour succès
                $this->addFlash('success', 'L\'habitat a été enregistré avec succès !');
            } else {
                // Ajouter un message flash pour erreur
                $this->addFlash('error', 'Une erreur s\'est produite lors de l\'enregistrement de l\'habitat. Veuillez réessayer.');
            }

            // Rediriger vers une autre page ou actualiser la page actuelle
            return $this->redirectToRoute('veterinaire_board');
        }

        // Passer les habitats à la vue Twig pour affichage dans le formulaire
        return $this->render('veterinaire_board', [
            'habitats' => $habitats,
        ]);
    }
}
