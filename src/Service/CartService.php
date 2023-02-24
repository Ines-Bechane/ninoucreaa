<?php

namespace App\Service;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService
{
    private RequestStack $requestStack;
    private EntityManagerInterface $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        // Injection de dependances
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    public function getSession():SessionInterface
    {
        return $this->requestStack->getSession();
    }

    public function addCart(int $id)
    {
        // recuperation du tableau de produit ajoutés au panier depuuis le session utilisateur
        $cart = $this->getSession()->get('cart',[]);

        //verifier si le produit existe desja dans le panier
        if(!empty($cart[$id]))
        {
            // si le produit existe, on incremente la quantité
            $cart[$id]++;
        }else
        {
            //sinon on ajoute le produit au panier
            $cart[$id] = 1;
        }
        //mise a jour du panier dans la session utilisateur 
        $this->getSession()->set('cart',$cart);
    }

    public function getTotal()
    {
        // recuperation du tableau de produits ajoutés au panier depuis la session utilisateur
        $cart = $this->getSession()->get('cart');
        $cartData = [];

        if($cart)
        {
            foreach($cart as $id => $q)
            {
                //recuperation du produit a partir de son id en bdd
                $fetchProduit = $this->em->getRepository(Produit::class)->findOneBy(['id' => $id]);
                if($fetchProduit)
                {
                    $cartData[]= [
                        'produit' => $fetchProduit,
                        'quantity' => $q
                    ];
                }
            }
        }
          //return le tableau de produits avec leurs informations et quantités
          return $cartData;
    }

    public function decrease(int $id)
    {
        // recuperation du tableau de produit ajouter au panier depuis la sesion utilisateur
        $cart = $this->getSession()->get('cart',[]);
        // verification si la quantité du produit est superieur a 1 pour pouvoir decrementer
        if($cart[$id] > 1)
        {
            $cart[$id]--;
        }
        else{
            // si la quantité du produit est egale a 1 on supprime le produit du panier 
            unset($cart[$id]);
        }
        return $this->getSession()->set('cart', $cart);
    }

    


    public function deleteCart(int $id)
    {
        // recuperation du tableau de produit ajouter au panier depuis la session utilisateur
        $cart = $this->getSession()->get('cart',[]);
        // suppression du produit qui est dans le panier
        unset($cart[$id]);
        return $this->getSession()->set('cart', $cart);
    }

    public function deleteAllCart()
    {
        return $this->getSession()->remove('cart');
    }

  
  
}
?>