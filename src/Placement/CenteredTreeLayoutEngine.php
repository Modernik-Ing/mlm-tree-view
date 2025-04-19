<?php

namespace Modernik\MlmTreeView\Placement;

use Modernik\MlmTreeView\TreeNode;

/**
 * Implémentation avancée d'un moteur de mise en page centré horizontalement.
 *
 * Cette version garantit un centrage exact à chaque niveau, même si les sous-arbres ont des largeurs différentes.
 * Elle produit un affichage pyramidale parfaitement symétrique.
 */
class CenteredTreeLayoutEngine implements TreeLayoutEngine
{
    /**
     * Taille globale de l'espace de travail.
     */
    private ?Bound $bound = null;

    public function __construct(
        private int $nodeWidth = 120,
        private int $nodeHeight = 60,
        private int $spaceX = 60,
        private int $spaceY = 100
    ) {
    }

    public function layout (TreeNode $root): PositionedTreeNode
    {
        $measured = $this->measure($root);
        $this->bound = new Bound(0, 0, $measured->width, $this->getTreeDepth($root) * ($this->nodeHeight + $this->spaceY));
        return $this->doLayout($measured, -$this->spaceX, 0);
    }

    public function getBound(): Bound
    {
        return $this->bound;
    }

    /**
     * Mesure récursivement la largeur de chaque sous-arbre.
     */
    private function measure(TreeNode $node): MeasuredNode
    {
        $measured = new MeasuredNode();
        $measured->node = $node;

        $children = $node->getChildren();

        if (empty($children)) {
            $measured->width = $this->nodeWidth;
        } else {
            $totalWidth = 0;
            $childNodes = [];

            foreach ($children as $child) {
                $measuredChild = $this->measure($child);
                $childNodes[] = $measuredChild;
                $totalWidth += $measuredChild->width;
            }

            $totalWidth += $this->spaceX * (count($childNodes) - 1);
            $measured->width = max($this->nodeWidth, $totalWidth);
            $measured->children = $childNodes;
        }

        return $measured;
    }

    /**
     * Positionne les nœuds selon les mesures préalables.
     */
    private function doLayout(MeasuredNode $measuredNode, float $xOffset, int $depth): PositionedTreeNode
    {
        $x = $xOffset + ($measuredNode->width / 2);
        $y = $depth * ($this->nodeHeight + $this->spaceY);

        $positioned = new PositionedTreeNode();
        $positioned->node = $measuredNode->node;
        $positioned->bound = new Bound(
            (int) $x,
            (int) $y,
            $this->nodeWidth,
            $this->nodeHeight
        );

        $childOffset = $xOffset;
        foreach ($measuredNode->children as $childMeasured) {
            $child = $this->doLayout($childMeasured, $childOffset, $depth + 1);
            $positioned->children[] = $child;
            $childOffset += $childMeasured->width + $this->spaceX;
        }

        return $positioned;
    }

    /**
     * Calcule récursivement la profondeur maximale de l’arbre à partir d’un nœud donné.
     *
     * @param TreeNode $node Le nœud à partir duquel mesurer la profondeur.
     * @return int La profondeur maximale de l’arbre.
     */
    private function getTreeDepth(TreeNode $node): int
    {
        $max = 0;
        foreach ($node->getChildren() as $child) {
            $depth = $this->getTreeDepth($child);
            if ($depth > $max) {
                $max = $depth;
            }
        }
        return $max + 1;
    }
}
