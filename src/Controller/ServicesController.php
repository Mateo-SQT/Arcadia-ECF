<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDO;

class ServicesController extends AbstractController
{
    /**
     * @Route("/modifier-service", name="modifier_service", methods={"POST"})
     */
    public function modifierService(Request $request): Response
    {
        // Récupérer les données du formulaire
        $serviceToModify = $request->request->get('serviceToModify');
        $newServiceText = $request->request->get('newServiceText');
        $newServiceImage = $_FILES['newServiceImage'];

        // Connexion à la base de données avec PDO
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');
        // Préparer la requête SQL pour mettre à jour le service
        $sql = "UPDATE service SET description = :newServiceText";
        $params = ['newServiceText' => $newServiceText];

        // Vérifier s'il y a une nouvelle image
        if (!empty($newServiceImage['tmp_name'])) {
            // Charger l'image dans la base de données
            $imageData = file_get_contents($newServiceImage['tmp_name']);
            $sql .= ", image_data = :imageData";
            $params['imageData'] = $imageData;
        }

        $sql .= " WHERE nom = :serviceToModify";
        $params['serviceToModify'] = $serviceToModify;

        // Exécuter la requête
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($params);

        if ($result) {
            // Ajouter un message flash pour succès
            $this->addFlash('success', 'Le service a été modifié avec succès !');
        } else {
            // Ajouter un message flash pour erreur
            $this->addFlash('error', 'Une erreur s\'est produite lors de la modification du service. Veuillez réessayer.');
        }

        // Rediriger vers une route appropriée après la modification du service
        return $this->redirectToRoute('base_board'); // Remplacez 'homepage' par la route souhaitée
    }

    /**
     * @Route("/ajouter-service", name="ajouter_service", methods={"POST"})
     */
    public function ajouterService(Request $request): Response
    {
        // Récupérer les données du formulaire
        $newServiceText = $request->request->get('newServiceText');
        $newServiceImage = $_FILES['newServiceImage'];

        // Connexion à la base de données avec PDO
        $pdo = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');

        // Préparer la requête SQL pour insérer un nouveau service
        $sql = "INSERT INTO service (description, image_data) VALUES (:newServiceText, :imageData)";
        $params = ['newServiceText' => $newServiceText];

        // Charger l'image dans la base de données
        $imageData = file_get_contents($newServiceImage['tmp_name']);
        $params['imageData'] = $imageData;

        // Exécuter la requête
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($params);

        if ($result) {
            // Ajouter un message flash pour succès
            $this->addFlash('success', 'Le nouveau service a été ajouté avec succès !');
        } else {
            // Ajouter un message flash pour erreur
            $this->addFlash('error', 'Une erreur s\'est produite lors de l\'ajout du nouveau service. Veuillez réessayer.');
        }

        return $this->redirectToRoute('base_board'); 
    }

    /**
     * @Route("/supprimer-service/{id}", name="supprimer_service", methods={"DELETE"})
     */
    public function supprimerService(Service $service, Request $request): Response
{
    // Vérifier si la méthode est DELETE
    if ($request->isMethod('DELETE')) {
        // Supprimer le service de la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($service);
        $entityManager->flush();

        // Ajouter un message flash pour succès
        $this->addFlash('success', 'Le service a été supprimé avec succès !');
    }

    return $this->redirectToRoute('base_board');
}
}
