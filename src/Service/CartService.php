<?php

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
                $fetchProduct = $this->em->getRepository(Product::class)->findOneBy(['id' => $id]);
                if($fetchProduct)
                {
                    $cartData[]= [
                        'product' => $fetchProduct,
                        'quantity' => $q
                    ];
                }
            }
        }
          //return le tableau de produits avec leurs informations et quantités
          return $cartData;
    }
  
}
?>