<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testMainPage()
    {
        $this->call('GET', '/');
        $this->assertResponseOk();
    }

    public function testRegistrationAndLogin()
    {
        $this->call('GET', '/login');
        $this->assertResponseOk();

        $this->call('GET', '/register');
        $this->assertResponseOk();
    }

    public function testUnauthorizedAccess()
    {
        $this->call('GET', '/books');
        $this->assertRedirectedTo('/login');
    }
}
