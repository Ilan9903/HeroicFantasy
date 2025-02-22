<?php

namespace App\Controller;

use App\Repository\QuestRepository;
use App\Repository\HeroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/quests/available', name: 'api_quests_available', methods: ['GET'])]
    public function getAvailableQuests(QuestRepository $questRepository): JsonResponse
    {
        $quests = $questRepository->findBy(['status' => 'available']);
        $data = array_map(fn($quest) => [
            'id' => $quest->getId(),
            'title' => $quest->getTitle(),
            'description' => $quest->getDescription(),
            'status' => $quest->getStatus()
        ], $quests);

        return $this->json($data);
    }

    #[Route('/api/heroes', name: 'api_heroes', methods: ['GET'])]
    public function getHeroes(HeroRepository $heroRepository): JsonResponse
    {
        $heroes = $heroRepository->findAll();
        $data = array_map(fn($hero) => [
            'id' => $hero->getId(),
            'name' => $hero->getName(),
            'class' => $hero->getClass(),
            'level' => $hero->getLevel(),
        ], $heroes);

        return $this->json($data);
    }
}
