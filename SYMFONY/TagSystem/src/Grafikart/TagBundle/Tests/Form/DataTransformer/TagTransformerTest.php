<?php

namespace Grafikart\TagBundle\Tests\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Grafikart\TagBundle\Entity\Tag;
use Grafikart\TagBundle\Form\DataTransformer\TagTransformer;

use Grafikart\TagBundle\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TagTransformerTest extends TestCase
{

    public function testCreateTagsArrayFromString()
    {
        $transformer = $this->getMockedTransformer();
        $tags = $transformer->reverseTransform('Demo, Chat');
        $this->assertCount(2, $tags);
        $this->assertSame('Chat', $tags[1]->getName());
        $this->assertInstanceOf(Tag::class, $tags[0]);
    }

    public function testTransformArrayToString()
    {
        $transformer = $this->getMockedTransformer();
        $tags_string = $transformer->transform(['Demo,Chat']);
        $this->assertSame('Demo,Chat', $tags_string);
    }

    public function testUseAlreadyDefinedTag()
    {
        $tagChat = new Tag();
        $tagChat->setName('Chat');
        $transformer = $this->getMockedTransformer($tagChat);
        $tags = $transformer->reverseTransform('Demo,Chat');
        $this->assertCount(2, $tags);
    }

    public function testRemoveEmptyTag()
    {
        $transformer = $this->getMockedTransformer();
        $tags = $transformer->reverseTransform('Demo,,Chat,,');
        $this->assertCount(2, $tags);
        $this->assertSame('Chat', $tags[1]->getName());
    }

    public function testRemoveDuplicateTags()
    {
        $transformer = $this->getMockedTransformer();
        $tags = $transformer->reverseTransform('Demo,Demo');
        $this->assertCount(1, $tags);
    }

    public function getMockedTransformer(?Tag $tag = null): TagTransformer
    {
        $tagRepository = $this->getMockBuilder(TagRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['getTagByName'])
            ->getMock();

        /*$em = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();*/

        $em = $this->createMock(ObjectManager::class);

        $em->expects($this->any())
            ->method('getRepository')
            ->willReturn($tagRepository);

        $tagRepository->expects($this->any())
            ->method('getTagByName')
            ->willReturn($tag);

        return new TagTransformer($em);
    }
}