<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class UserController extends AbstractController
{
    // /**
    //  * @Route("/employe", name="employe_index", methods={"GET"})
    //  */
    // public function index(UserRepository $userRepository): Response
    // {
    //     $defaultContext=[
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
    //             return "Symfony 5";
    //         }
    //     ];
    //     return $this->json($userRepository->getAll(1),200,[],$defaultContext);
    // }

    // /**
    //  * @Route("/getAndEditEmploye/{slug}", name="getAndEditEmploye", methods={"GET","POST"})
    //  */
    // public function editEmploye(Request $request,User $user,UserPasswordEncoderInterface $encoder): Response
    // {
    //     $defaultContext=[
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
    //             return "Symfony 5";
    //         }
    //     ];
    //     $request=$request->getContent();
    //     $form=json_decode($request,true);
    //     dd($form);
    //     $entityManager = $this->getDoctrine()->getManager();
    //     //$centre=$entityManager->getRepository(Centre::class)->find($form['centre']);
    //     $user->setNom($form['nom']);
    //     $user->setPrenom($form['prenom']);
    //     $user->setActif($form['actif']);
    //     $user->setTel($form['tel']);
    //     $user->setImage($form['image']);
    //     if($form['nouveau']!=" "){
    //         $user->setPassword($encoder->encodePassword($user,$form['nouveau']));
    //     }
    //     $user->setFonction($form['fonction']);
    //     $user->setRoles([$form['roles']]);
    //     //$user->setCentre($centre);
    //     if($user->getFirst()==0){
    //         $user->setSlug($encoder->encodePassword($user,$user->getSlug()));
    //         $user->setFirst(1);
    //     }
    //     $entityManager->flush();
    //     return $this->json('Modification reussie', 200,[], $defaultContext);
    // }

    //     /**
    //  * @Route("/uploadFile/{slug}", name="uploadFile", methods={"GET","POST"})
    //  */
    // public function uploadFile(Request $request,User $user,UserPasswordEncoderInterface $encoder): Response
    // {
    //     $defaultContext=[
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
    //             return "Symfony 5";
    //         }
    //     ];
    //     $entityManager = $this->getDoctrine()->getManager();
    //     $request=$request->getContent();
    //     $form=json_decode($request,true);
    //     $user->setImage($form['image']);
    //     $entityManager->flush();
    //     return $this->json('Modification reussie', 200,[], $defaultContext);
    // }

    // /**
    //  * @Route("/getOneUser/{slug}", name="employe_show", methods={"GET"})
    //  */
    // public function show(UserRepository $userRepository,$slug): Response
    // {
    //     $defaultContext=[
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
    //             return "Symfony 5";
    //         }
    //     ];
    //     return $this->json($userRepository->getOneUser($slug),200,[],$defaultContext);
    // }
    // /**
    //  * @Route("/rechercherEmploye", name="rechercherEmploye", methods={"GET","POST"})
    //  */
    // public function rechercherEmploye(UserRepository $repos,Request $request): Response
    // {
    //     $defaultContext=[
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
    //             return "Symfony 5";
    //         }
    //     ];
    //     $request=$request->getContent();
    //     $content=json_decode($request,true);
    //     return $this->json($repos->rechercherEmploye($content['content'],1),200,[],$defaultContext);
    // }

    // /**
    //  * @Route("/verificationUniciteTel", name="verificationUniciteTel", methods={"GET","POST"})
    //  */
    // public function verificationUniciteTel(UserRepository $repos,Request $request): Response
    // {
    //     $defaultContext=[
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
    //             return "Symfony 5";
    //         }
    //     ];
    //     $request=$request->getContent();
    //     $content=json_decode($request,true);
    //     return $this->json($repos->getTel($content['tel']),200,[],$defaultContext);
    // }

    // /**
    //  * @Route("/verificationUniciteEmail", name="verificationUniciteEmail", methods={"GET","POST"})
    //  */
    // public function verificationUniciteEmail(UserRepository $repos,Request $request): Response
    // {
    //     $defaultContext=[
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
    //             return "Symfony 5";
    //         }
    //     ];
    //     $request=$request->getContent();
    //     $content=json_decode($request,true);
    //     return $this->json($repos->getEmail($content['email']),200,[],$defaultContext);
    // }

    // /**
    //  * @Route("/ValiditeModePasse/{slug}", name="ValiditeModePasse", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    // {
    //     $defaultContext=[
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
    //             return "Symfony 5";
    //         }
    //     ];
    //     $isValid=0;
    //     $request=$request->getContent();
    //     $form=json_decode($request,true);
    //     $ancien=$form['ancien'];
    //     $nouveau=$form['nouveau'];
    //     $passwordValid=$encoder->isPasswordValid($user,$ancien);
    //     $nouveauValid=$encoder->isPasswordValid($user,$nouveau);
    //     if($passwordValid===true){
    //         $isValid=1;
    //     }
    //     if($form['nouveau']!=null)
    //     {
    //         $isValid=0;
    //     }
    //     if(!$nouveauValid){
    //         $isValid=1;
    //     }
    //     return $this->json($isValid,200, [], $defaultContext);
    // }

    // /**
    //  * @Route("/getDeleteEmploye/{slug}", name="employe_delete", methods={"POST"})
    //  */
    // public function delete(Request $request, User $user): Response
    // {
    //     $entityManager = $this->getDoctrine()->getManager();
    //     $entityManager->remove($user);
    //     $entityManager->flush();
    //     return $this->redirectToRoute('employe_index', [], Response::HTTP_SEE_OTHER);
    // }
}
