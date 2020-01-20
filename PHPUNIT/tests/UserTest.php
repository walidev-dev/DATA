<?php

use PHPUnit\Framework\TestCase;

use App\Models\User;

class UserTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    public function setUp(): void
    {
        $this->user = new User();
    }

    protected function tearDown(): void
    {
        $this->user = null;
    }


    public function testThatWeCanGetTheFirstName()
    {
        $this->user->setFirstName('Billy');

        $this->assertEquals('Billy', $this->user->getFirstName());
    }

    public function testTheFirstNameIsTrimmed()
    {
        $this->user->setFirstName('   Billy   ');

        $this->assertEquals('Billy', $this->user->getFirstName());
    }
    public function testEmailAddressCanBeSet()
    {
        $this->user->setEmail('billy@codecource.com');

        $this->assertEquals('billy@codecource.com', $this->user->getEmail());
    }

    public function testEmailVariablesContainCorrectValues()
    {
        $this->user->setFirstname('Billy');
        $this->user->setEmail('billy@codecource.com');
        $emailVariables = $this->user->getEmailVariables();

        $this->assertArrayHasKey('firstName', $emailVariables);
        $this->assertArrayHasKey('email', $emailVariables);

        $this->assertEquals($emailVariables['firstName'], 'Billy');
        $this->assertEquals($emailVariables['email'], 'billy@codecource.com');
    }
}
