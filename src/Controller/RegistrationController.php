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
        $motdepasse="";
        $request=$request->getContent();
        $form=json_decode($request,true);
        $user->setEmail($form['email']);
        $user->setActif('actif');
        $user->setFirst(0);
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $mp=substr(str_shuffle($chars),0,8);
        if($form['type']=="employe"){
            $user->setRoles(['ROLE_USER_EMPLOYE']);
            $motdepasse=$mp;
            $user->setNom($form['nom']);
            $user->setPrenom($form['prenom']);
            $user->setTel($form['tel']);
            $user->setCentre($this->getUser()->getCentre());
        }elseif ($form['type']=="user"){
            $motdepasse=$form['password'];
            $user->setNom($form['nom']);
            $user->setPrenom($form['prenom']);
            $user->setTel($form['tel']);
            $user->setRoles(['ROLE_USER']);
        }else{
            $motdepasse="password";
            $user->setCentre($reposo->find($repos->getUser($form['email'])) );
            $user->setRoles(['ROLE_ADMIN_CENTRE']);

        }
        $user->setPassword($enccoder->encodePassword($user,$motdepasse));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        if($this->getUser()->getCentre()){
            $user->setCentre($this->getUser()->getCentre());
        }
        $user->setSlug($enccoder->encodePassword($user,$repos->findOneBy(['email'=>$form['email']])->getSlug()));
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
