<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/subscription', name: 'subscription')]
    public function subscription(EntityManagerInterface $manager): Response
    {
        return $this->render('subscription/subscription.html.twig', [
            'subscriptions' => $manager->getRepository(Subscription::class)->findAll(),
            'controller_name' => 'SubscriptionController',
        ]);
    }
}
