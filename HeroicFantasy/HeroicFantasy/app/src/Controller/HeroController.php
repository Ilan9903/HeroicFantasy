<?php

namespace App\Controller;

use App\Entity\Hero;
use App\Form\HeroType;
use App\Repository\HeroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class HeroController extends AbstractController
{
    #[Route('dashboard/create-hero', name: 'hero_create')]
    public function createHero(Request $request, EntityManagerInterface $entityManager, HeroRepository $heroRepository): Response
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur a déjà 3 héros
        $existingHeroes = $heroRepository->count(['user' => $user]);
        if ($existingHeroes >= 3) {
            $this->addFlash('danger', 'Vous ne pouvez pas créer plus de 3 héros.');
            return $this->redirectToRoute('app_dashboard'); // Rediriger vers le dashboard
        }

        $hero = new Hero();
        $hero->setLevel(1);
        $hero->setExperience(0);
        $hero->setUser($user); // Associer le héros à l'utilisateur

        $form = $this->createForm(HeroType::class, $hero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hero);
            $entityManager->flush();

            $this->addFlash('success', 'Votre héros a été créé avec succès !');
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('hero/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('dashboard/select-hero', name: 'hero_select')]
    public function selectHero(HeroRepository $heroRepository): Response
    {
        $user = $this->getUser();
        $heroes = $heroRepository->findBy(['user' => $user]); // Récupérer les héros de l'utilisateur

        return $this->render('hero/select.html.twig', [
            'heroes' => $heroes,
        ]);
    }

    #[Route('dashboard/set-hero/{id}', name: 'set_active_hero')]
    public function setActiveHero(Hero $hero, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'utilisateur est bien le propriétaire du héros
        if ($hero->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Ce héros ne vous appartient pas !");
        }

        // Définir le héros sélectionné comme actif dans la session
        $session = $request->getSession();
        $session->set('active_hero', $hero->getId());

        $this->getUser()->setSelectedHero($hero);
        $entityManager->persist($this->getUser());
        $entityManager->flush();

        $this->addFlash('success', 'Héros sélectionné avec succès !');

        return $this->redirectToRoute('app_dashboard'); // Redirige vers le dashboard
    }
}
