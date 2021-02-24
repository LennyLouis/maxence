<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Cast\Int_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(User $user = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {


        if(!$user){
            $user = new User();
        }

        $form = $this->createFormBuilder($user)
            ->add('firstname', TextType::class, [
                'label'=> 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label'=> 'Nom de famille'
            ])
            ->add('username', TextType::class, [
                'label'=> 'Pseudo'
            ])
            ->add('birthdate', DateType::class, [
                'label'=> 'Date de naissance',
                'years' => range(date('Y')-17, date('Y')-100)
            ])
            ->add('mail')
            ->add('avatar', FileType::class, [
                'label'=> 'Photo de profil',
                'mapped'=> false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5120k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci d\'envoyer une image au format PNG, JPG, JPEG',
                    ])
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'label'=> 'Genre',
                'choices'  => [
                    'Homme' => 'men',
                    'Femme' => 'women',
                    'Autre' => 'other',
                ],
            ])
            ->add('password', PasswordType::class, [
                'label'=> 'Mot de passe'
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'S\'inscrire !'
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if(!$user->getId()) {
                $user->setPassword($encoder->encodePassword($user, $form->getData()->getPassword()));
                $user->setCreatedAt(new \DateTime());
                $user->setLastConnection(new \DateTime());
                $user->setAccountStatus('pending');
            }

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
            'registerForm' => $form->createView(),

        ]);
    }
}
