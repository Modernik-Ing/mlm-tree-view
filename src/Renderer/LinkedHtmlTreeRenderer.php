<?php

namespace Modernik\MlmTreeView\Renderer;

use Modernik\MlmTreeView\LinkGenerator;
use Modernik\MlmTreeView\Placement\PositionedTreeNode;
use Modernik\MlmTreeView\Placement\TreeLayoutEngine;
use Modernik\MlmTreeView\TreeNode;

/**
 * Class LinkedHtmlTreeRenderer
 *
 * Cette classe est une variante de HtmlTreeRenderer permettant d’associer des liens cliquables à chaque nœud de l’arbre.
 *
 * Elle utilise un moteur de layout (TreeLayoutEngine) pour positionner les nœuds dans l’espace 2D, et s’appuie sur un LinkGenerator pour
 * construire dynamiquement les URLs liées à chaque nœud.
 *
 * Cette approche respecte le principe de responsabilité unique :
 * → Le layout est géré par TreeLayoutEngine.
 * → Le rendu HTML est pris en charge ici.
 * → La génération des liens est déléguée à un composant externe.
 */
class LinkedHtmlTreeRenderer extends AbstractHtmlRenderer
{

    /**
     * Générateur de lien associé à chaque nœud.
     */
    private LinkGenerator $linkGenerator;

    /**
     * LinkedHtmlTreeRenderer constructor.
     *
     * @param TreeLayoutEngine $layoutEngine  Le moteur de layout à utiliser.
     * @param LinkGenerator $linkGenerator Le générateur de lien à utiliser pour chaque nœud.
     * @param bool $withStyle Active ou non l’inclusion directe du CSS dans le rendu HTML.
     */
    public function __construct( TreeLayoutEngine $layoutEngine, LinkGenerator $linkGenerator, bool $withStyle = true )
    {
        parent::__construct($layoutEngine, $withStyle);
        $this->linkGenerator = $linkGenerator;
    }

    protected function renderNode(PositionedTreeNode $node): string
    {
        $link = $this->linkGenerator->generate($node->node);
        $html = '<div class="mlm-tree-node" style="position: absolute; ' . $node->boundToCss() . ';">';
        $html .= '<a class="mlm-tree-node-content" href="'.$link.'">';
        $html .= htmlspecialchars($node->node->getName());
        $html .= '</a>';
        $html .= '</div>';
        return $html;
    }
}