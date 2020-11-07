<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Déclaration de la configuration custom.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('app');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('titre') // Titre à afficher sur l'interface
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('infos_connexion') // Détail du mode connexion affiché sur la page login
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('jour') // Jour des permanences dimanche = 0 / samedi = 6
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('seuil_alert_animateur') //En dessous du nombre d'animateur indiqué la date sera signalée en rouge
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('seuil_anim_ok') // Au dessus du nombre d'animateur indiqué la date sera signalée en vert
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('equilibrage_pourcent_par_groupe') // Au dessus du nombre d'animateur indiqué la date sera signalée en vert pour les animateurs occasionnels n'équilibrant pas les groupes
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('decoupage_permanence') // Groupes gérés pendant une permanence
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name') // Nom du groupe
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('horaire') // Horaire du groupe
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
