<?php


namespace App\Utils;

use App\Entity\User;
use App\Entity\Permanence;
use Doctrine\ORM\EntityManagerInterface;

class TraitementPermanences
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Génération du tableau des permanences enregistrés
     * @param User $user
     * @return array
     */
    public function extractInfos(User $user)
    {
        //Initialisation du tableau à retourner
        $arrayPermanence = [
            'permanences' => null,
            'next_permanence' => null,
            'nb_permanence' => 0,
        ];

        $permanences = $this->em
            ->getRepository(Permanence::class)
            ->findBy([], ['date' => 'ASC']);

        // Parcours de l'ensemble des permanences
        foreach($permanences as $permanence) {
            // Initialisation 1ère dimension tableau pour un mois (affichage ligne)
            $month = $permanence->getDate()->format('m-Y');
            // Initialisation 2ème dimension tableau pour un jour de permanence (affichage colonne)
            $day = $permanence->getDate()->format('d');

            // Initialisation tableau pour permanence
            $arrayPermanence['permanences'][$month][$day] = [
                'date' => $permanence->getDate(),
                'user' => false,
                'group' => $permanence->getGroup(),
            ];

            // Parcours des utilisateurs liés à la permanence
            foreach ($permanence->getUsers() as $userPermanence) {
                // Si l'utilisateur connecté et affecté à la permanence
                if($user == $userPermanence) {
                    if(null == $arrayPermanence['next_permanence']) {
                        $arrayPermanence['next_permanence'] = $permanence->getDate();
                    }
                    $arrayPermanence['nb_permanence']++;
                    $arrayPermanence['permanences'][$month][$day]['user'] = true;
                }
            }
        }

        return $arrayPermanence;
    }
}