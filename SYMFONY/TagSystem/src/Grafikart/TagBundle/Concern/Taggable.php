<?php

namespace Grafikart\TagBundle\Concern;

use Grafikart\TagBundle\Entity\Tag;

trait Taggable
{

    /**
     * @var array
     * @ORM\ManyToMany(targetEntity="Grafikart\TagBundle\Entity\Tag", cascade={"persist"})
     */
    private $tags;

    /**
     * Add tag
     *
     * @param \Grafikart\TagBundle\Entity\Tag $tag
     *
     * @return Tag
     */
    public function addTag(\Grafikart\TagBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Grafikart\TagBundle\Entity\Tag $tag
     */
    public function removeTag(\Grafikart\TagBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}