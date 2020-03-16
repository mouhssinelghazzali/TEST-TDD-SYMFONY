<?php

namespace App\Tests\Validator;

use App\Validator\EmailDomain;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\MissingOptionsException;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class EmailDomainTest extends TestCase 
{

    public function testRequiredparameters () { 

        $this->expectException(MissingOptionsException::class);
        new EmailDomain();
    }

    public function testBadShapedBlockedParameter() 
    {
        $this->expectException(ConstraintDefinitionException::class);
        new EmailDomain([
            'blocked' => 'azeee'
        ]);
    }

    public function testOptionIsSetAsProperty()
    {
        $array = ['a','b'];
        $domain = new EmailDomain(['blocked' => $array]);
        $this->assertEquals($array,$domain->blocked);

    }


}