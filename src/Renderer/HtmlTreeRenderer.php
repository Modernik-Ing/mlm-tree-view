<?php

namespace Modernik\MlmTreeView\Renderer;

use Modernik\MlmTreeView\TreeRenderer;
use Modernik\MlmTreeView\TreeNode;
use Modernik\MlmTreeView\Placement\TreeLayoutEngine;
use Modernik\MlmTreeView\Placement\PositionedTreeNode;

/**
 * Class HtmlTreeRenderer
 *
 * Cette classe est responsable du rendu HTML d’un arbre MLM.
 * Elle s’appuie sur un moteur de positionnement (TreeLayoutEngine)
 * pour disposer les nœuds dans un espace 2D, puis génère un
 * rendu HTML statique avec un positionnement absolu.
 */
class HtmlTreeRenderer implements TreeRenderer
{
    /**
     * Le moteur de layout utilisé pour calculer la position des nœuds.
     *
     * @var TreeLayoutEngine
     */
    private TreeLayoutEngine $layoutEngine;

    private bool $withStyles;

    /**
     * HtmlTreeRenderer constructor.
     *
     * @param TreeLayoutEngine $layoutEngine Le moteur de layout à utiliser pour positionner l’arbre.
     */
    public function __construct(TreeLayoutEngine $layoutEngine, bool $withStyle = true)
    {
        $this->layoutEngine = $layoutEngine;
        $this->withStyles = $withStyle;
    }

    /**
     * Génère le rendu HTML complet de l’arbre en partant du nœud racine donné.
     *
     * @param TreeNode $node Le nœud racine de l’arbre à rendre.
     * @return string Le HTML généré, prêt à être inséré dans une page.
     */
    public function render(TreeNode $node): string
    {
        $positioned = $this->layoutEngine->layout($node);
        $bound = $this->layoutEngine->getBound();
        $nodesHtml = '';
        $connections = [];

        $this->renderNodeWithConnections($positioned, $nodesHtml, $connections);

        // Générer le SVG des lignes
        $svg = '<svg class="mlm-tree-svg" xmlns="http://www.w3.org/2000/svg" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; pointer-events: none;">';

        foreach ($connections as [$x1, $y1, $x2, $y2]) {
            $svg .= "<line x1=\"$x1\" y1=\"$y1\" x2=\"$x2\" y2=\"$y2\" stroke=\"#555\" stroke-width=\"2\" />";
        }

        $svg .= '</svg>';

        $html = '';
        if ($this->withStyles) {
            $css = file_get_contents(dirname(__DIR__, 2) .DIRECTORY_SEPARATOR. "ressources".DIRECTORY_SEPARATOR."mlm-tree.css");
            // Supprimer les retours à la ligne, tabulations et espaces multiples
            $css = preg_replace('/\s+/', ' ', $css); // remplace tous les espaces blancs consécutifs par un seul espace
            $css = preg_replace('/\s*([{}:;,])\s*/', '$1', $css); // supprime les espaces autour des caractères CSS
            $css = trim($css); // supprime les espaces de début et fin
            $html .= '<style>' . $css . '</style>';
        }

        $size = "width: {$bound->width}px;height: {$bound->height}px;";

        $html .= '<div class="mlm-tree-view-container" style="position: relative;'.$size.'">';
        $html .= "$svg $nodesHtml";
        $html .= '</div>';

        return $html;
    }

    /**
     * Rend un nœud positionné (et ses enfants) sous forme de blocs HTML.
     *
     * @param PositionedTreeNode $node Le nœud positionné à rendre.
     * @param string $html
     * @param array $connections
     * @return void
     */
    private function renderNodeWithConnections(PositionedTreeNode $node, string &$html, array &$connections): void
    {
        $x = $node->bound->x;
        $y = $node->bound->y;

        $width = $node->bound->width;
        $height = $node->bound->height;

        $html .= '<div class="mlm-tree-node" style="position: absolute; ' . $node->boundToCss() . ';">';
        $html .= '<div class="mlm-tree-node-content">';
        $html .= htmlspecialchars($node->node->getName());
        $html .= '</div>';
        $html .= '</div>';

        foreach ($node->children as $child) {
            // Calculer les points de connexion (centre bas du parent → centre haut de l’enfant)
            $x1 = $x + $width / 2;
            $y1 = $y + $height;

            $x2 = $child->bound->x + $width / 2;
            $y2 = $child->bound->y;

            $connections[] = [$x1, $y1, $x2, $y2];

            $this->renderNodeWithConnections($child, $html, $connections);
        }
    }

}
