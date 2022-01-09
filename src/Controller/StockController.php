<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Repository\CentreRepository;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


class StockController extends AbstractController
{
    /**
     * @Route("/api/stock", name="stock_index", methods={"GET"})
     */
    public function index(StockRepository $stockRepository): Response
    {
        $defaultContent=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet, $format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($stockRepository->getAll($this->getUser()->getCentre()->getId()),200,[],$defaultContent);
    }

    /**
     * @Route("/api/stock/new", name="stock_new", methods={"GET","POST"})
     */
    public function new(Request $request, CentreRepository $repos): Response
    {
        $stock = new Stock();
        $request=$request->getContent();
        $form=json_decode($request, true);
        //$centre=$repos->find($form['idCentre']);
        $stock->setNom($form['nom']);
        $stock->setAdresse($form['adresse']);
        $stock->setCentre($this->getUser()->getCentre());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($stock);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/api/getOneStock/{id}", name="stock_show", methods={"GET"})
     */
    public function show(StockRepository $stockRepository,$id): Response
    {
        $defaultContent=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet, $format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($stockRepository->getOneStoke($id,$this->getUser()->getCentre()->getId()),200,[],$defaultContent);
    }

    /**
     * @Route("/api/getAndEditStock/{id}", name="stock_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Stock $stock,CentreRepository $repos): Response
    {
        $defaultContent=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet, $format,$context){
                return "Symfony 5";
            }
        ];
        $request=$request->getContent();
        $form=json_decode($request, true);
        $centre=$repos->find($form['idCentre']);
        $stock->setNom($form['nom']);
        $stock->setAdresse($form['adresse']);
        $stock->setCentre($centre);
        $this->getDoctrine()->getManager()->flush();
        return $this->json("Modification reussie",200, [], $defaultContent);
    }

    /**
     * @Route("/api/getDeleteStock/{id}", name="stock_delete", methods={"POST"})
     */
    public function delete(Stock $stock): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($stock);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }

    /**
     * @Route("/api/rechercherStock", name="rechercherStock", methods={"GET","POST"})
     */
    public function rechercherStock(StockRepository $repos, Request $request): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContent=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet, $format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->rechercherStock($content['content']),200,[],$defaultContent);
    }

    /**
     * @Route("/api/verificationNom", name="verificationNom", methods={"GET","POST"})
     */
    public function verificationNom(StockRepository $repos,CentreRepository $centreR, Request $request): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContent=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet, $format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->rechercherStock($content['nom'],$content['idCentre']),200,[],$defaultContent);
    }
}
