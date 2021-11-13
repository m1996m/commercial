<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\ClientCentre;
use App\Entity\User;
use App\Form\ClientType;
use App\Repository\ClientCentreRepository;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client_index", methods={"GET"})
     */
    public function index(ClientCentreRepository $clientRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($clientRepository->getAll($this->getUser()->getCentre()),200);
    }

    /**
     * @Route("/client/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $encoder,ClientRepository $repos): Response
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
        $ClientCentre = new ClientCentre();
        $client=$repos->findOneBy(['tel'=>$form['tel']]);
        $ClientCentre->setCentre($this->getUser()->getCentre());
        $ClientCentre->setClient($client);
        $entityManager->persist($ClientCentre);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getCLient/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($client,200,[],$defaultContext);
    }

    /**
     * @Route("/rechercherClient", name="rechercherCLient", methods={"GET"})
     */
    public function rechercherClient(Request $request, ClientRepository $repos): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->rechercherClient($content['content']),200,[],$defaultContext);
    }

    /**
     * @Route("/getAndEditClient/{id}", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $request=$request->getContent();
        $form=json_decode($request,true);
        $client->setNom($form['nom']);
        $client->setPrenom($form['prenom']);
        $client->setTel($form['tel']);
        $client->setAdresse($form['adresse']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json('Modification reussie', 200,[],$defaultContext);
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

    /**
     * @Route("/verificationUniciteTelClient", name="verificationUniciteClient", methods={"GET"})
     */
    public function verificationUniciteClient(ClientRepository $repos,Request $request): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->getTel($content['tel']),200);
    }
}
