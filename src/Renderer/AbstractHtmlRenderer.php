<?php

namespace Modernik\MlmTreeView\Renderer;

use Modernik\MlmTreeView\Placement\PositionedTreeNode;
use Modernik\MlmTreeView\Placement\TreeLayoutEngine;
use Modernik\MlmTreeView\TreeNode;
use Modernik\MlmTreeView\TreeRenderer;

/**
 * Classe de base abstraite pour les renderers HTML d’arbres MLM.
 *
 * Cette classe fournit les fondations communes à toutes les implémentations de rendu HTML,
 * notamment :
 *  → la génération du rendu principal avec les positions calculées via un TreeLayoutEngine,
 *  → l'inclusion optionnelle d'une feuille de style CSS,
 *  → le dessin automatique des lignes de connexion en SVG,
 *  → et une méthode abstraite `renderNode()` à implémenter dans les classes concrètes pour personnaliser le rendu HTML des nœuds.
 *
 * Cette classe est destinée à être étendue par des renderers comme :
 * - {@see BasicHtmlTreeRenderer}
 * - {@see LinkedHtmlTreeRenderer}
 */
abstract class AbstractHtmlRenderer implements TreeRenderer
{

    /**
     * Moteur de layout chargé de calculer la position de chaque nœud de l'arbre.
     */
    protected TreeLayoutEngine $layoutEngine;

    /**
     * Indique si le rendu doit inclure les styles CSS en ligne.
     */
    protected bool $withStyle;

    /**
     * Constructeur.
     *
     * @param TreeLayoutEngine $layoutEngine Le moteur de layout utilisé pour positionner les nœuds.
     * @param bool $withStyle Détermine si le style CSS doit être injecté en ligne.
     */
    public function __construct( TreeLayoutEngine $layoutEngine, bool $withStyle )
    {
        $this->layoutEngine = $layoutEngine;
        $this->withStyle = $withStyle;
    }

    /**
     * Charge et minifie le contenu de la feuille de style CSS utilisée pour le rendu de l’arbre.
     *
     * Cette méthode lit le fichier `mlm-tree.css` situé dans le dossier `ressources`,
     * puis applique une minification basique pour alléger le code (ssi $minimise == true) :
     * → Suppression des retours à la ligne, tabulations et espaces multiples
     * → Suppression des espaces autour des caractères de structure CSS (`{}`, `:`, `;`, `,`)
     *
     * @return string Le contenu CSS minifié, prêt à être injecté dans le HTML inline ou dans un <style>.
     */
    protected function getStyleSheetContent (bool $minimise = true): string
    {
        $css = file_get_contents(
            dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . "ressources" . DIRECTORY_SEPARATOR . "mlm-tree.css"
        );

        if (! $minimise) {
            return $css;
        }

        // Minification du CSS
        $css = preg_replace('/\s+/', ' ', $css);                      // Réduit les espaces consécutifs à un seul
        $css = preg_replace('/\s*([{}:;,])\s*/', '$1', $css);         // Supprime les espaces autour des délimiteurs
        return trim($css);                                                                // Supprime les espaces en début/fin
    }

    /**
     * Génère le HTML complet de l’arbre à partir du nœud racine.
     *
     * Cette méthode :
     * → Calcule les positions des nœuds via le `TreeLayoutEngine`
     * → Génère le HTML pour chaque nœud (via `renderNode()`)
     * → Génère le SVG des lignes de liaison
     * → Regroupe le tout dans un conteneur HTML
     *
     * @param TreeNode $node Le nœud racine de l’arbre.
     * @return string Le rendu HTML complet.
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

        //foreach ($connections as [$x1, $y1, $x2, $y2]) {
        //    $svg .= "<line x1=\"$x1\" y1=\"$y1\" x2=\"$x2\" y2=\"$y2\" stroke=\"#555\" stroke-width=\"2\" />";
        //}

        $index = 0;
        foreach ($connections as [$x1, $y1, $x2, $y2, $depth]) {
            $curveOffset = $this->calculateCurveOffset($depth);

            $cx1 = $x1;
            $cy1 = $y1 + $curveOffset;

            $cx2 = $x2;
            $cy2 = $y2 - $curveOffset;

            $delay = 0.05 * $index;
            $svg .= "<path d=\"M$x1,$y1 C$cx1,$cy1 $cx2,$cy2 $x2,$y2\" stroke=\"#555\" stroke-width=\"2\" fill=\"none\" style=\"animation-delay: {$delay}s\" />";
            $index++;
        }

        $svg .= '</svg>';

        $html = '';
        if ($this->withStyle) {
            $html .= '<style>' . $this->getStyleSheetContent() . '</style>';
        }

        $size = "width: {$bound->width}px;height: {$bound->height}px;";

        $html .= '<div class="mlm-tree-view-container" style="position: relative;'.$size.'">';
        $html .= "$svg $nodesHtml";
        $html .= '</div>';

        return $html;
    }

    private function calculateCurveOffset(int $depth): float
    {
        $base = 60;
        $decay = 0.35;
        $min = 20;
        $offset = $base * exp(-$decay * $depth);
        return max($offset, $min);
    }

    /**
     * Rend récursivement chaque nœud positionné, et prépare les coordonnées des connexions.
     *
     * @param PositionedTreeNode $node        Le nœud positionné courant.
     * @param string             $html        Le HTML cumulé de tous les nœuds.
     * @param array              $connections Liste des connexions à tracer au format [x1, y1, x2, y2].
     */
    private function renderNodeWithConnections(PositionedTreeNode $node, string &$html, array &$connections, int $depth = 0): void
    {
        $x = $node->bound->x;
        $y = $node->bound->y;

        $width = $node->bound->width;
        $height = $node->bound->height;

        $html .= $this->renderNode($node);

        foreach ($node->children as $child) {
            // Calculer les points de connexion (centre bas du parent → centre haut de l’enfant)
            $x1 = $x + $width / 2;
            $y1 = $y + $height;

            $x2 = $child->bound->x + $width / 2;
            $y2 = $child->bound->y;

            $connections[] = [$x1, $y1, $x2, $y2, $depth];

            $this->renderNodeWithConnections($child, $html, $connections, $depth + 1);
        }
    }

    /**
     * Méthode que les sous-classes doivent implémenter pour rendre individuellement un nœud.
     *
     * Cette méthode est appelée pour chaque nœud de l’arbre et retourne
     * le HTML associé à ce nœud (avec ou sans ses enfants, selon l’implémentation).
     *
     * @param PositionedTreeNode $node Le nœud à rendre.
     * @return string Le HTML généré pour le nœud.
     */
    abstract protected function renderNode(PositionedTreeNode $node): string;
}
