<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login_check", name="app_login")
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

        return $this->json('Ok');
    }

        /**
     * @Route("/api/user_connected", name="check_login")
     */
    public function getUserConnected()
    {
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return 'symfony 4';
            }
        ];
        return $this->json(['user' => $this->getUser()], 200, [], $defaultContext);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
