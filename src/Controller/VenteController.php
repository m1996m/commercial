<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Produitvendu;
use App\Entity\Rayon;
use App\Entity\Vente;
use App\Repository\ProduitvenduRepository;
use App\Repository\VenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */

class VenteController extends AbstractController
{
    /**
     * @Route("/api/venteAllVente", name="venteAllVente", methods={"GET","POST"})
     *
     */
    public function venteAllVente(VenteRepository $venteRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($venteRepository->getAllVente($this->getUser()->getCentre()->getId()),200,[],$defaultContext);
    }

}