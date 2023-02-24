<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ProduitRepository $repoProduit,): Response
    {
        $produit = $repoProduit->findAll();


        return $this->render('accueil/index.html.twig', [
            "produits" => $produit,
            'controller_name' => 'Bienvenue sur Ninoucrea',
        ]);
    }
}
