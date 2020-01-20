<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\InvitationCode;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InvitationCodeTest extends KernelTestCase
{

    public function assertHasErrors(InvitationCode $code, int $number = 0)
    {
        $kernel = self::bootKernel();
        $validator = $kernel->getContainer()->get('validator');
        $errors = $validator->validate($code);
        $this->assertCount($number, $errors);
    }

    public function getEntity(): InvitationCode
    {
        return (new InvitationCode())
            ->setCode('12345')
            ->setDescription('Description de test')
            ->setExpireAt(new \DateTime());
    }

    public function testValidEntity()
    {
        $code = $this->getEntity();
        $this->assertHasErrors($code, 0);
    }

    public function testInvalidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setCode('1a345'), 1);
        $this->assertHasErrors($this->getEntity()->setCode('1'), 1);
    }

    public function testInvalidBlankCodeOgEntity()
    {
        $this->assertHasErrors($this->getEntity()->setCode(''), 1);
    }

    public function testInvalidUsedCode()
    {
        $this->assertHasErrors($this->getEntity()->setCode('54321'), 1);
    }
}