<?php

namespace Modernik\MlmTreeView;

/**
 * Interface TreeNode
 *
 * Représente un nœud d'un arbre hiérarchique (ex. MLM).
 * Permet d'abstraire toute source de données (BDD, API, etc.)
 * sous forme d'arbre exploitable pour le rendu HTML ou autre traitement.
 */
interface TreeNode
{
    /**
     * Retourne l'identifiant unique du nœud.
     *
     * @return string|int L'identifiant du nœud (UUID, entier, etc.)
     */
    public function getId(): string|int;

    /**
     * Retourne le nom ou libellé affichable du nœud.
     *
     * @return string Le nom du nœud (par ex. le nom d'un membre)
     */
    public function getName(): string;

    /**
     * Renvoie l'URL permettant de charger la page contiens la description des enfants du lien.
     * Tres utile pour les arbres qui sont chargés en moitié par exemple.
     * @return string|null
     */
    public function getLink(): string | null;

    /**
     * Retourne les enfants directs du nœud actuel.
     *
     * @return TreeNode[] Un tableau de nœuds enfants
     */
    public function getChildren(): array;

    /**
     * Retourne le nœud parent de l'élément actuel.
     *
     * @return TreeNode|null Le parent ou null si racine
     */
    public function getParent(): ?TreeNode;

    /**
     * Retourne les métadonnées (ou tags) associées à ce nœud.
     *
     * @return array<string, string> Tableau associatif clé => valeur (ex. ['email' => '...', 'role' => '...'])
     */
    public function getTags(): array;
}
