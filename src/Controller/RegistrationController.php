<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegistrationEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        // dd($user);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                    )
                );
                
                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email
                
                $this->addFlash('success', 'Votre compte à bien été crée'); // je crée un message flash de confirmation de création de compte
                return $this->redirectToRoute('app_blog'); // je redirige la personne vers la route app_blog
            }
            
            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
    }

    #[Route('/register/{id}/edit-user', name: 'app_register_edit')]
    public function registerEdit(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, User $user): Response
    {
        
        $form = $this->createForm(RegistrationEditFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if(empty($form->get('password')->getData()))
            {
                $user->setPassword($user->getPassword());
            }
            else {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                        )
                    );
            }
            // encode the plain password
                
                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email
                
                $this->addFlash('success', 'Vos informations ont bien été mis à jour.'); // je crée un message flash de confirmation de création de compte
                return $this->redirectToRoute('app_blog'); // je redirige la personne vers la route app_blog
            }
            
            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
    }

}
