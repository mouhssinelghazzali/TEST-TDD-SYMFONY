<?php

namespace App\Repository;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase {

    public function testCount() {

        self::bootKernel();
        $user = self::$container->get(UserRepository::class)->count([]);
        $this->assertEquals(10,$user);
    }


}