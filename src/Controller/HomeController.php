<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $showbrand = true;
        return $this->render('base.html.twig', [
            'showbrand' => $showbrand,
        ]);
    }


    /**
     * @Route("/servicepage", name="servicepage")
     */
    public function servicepage(): Response
    {
        $showbrand = true;
        return $this->render('services.html.twig', [
            'showbrand' => $showbrand,
        ]);
    }
    

    /**
     * @Route("/habitatspage", name="habitatspage")
     */
    public function habitatspage(): Response
    {
        $showbrand = true;
        return $this->render('habitats.html.twig',[
            'showbrand' => $showbrand,
        ]);
    }


    /**
     * @Route("/connexionpage", name="connexionpage")
     */
    public function connexionpage(): Response
    {
        $showbrand = false;
        return $this->render('connexion.html.twig', [
            'showbrand' => $showbrand,
        ]);
    }


    
    /**
     * @Route("/base_board", name="base_board")
     */
    public function base_board(): Response
    {
        $showbrand = true;
        return $this->render('base_board.html.twig', [
            'showbrand' => $showbrand,
        ]);
    }



    /**
     * @Route("/veterinaire_board", name="veterinaire_board")
     */
    public function veterinaire_board(): Response
    {
        $showbrand = true;
        return $this->render('veterinaire_board.html.twig', [
            'showbrand' => $showbrand,
        ]);
    }



    /**
     * @Route("/admin_board_board", name="admin_board")
     */
    public function admin_board(): Response
    {
        $showbrand = true;
        return $this->render('admin_board.html.twig', [
            'showbrand' => $showbrand,
        ]);
    }

    
    /**
     * @Route("/contactpage", name="contactpage")
     */
    public function contactpage(): Response
    {
        $showbrand = true;
        return $this->render('contact.html.twig',[
            'showbrand' => $showbrand,
        ]);
    }

}


