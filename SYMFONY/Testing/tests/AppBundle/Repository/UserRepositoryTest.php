<?php

namespace Tests\AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    public function setUp()
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCount()
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $this->assertEquals(5, $userRepository->_Count());
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}