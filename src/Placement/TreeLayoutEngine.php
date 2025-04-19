<?php

namespace Modernik\MlmTreeView\Placement;

use Modernik\MlmTreeView\TreeNode;

/**
 * Interface pour les moteurs de disposition d'un arbre hiérarchique.
 *
 * Un TreeLayoutEngine prend un arbre logique et le transforme en une structure
 * positionnée avec des coordonnées (x, y) qui peut ensuite être utilisée pour un
 * rendu graphique ou HTML.
 */
interface TreeLayoutEngine
{
    /**
     * Calcule et retourne un arbre positionné à partir d'un arbre logique.
     *
     * @param TreeNode $root Le nœud racine de l'arbre à positionner
     * @return PositionedTreeNode L'arbre enrichi de coordonnées de placement
     */
    public function layout(TreeNode $root): PositionedTreeNode;


    /**
     * Taille de l'espace de travail
     * @return Bound
     */
    public function getBound() : Bound;
}
