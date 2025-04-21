<?php

namespace Modernik\MlmTreeView\Renderer;

use Modernik\MlmTreeView\Placement\PositionedTreeNode;
use Modernik\MlmTreeView\Placement\TreeLayoutEngine;

/**
 * Cette classe est responsable du rendu HTML d’un arbre MLM.
 * Elle s’appuie sur un moteur de positionnement (TreeLayoutEngine) pour disposer les nœuds dans un espace 2D, puis génère un
 * rendu HTML statique avec un positionnement absolu.
 */
class BasicHtmlTreeRenderer extends AbstractHtmlRenderer
{

    /**
     * HtmlTreeRenderer constructor.
     *
     * @param TreeLayoutEngine $layoutEngine Le moteur de layout à utiliser pour positionner l’arbre.
     * @param bool $withStyle doit-on inclure le style interne ?
     */
    public function __construct(TreeLayoutEngine $layoutEngine, bool $withStyle = true)
    {
        parent::__construct($layoutEngine, $withStyle);
    }

    protected function renderNode(PositionedTreeNode $node): string
    {
        $html = '<div class="mlm-tree-node" style="position: absolute; ' . $node->boundToCss() . ';">';
        $html .= '<div class="mlm-tree-node-content">';
        $html .= htmlspecialchars($node->node->getName());
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}
