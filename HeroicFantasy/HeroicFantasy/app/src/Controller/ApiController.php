<?php

namespace App\Controller;

use App\Repository\QuestRepository;
use App\Repository\HeroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Quest;
use App\Entity\Reward;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/quests', name: 'api_quests_add', methods: ['POST'])]
    public function createQuest(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['title'], $data['description'], $data['reward'], $data['experienceGained'])) {
            return new JsonResponse(['message' => 'Données invalides'], Response::HTTP_BAD_REQUEST);
        }

        $quest = new Quest();
        $quest->setTitle($data['title']);
        $quest->setDescription($data['description']);
        $quest->setStatus("available");
        $quest->setExperienceGained($data['experienceGained']);

        $reward = new Reward();
        $reward->setAmount($data['reward']['amount']);
        $reward->setDescription($data['reward']['description']);

        $quest->setReward($reward);

        $entityManager->persist($reward);
        $entityManager->persist($quest);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Quête créée avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/api/quests/available', name: 'api_quests_available', methods: ['GET'])]
    public function getAvailableQuests(QuestRepository $questRepository): JsonResponse
    {
        $quests = $questRepository->findBy(['status' => 'available']);

        $data = array_map(fn($quest) => [
            'id' => $quest->getId(),
            'title' => $quest->getTitle(),
            'description' => $quest->getDescription(),
            'status' => $quest->getStatus(),
            'experienceGained' => $quest->getExperienceGained(),
            'reward' => [
                'amount' => $quest->getReward()->getAmount(),
                'description' => $quest->getReward()->getDescription(),
            ],
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
