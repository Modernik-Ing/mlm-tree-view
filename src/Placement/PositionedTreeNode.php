<?php

namespace Modernik\MlmTreeView\Placement;

use Modernik\MlmTreeView\TreeNode;

/**
 * Représente un nœud positionné dans l'arbre, avec ses coordonnées et ses dimensions.
 *
 * Contient une référence au nœud source, sa boîte englobante calculée (bound),
 * et ses enfants positionnés récursivement.
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
     * Liste des enfants positionnés de manière récursive.
     *
     * @var PositionedTreeNode[]
     */
    public array $children = [];

    /**
     * Boîte englobante du nœud positionné, incluant sa position et ses dimensions.
     */
    public ?Bound $bound = null;

    /**
     * Retourne les styles CSS nécessaires pour positionner le nœud dans une interface HTML.
     *
     * @return string Exemple : "left:100px;top:50px;width:120px;height:60px;"
     */
    public function boundToCss () : string
    {
        if ($this->bound === null) {
            return "";
        }
        return $this->bound->toCss();
    }
}
