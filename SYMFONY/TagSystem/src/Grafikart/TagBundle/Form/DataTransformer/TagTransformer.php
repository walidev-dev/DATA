<?php

namespace Grafikart\TagBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Grafikart\TagBundle\Entity\Tag;
use Symfony\Component\Form\DataTransformerInterface;

class TagTransformer implements DataTransformerInterface
{

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {

        $this->manager = $manager;
    }

    public function transform($value): string
    {
        return implode(",", $value);
    }

    /**
     * @param string $string
     * @return Tag[]
     */
    public function reverseTransform($string): array
    {
        $names = array_unique(array_filter(array_map('trim', explode(",", $string)), 'strlen'));

        $tags = [];
        foreach ($names as $name) {
            $tag = $this->manager->getRepository(Tag::class)->getTagByName($name);
            if (null === $tag) {
                $tag = new Tag();
                $tag->setName($name);
            }
            $tags[] = $tag;
        }
        return $tags;
    }
}
