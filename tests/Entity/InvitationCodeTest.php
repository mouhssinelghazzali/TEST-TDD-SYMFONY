<?php

namespace App\Tests\Entity;

use App\Entity\InvitationCode;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InvitationCodeTest extends WebTestCase 
{ 
    use FixturesTrait; 
    
    public function getEntity(): InvitationCode
    {
        return (new InvitationCode())
        ->setCode('12325')
        ->setDescription('decription du test')
        ->setExpireAt(new \DateTime());
    }

    public function assertHasErrors(InvitationCode $code , int $number = 0 )
    {
        self::bootKernel();
        $errors =  self::$container->get('validator')->validate($code);
        $messages  = [];
        /**@var ConstraintViolation $error */
        foreach ($errors as  $error) {
            $messages[] = $error->getPropertyPath(). '=>' . $error->getMessage();
        }
        $this->assertCount($number,$errors,implode(', ', $messages));
    }

    public function testValideEntity()
    {
        $this->assertHasErrors($this->getEntity(),0);
               
    }

    public function testInvalidCodeEntity() 
    {
        $this->assertHasErrors($this->getEntity()->setCode('11a11'),1);
        $this->assertHasErrors($this->getEntity()->setCode('1111'),1);
     
    }
    public function testInvalidBlankCodeEntity() 
    {
        $this->assertHasErrors($this->getEntity()->setCode(''),1);
    }

    public function testInvalidBlankDescriptionEntity() 
    {
        $this->assertHasErrors($this->getEntity()->setDescription(''),1);
    }

    public function testInvalidUserCode()
    {
        $this->loadFixtureFiles([dirname(__DIR__) . '/Fixtures/invitation_code.yaml']);

        $this->assertHasErrors($this->getEntity()->setCode('54321'),1);

    }
}