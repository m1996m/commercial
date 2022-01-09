<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->json('security/login.html.twig',200);
    }

    /**
     * @Route("/api/connexion", name="app_connexion")
     */
    public function connexion()
    {
        $defaultContent=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet, $format,$context){
                return "Symfony 5";
            }
        ];
        $user=['id'=>$this->getUser()->getId(),'centre'=>$this->getUser()->getCentre()->getNom(),'slug'=>$this->getUser()->getSlug(),'role'=>$this->getUser()->getRoles(),'nom'=>$this->getUser()->getNom(),'prenom'=>$this->getUser()->getPrenom(),'tel'=>$this->getUser()->getTel(),'image'=>$this->getUser()->getImage()];
        return $this->json($user,200,[],$defaultContent);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
