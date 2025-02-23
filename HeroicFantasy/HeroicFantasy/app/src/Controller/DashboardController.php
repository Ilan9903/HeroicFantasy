<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Quest;
use Doctrine\ORM\EntityManagerInterface;

#[IsGranted("ROLE_USER")]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir le Dashboard.');
        }

        $heroes = $user->getHeroes();
        $hasHeroes = count($heroes) > 0;
        $hasMaxHeroes = count($heroes) >= 3;

        // 📌 Récupérer le héros sélectionné de l'utilisateur
        $selectedHero = $user->getSelectedHero();

        // 📌 Récupérer la quête active du héros sélectionné
        $currentQuest = null;
        if ($selectedHero) {
            $currentQuest = $entityManager->getRepository(Quest::class)->findOneBy(['hero' => $selectedHero, 'status' => 'assigned']);
        }

        return $this->render('dashboard/index.html.twig', [
            'hasHeroes' => $hasHeroes,
            'hasMaxHeroes' => $hasMaxHeroes,
            'selectedHero' => $selectedHero,
            'currentQuest' => $currentQuest,
        ]);
    }

    #[Route('/quest/complete/{id}', name: 'quest_complete')]
    public function completeQuest(Quest $quest, EntityManagerInterface $entityManager)
    {
        $hero = $quest->getHero();
        if (!$hero || $hero !== $this->getUser()->getSelectedHero()) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas terminer cette quête.");
        }

        // Ajouter la récompense au héros
        $hero->setExperience($hero->getExperience() + $quest->getExperienceGained());

        // Augmenter le niveau du héros
        $hero->setLevel($hero->getLevel() + 1);

        // Supprimer la quête active
        $quest->setStatus('completed');
        $hero->setCurrentQuest(null);
        $quest->setHero(null);

        $entityManager->persist($hero);
        $entityManager->remove($quest);
        $entityManager->flush();

        $this->addFlash('success', "Quête complétée !");
        return $this->redirectToRoute('app_dashboard');
    }

    #[Route('/quest/abandon/{id}', name: 'quest_abandon')]
    public function abandonQuest(Quest $quest, EntityManagerInterface $entityManager)
    {
        $hero = $quest->getHero();
        if (!$hero || $hero !== $this->getUser()->getSelectedHero()) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas abandonner cette quête.");
        }

        // Remettre la quête en "available"
        $quest->setStatus('available');
        $quest->setHero(null);
        $hero->setCurrentQuest(null);

        $entityManager->persist($quest);
        $entityManager->persist($hero);
        $entityManager->flush();

        $this->addFlash('info', "Quête abandonnée.");
        return $this->redirectToRoute('app_dashboard');
    }
}
