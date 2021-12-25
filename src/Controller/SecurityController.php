<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $key;

    public function __construct(string $key = 'super_secret_key')
    {
        $this->key = $key;
    }
    // public function login(AuthenticationUtils $authenticationUtils): Response
    // {
    //     // if ($this->getUser()) {
    //     //     return $this->redirectToRoute('target_path');
    //     // }

    //     // get the login error if there is one
    //     $error = $authenticationUtils->getLastAuthenticationError();
    //     // last username entered by the user
    //     $lastUsername = $authenticationUtils->getLastUsername();

    //     return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    // }
    /**
     * @Route("/api/login", name="app_login")
     */
    public function login(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $user = $userRepository->findOneBy(['email'=>$content['email']]);
        $this->getUsers=$userRepository->getUser($content['email']);
        //$this->get('twig')->addGlobal('getUsers', $getUsers);
        
        if (!$user || !$encoder->isPasswordValid($user, $content['password'])) {
            return $this->json(['message' => 'email or password is wrong.',]);
        }
        $payload = [
            "user" => $user->getUsername(),
            "exp"  => (new \DateTime())->modify("+5 minutes")->getTimestamp(),
        ];
        $jwt = JWT::encode($payload, $this->key, 'HS256');
        return $this->json([
            'getUsers' => $this->getUsers,
            'token' => sprintf('Bearer %s', $jwt),
        ]);
    }

    /**
     * @Route("/api/user_connected", name="user_connected")
     */
    public function getUserConnected()
    {
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return 'symfony 4';
            }
        ];
        dd($this->getUSers);
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
