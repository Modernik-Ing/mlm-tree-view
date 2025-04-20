<?php

namespace Modernik\MlmTreeView;

/**
 * Interface LinkGenerator
 *
 * Permet de générer dynamiquement une URL (ou tout lien logique) pour un nœud d’arbre donné. Cette abstraction est utile lorsqu’on
 * souhaite séparer les données du rendu HTML (ex. liens cliquables).
 *
 * Exemple d’utilisations :
 * → Générer des URLs vers des pages de profil, des détails de produit, etc.
 * → Fournir un lien AJAX pour charger dynamiquement les enfants.
 * → Adapter les URLs selon le contexte (ex. utilisateur connecté, route...).
 */
interface LinkGenerator
{
    /**
     * Génère un lien (URL) vers une ressource associée à un nœud donné.
     *
     * @param TreeNode $node Le nœud pour lequel générer le lien.
     * @return string|null Le lien associé au nœud (peut être une URL absolue ou relative). Le lien ou null si aucun lien n’est applicable.
     */
    public function generate(TreeNode $node): ?string;
}