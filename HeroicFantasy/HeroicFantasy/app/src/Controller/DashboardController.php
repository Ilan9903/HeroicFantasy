<?php

namespace App\Controller;

use App\Entity\Hero;
use App\Entity\Quest;
use App\Repository\HeroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')] // Sécurisation : seulement les utilisateurs connectés
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(HeroRepository $heroRepository, Request $request): Response
    {
        $session = $request->getSession();
        $heroId = $session->get('active_hero'); // Récupère le héros actif

        /*if (!$heroId) {
            return $this->redirectToRoute('hero_create'); // Redirige si aucun héros sélectionné
        }*/

        $hero = $heroRepository->find($heroId);

        return $this->render('dashboard/index.html.twig', [
            'hero' => $hero,
        ]);
    }
}
