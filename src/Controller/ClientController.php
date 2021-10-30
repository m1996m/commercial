<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->json($clientRepository->findAll(),200);
    }

    /**
     * @Route("/client/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $client = new Client();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $client->setNom($form['nom']);
        $client->setPrenom($form['prenom']);
        $client->setTel($form['tel']);
        $client->setAdresse($form['adresse']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getCLient/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->json($client,200);
    }

    /**
     * @Route("/rechercherClient", name="rechercherCLient", methods={"GET"})
     */
    public function rechercherClient(Request $request, ClientRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->rechercherClient($content['content']),200);
    }

    /**
     * @Route("/getAndEditClient/{id}", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $request=$request->getContent();
        $form=json_decode($request,true);
        $client->setNom($form['nom']);
        $client->setPrenom($form['prenom']);
        $client->setTel($form['tel']);
        $client->setAdresse($form['adresse']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json('Modification reussie', 200);
    }

    /**
     * @Route("/client/getRemove/{id}", name="client_delete", methods={"POST"})
     */
    public function delete(Request $request, Client $client): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($client);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }
}
