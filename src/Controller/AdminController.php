<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function users(EntityManagerInterface $manager): Response
    {
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $manager->getRepository(User::class)->findAll(),
        ]);
    }

    #[Route('/admin/subscriptions', name: 'admin_subscriptions')]
    public function subscriptions(EntityManagerInterface $manager): Response
    {
        return $this->render('admin/subscriptions.html.twig', [
            'controller_name' => 'AdminController',
            'subscriptions' => $manager->getRepository(Subscription::class)->findAll(),
        ]);
    }

    #[Route('/admin/subscriptions/new', name: 'admin_subscriptions_new')]
    public function subscriptions_new(EntityManagerInterface $manager, Request $request): Response
    {

        $sub = new Subscription();

        $form = $this->get('form.factory')->createNamedBuilder('createForm', 'Symfony\Component\Form\Extension\Core\Type\FormType', $sub)
            ->add('name', TextType::class, [
                'label'=> 'Nom de l\'abonnement'
            ])
            ->add('description', TextareaType::class, [
                'label'=> 'Description'
            ])
            ->add('price', NumberType::class, [
                'label'=> 'Prix'
            ])
            /*->add('image', FileType::class, [
                'label'=> 'Image',
                'required' => false
            ])*/
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Affiché' => 'shown',
                    'Caché' => 'hidden',
                    'Desactivé (affiché mais bouton non cliquable)' => 'disable'
                ],
                'label'=> 'Status'
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'Ajouter'
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($sub);
            $manager->flush();

            return $this->redirectToRoute('admin_subscriptions');
        }


        return $this->render('admin/newSubscriptions.html.twig', [
            'controller_name' => 'AdminController',
            'createForm' => $form->createView()
        ]);
    }

    #[Route('/admin/subscriptions/{id}', name: 'admin_subscriptions_edit')]
    public function subscriptions_edit(EntityManagerInterface $manager, Request $request, int $id): Response
    {

        $sub = $manager->getRepository(Subscription::class)->find($id);

        $form = $this->get('form.factory')->createNamedBuilder('modifyForm', 'Symfony\Component\Form\Extension\Core\Type\FormType', $sub)
            ->add('name', TextType::class, [
                'label'=> 'Nom de l\'abonnement'
            ])
            ->add('description', TextareaType::class, [
                'label'=> 'Description'
            ])
            ->add('price', NumberType::class, [
                'label'=> 'Prix'
            ])
            /*->add('image', FileType::class, [
                'label'=> 'Image',
                'required' => false
            ])*/
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Affiché' => 'shown',
                    'Caché' => 'hidden',
                    'Desactivé (affiché mais bouton non cliquable)' => 'disable'
                ],
                'label'=> 'Status'
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'Enregistrer les modifications'
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($sub);
            $manager->flush();

            //return $this->redirectToRoute('profile');
        }


        return $this->render('admin/editSubscriptions.html.twig', [
            'controller_name' => 'AdminController',
            'modifyForm' => $form->createView(),
            'sub' => $sub,
        ]);
    }
}
