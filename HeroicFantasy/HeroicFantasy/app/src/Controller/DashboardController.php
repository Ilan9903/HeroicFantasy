<?php

namespace App\Controller;

use App\Entity\Hero;
use App\Entity\Quest;
use App\Repository\HeroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/dashboard')]
#[IsGranted('ROLE_USER')] // Sécurisation : seulement les utilisateurs connectés
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(HeroRepository $heroRepository): Response
    {
        $user = $this->getUser();
        $hero = $heroRepository->findOneBy(['user' => $user]); // Récupérer le héros de l'utilisateur

        return $this->render('dashboard/index.html.twig', [
            'hero' => $hero,
        ]);
    }
}
