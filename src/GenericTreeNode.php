<?php

namespace Modernik\MlmTreeView;

/**
 * Classe générique représentant un nœud d'arbre simple.
 */
class GenericTreeNode implements TreeNode
{

    protected string|int $Id;
    protected string $name;
    protected ?TreeNode $parent;
    protected array $children = [];
    protected array $tags = [];
    protected ?string $link = null;

    public function __construct(string|int $id, string $name, array $children = [], ?TreeNode $parent = null, array $tags = [], ?string $link = null)
    {
        $this->Id = $id;
        $this->name = $name;
        $this->children = $children;
        $this->parent = $parent;
        $this->tags = $tags;
        $this->link = $link;

        foreach ($children as $child) {
            $child->setParent($this);
        }
    }

    public function getId(): string|int
    {
        return $this->Id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function addChild(TreeNode $child): void
    {
        $this->children[] = $child;
        $child->setParent($this);
    }

    public function getParent(): ?TreeNode
    {
        return $this->parent;
    }

    /**
     * @param TreeNode|null $parent
     */
    public function setParent(?TreeNode $parent): void
    {
        $this->parent = $parent;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function addTag (string $tagName, string $tagValue): self
    {
        $this->tags[$tagName] = $tagValue;
        return $this;
    }

    public function getLink(): string|null
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     */
    public function setLink(?string $link): void
    {
        $this->link = $link;
    }
}