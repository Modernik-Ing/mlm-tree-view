<?php

namespace Modernik\MlmTreeView\Placement;

use InvalidArgumentException;
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
        private int $spaceY = 100,
        private string $orientation = self::ORIENTATION_HORIZONTAL
    ) {
        if (!in_array($this->orientation, [self::ORIENTATION_HORIZONTAL, self::ORIENTATION_VERTICAL])) {
            throw new InvalidArgumentException("Unknown orientation : $this->orientation");
        }
    }

    /**
     * @inheritDoc
     */
    public function layout (TreeNode $root): PositionedTreeNode
    {
        $measured = $this->measure($root);
        $depth = $this->getTreeDepth($root);

        if ($this->orientation === self::ORIENTATION_VERTICAL) {
            $this->bound = new Bound(
                0,
                0,
                ($depth * ($this->spaceX + $this->nodeWidth)) + $this->spaceX,
                $measured->height + ($this->spaceY * 2)
            );

            return $this->doLayout($measured, 0, 0);
        }

        $this->bound = new Bound(
            0,
            0,
            $measured->width + ($this->spaceX * 2),
            ($depth * ($this->spaceY + $this->nodeHeight)) + $this->spaceY
        );

        return $this->doLayout($measured, 0, 0);
    }

    /**
     * @inheritDoc
     */
    public function getBound(): Bound
    {
        return $this->bound;
    }

    /**
     * @inheritDoc
     */
    public function getOrientation(): string
    {
        return $this->orientation;
    }

    /**
     * Mesure récursivement la taille de chaque sous-arbre.
     */
    private function measure(TreeNode $node): MeasuredNode
    {
        $measured = new MeasuredNode();
        $measured->node = $node;

        $children = $node->getChildren();

        if (empty($children)) {
            $measured->width = $this->nodeWidth;
            $measured->height = $this->nodeHeight;
        } else {
            $totalWidth = 0;
            $totalHeight = 0;
            $childNodes = [];

            foreach ($children as $child) {
                $measuredChild = $this->measure($child);
                $childNodes[] = $measuredChild;
                $totalWidth += $measuredChild->width;
                $totalHeight += $measuredChild->height;
            }

            $totalWidth += $this->spaceX * (count($childNodes) - 1);
            $totalHeight += $this->spaceY * (count($childNodes) - 1);
            $measured->width = max($this->nodeWidth, $totalWidth);
            $measured->height = max($this->nodeHeight, $totalHeight);
            $measured->children = $childNodes;
        }

        return $measured;
    }

    /**
     * Positionne les nœuds selon les mesures préalables.
     */
    private function doLayout(MeasuredNode $measuredNode, float $offset, int $depth): PositionedTreeNode
    {
        if ($this->orientation == self::ORIENTATION_VERTICAL) {
            $x = ($depth * ($this->nodeWidth + $this->spaceX)) + ($this->spaceX / 2);
            $y = $offset + ($measuredNode->height / 2) - ($this->nodeHeight / 2) + $this->spaceY;
        } else {
            $x = $offset + ($measuredNode->width / 2 ) - ($this->nodeWidth / 2) + $this->spaceX;
            $y = ($depth * ($this->nodeHeight + $this->spaceY)) + $this->spaceY / 2;
        }

        $positioned = new PositionedTreeNode();
        $positioned->node = $measuredNode->node;
        $positioned->depth = $depth;
        $positioned->bound = new Bound(
            (int) $x,
            (int) $y,
            $this->nodeWidth,
            $this->nodeHeight
        );

        $childOffset = $offset;
        foreach ($measuredNode->children as $childMeasured) {
            $child = $this->doLayout($childMeasured, $childOffset, $depth + 1);

            if ($this->orientation === self::ORIENTATION_VERTICAL) {
                $childOffset += $childMeasured->height + $this->spaceY;

                $x1 = $positioned->bound->x + $positioned->bound->width;
                $y1 = $positioned->bound->y + ($positioned->bound->height / 2);

                $x2 = $child->bound->x;
                $y2 = $child->bound->y + ($child->bound->height / 2);
            } else {
                $childOffset += $childMeasured->width + $this->spaceX;

                $x1 = $positioned->bound->x + ($positioned->bound->width / 2);
                $y1 = $positioned->bound->y + $positioned->bound->height;

                $x2 = $child->bound->x + ($positioned->bound->width / 2);
                $y2 = $child->bound->y;
            }

            $positioned->children[] = $child;
            $positioned->connections[] = new Line($x1, $y1, $x2, $y2);
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
