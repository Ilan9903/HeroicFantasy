<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\User;
use App\Entity\Hero;

#[IsGranted("ROLE_USER")]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index()
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir le Dashboard.');
        }

        $heroes = $user->getHeroes();
        $hasHeroes = count($heroes) > 0;
        $hasMaxHeroes = count($heroes) >= 3;

        return $this->render('dashboard/index.html.twig', [
            'hasHeroes' => $hasHeroes,
            'hasMaxHeroes' => $hasMaxHeroes,
        ]);
    }
}
