<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
      
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        
        return $this->render('account/login.html.twig',[
            'hasError' => $error !==  null,
            'username' => $username
        ]);
    }
     /**
     * Permet de se déconnecter
     * 
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout() {

    }
    /**
     * Permet d'afficher le formulaire d'inscription
     * 
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder) {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
       
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "التح تم التسجيل بنجاح. يمكنك تسجيل الدخول "
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * Permet d'afficher de traiter le formulaire de modification de profil
     * 
     * @Route("/account/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function profile(Request $request) {
        // récupère l'utilisateur en cours
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "التحيين تم بنجاح "
            );
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
/**
     * Permet de modifier le mot de passe
     * 
     * @Route("/account/password-update", name="account_password")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder) {
        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // 1. Vérifier que le oldPassword du form soit le même que le password de l'user
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getHash())) {
                // Gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("كلمة السر التي ادخلتها ليست نفسها كلمة السر"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setHash($hash);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "تم تغير كلمة السر بنجاح "
                );

                return $this->redirectToRoute('home');
            }
        }
        
        return $this->render('account/password.html.twig', [
           'form' => $form->createView() 
        ]);
    }
    /**
     * Permet d'afficher un profil d'utilisateur 'mon compte'
     * @Route("/account", name="account_index")
     * @IsGranted("ROLE_USER")
     * @return Response
     */

    public function myAccount(){
        return $this->render('user/index.html.twig',[
            'user' => $this->getUser()
        ]);
    }


}
