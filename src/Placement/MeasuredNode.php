<?php

namespace Modernik\MlmTreeView\Placement;

use Modernik\MlmTreeView\TreeNode;

/**
 * Classe utilitaire représentant un nœud de l’arbre accompagné de ses dimensions calculées.
 *
 * Cette classe est utilisée comme structure intermédiaire pendant le processus de mise en page
 * d’un arbre hiérarchique. Elle stocke :
 * → la largeur nécessaire pour afficher le sous-arbre enraciné à ce nœud,
 * → la hauteur totale jusqu’à ses feuilles,
 * → ainsi qu’un lien vers le nœud d’origine (TreeNode) et ses enfants mesurés.
 *
 * Elle permet à un moteur de rendu de prendre des décisions d’agencement plus précises
 * (centrage, espacement, positionnement relatif, etc.).
 *
 * @see TreeLayoutEngine
 * @author Esaie Muhasa
 */
class MeasuredNode
{
    /**
     * Le nœud métier d’origine.
     *
     * @var TreeNode
     */
    public TreeNode $node;

    /**
     * Largeur calculée du sous-arbre enraciné ici (incluant tous ses enfants).
     *
     * @var float|int
     */
    public int|float $width = 0;

    /**
     * Hauteur calculée du sous-arbre enraciné ici.
     *
     * @var float|int
     */
    public int|float $height = 0;

    /**
     * Liste des nœuds enfants également mesurés.
     *
     * @var MeasuredNode[]
     */
    public array $children = [];
}
