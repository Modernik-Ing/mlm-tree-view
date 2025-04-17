<?php

namespace Modernik\MlmTreeView\Placement;

use Modernik\MlmTreeView\TreeNode;

/**
 * Représente un nœud d'arbre positionné avec des coordonnées explicites.
 *
 * Cette structure est utilisée après le calcul de placement
 * pour le rendu graphique ou HTML d'un arbre hiérarchique.
 * Elle encapsule le nœud logique d'origine (`TreeNode`) ainsi que ses
 * coordonnées (`x`, `y`) dans un plan bidimensionnel, en plus de ses enfants
 * positionnés récursivement.
 *
 * @package Modernik\MlmTreeView\Placement
 */
class PositionedTreeNode
{
    /**
     * Instance du nœud de données d'origine.
     *
     * @var TreeNode
     */
    public TreeNode $node;

    /**
     * Position horizontale calculée du nœud.
     *
     * Peut être exprimée en pixels ou en unités logiques selon l’usage.
     *
     * @var int|float
     */
    public int|float $x;

    /**
     * Position verticale calculée du nœud (généralement selon la profondeur).
     *
     * @var int|float
     */
    public int|float $y;

    /**
     * Liste des enfants positionnés de manière récursive.
     *
     * @var PositionedTreeNode[]
     */
    public array $children = [];
}
