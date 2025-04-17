<?php

namespace Modernik\MlmTreeView;

/**
 * Interface TreeRenderer
 *
 * Définit le contrat d'un moteur de rendu d'arbre à partir d'un nœud racine.
 * Permet de transformer une structure de type TreeNode en un rendu
 * (ex. HTML, JSON, texte, etc.).
 */
interface TreeRenderer
{
    /**
     * Génère un rendu à partir du nœud racine spécifié.
     *
     * @param TreeNode $node Le nœud racine de l’arbre à rendre
     * @return mixed Le résultat du rendu (ex. chaîne HTML, objet DOM, tableau, etc.)
     */
    public function render(TreeNode $node): mixed;
}
