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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/profile', name: 'profile')]
    public function profile(User $user = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->security->getUser();

        // Formulaire changement d'informations générale

        $form1 = $this->get('form.factory')->createNamedBuilder('modifyForm', 'Symfony\Component\Form\Extension\Core\Type\FormType', $user)
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
            ->add('submit', SubmitType::class, [
                'label'=> 'Enregistrer les modifications'
            ])
            ->getForm();

        $form1->handleRequest($request);

        if($form1->isSubmitted() && $form1->isValid()) {

            if(!$user->getId()) {
                // TODO : set last modification date : $user->setLastConnection(new \DateTime());
            }

            $manager->persist($user);
            $manager->flush();

            //return $this->redirectToRoute('profile');
        }


        // Formulaire changement de mot de passe

        $form2 = $this->get('form.factory')->createNamedBuilder('passwordForm', 'Symfony\Component\Form\Extension\Core\Type\FormType')
            ->add('actualPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe actuel'
            ])
            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=> 'Les 2 nouveaux mots de passe ne sont pas identiques !',
                'required'=>true,
                'first_options'=> ['label' => 'Nouveau mot de passe'],
                'second_options'=> ['label' => 'Confirmer le nouveau mot de passe']
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'Modifier le mot de passe'
            ])
            ->getForm();
        $form2->handleRequest($request);

        if($form2->isSubmitted() && $form2->isValid()) {
            $match = $encoder->isPasswordValid($this->security->getUser(), $form2->get('actualPassword')->getData());
            if($match){
                $user->setPassword($encoder->encodePassword($user, $form2->get('password')->getData()));
            } else {
                dd('error');
            }

            //
            // TODO : set last modification date : $user->setLastConnection(new \DateTime());

            $manager->persist($user);
            $manager->flush();

            //return $this->redirectToRoute('profile');
        }


        // Formulaire changement d'adresse

        $form3 = $this->get('form.factory')->createNamedBuilder('addressForm', 'Symfony\Component\Form\Extension\Core\Type\FormType', $user)
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'Enregistrer les modifications'
            ])
            ->getForm();

        $form3->handleRequest($request);

        if($form3->isSubmitted() && $form3->isValid()) {

            if(!$user->getId()) {
                // TODO : set last modification date : $user->setLastConnection(new \DateTime());
            }

            $manager->persist($user);
            $manager->flush();

            //return $this->redirectToRoute('profile');
        }

        // Gestion des variables

        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
            'modifyForm' => $form1->createView(),
            'passwordForm' => $form2->createView(),
            'addressForm' => $form3->createView(),
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
            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=> 'Les 2 mots de passe ne sont pas identiques !',
                'required'=>true,
                'first_options'=> ['label' => 'Mot de passe'],
                'second_options'=> ['label' => 'Confirmer le mot de passe']
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

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
            'registerForm' => $form->createView(),

        ]);
    }
}
