<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrognosticController extends AbstractController
{
    #[Route('/prognostic', name: 'prognostic')]
    public function index(): Response
    {
        return $this->render('prognostic/prognostic.html.twig', [
            'controller_name' => 'PrognosticController',
        ]);
    }
}
