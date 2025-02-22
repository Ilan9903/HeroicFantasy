<?php

namespace App\Controller;

use App\Entity\Quest;
use App\Repository\QuestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_USER")]
class PNJController extends AbstractController
{
    #[Route('/dashboard/meet-pnj', name: 'meet_pnj')]
    public function meetPNJ()
    {
        $user = $this->getUser();
        $heroes = $user->getHeroes();

        // 📌 Vérifie si le joueur a au moins un héros
        if (count($heroes) === 0) {
            $this->addFlash('danger', 'Vous devez avoir un héros pour interagir avec le PNJ.');
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('pnj/index.html.twig');
    }

    #[Route('/dashboard/receive-quest', name: 'receive_quest')]
    public function receiveQuest(QuestRepository $questRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $heroes = $user->getHeroes();

        // 📌 Vérifie si le joueur a au moins un héros
        if (count($heroes) === 0) {
            $this->addFlash('danger', 'Vous devez avoir un héros pour recevoir une quête.');
            return $this->redirectToRoute('app_dashboard');
        }

        $hero = $heroes->first(); // 📌 Sélectionne le premier héros du joueur

        // 📌 Récupère une quête disponible au hasard
        $availableQuests = $questRepository->findBy(['status' => 'available']);
        if (!empty($availableQuests)) {
            $quest = $availableQuests[array_rand($availableQuests)];
            $quest->setStatus('assigned');
            $quest->setHero($hero);

            $em->persist($quest);
            $em->flush();

            $this->addFlash('success', "Vous avez reçu la quête : " . $quest->getTitle());
        } else {
            $this->addFlash('warning', "Aucune quête disponible pour le moment.");
        }

        return $this->redirectToRoute('meet_pnj');
    }
}
