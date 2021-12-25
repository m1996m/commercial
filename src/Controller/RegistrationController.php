<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CentreRepository;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register", methods={"GET","POST"})
     */
    public function register(CentreRepository $reposo,Request $request,UserRepository $repos,UserPasswordEncoderInterface $enccoder, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $centre=$reposo->find(1);
        $request=$request->getContent();
        $form=json_decode($request,true);
        $user->setEmail($form['email']);
        $user->setActif('non');
        $user->setNom($form['nom']);
        $user->setPrenom($form['prenom']);
        $user->setCentre($centre);
        $user->setTel($form['tel']);
        $user->setFirst(0);
        //$user->setSlug($enccoder->encodePassword($user,$user->getSlug()));
        $user->setPassword($enccoder->encodePassword($user,$form['password']));
        if($repos->findAll()){
            $user->setRoles(['ROLE_USER']);
        }else{
            $user->setRoles(['ROLE_ADMIN']);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        // do anything else you need here, like send an email
        return $this->json('ok',200);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
