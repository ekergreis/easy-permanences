<?php
namespace App\DataFixtures\Faker;

use App\Entity\Group;

class CustomProvider
{

    /**
     * Retourne le groupe passé en paramètre si l'animateur est régulier
     * @param bool $animRegulier
     * @param Group $groupAffect
     * @return Group | null
     */
    public function groupPourAnimReguliers(bool $animRegulier, Group $groupAffect): ?Group
    {
        if ($animRegulier) return $groupAffect;
        return null;
    }

    /**
     * Retourne un entier aléatoire entre 1 et le nombre passé en paramètre
     * Permet de compenser le bug nelmio/alice
     * de passage de 2 paramètres dans une méthode custom
     * @param int $maxId
     * @return int
     * @throws \Exception
     */
    public function customRandomNumber(int $maxId): int
    {
        return random_int(1, $maxId);
    }
}
