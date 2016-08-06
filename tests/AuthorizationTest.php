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
    public function test_main_page_accessible()
    {
        /* Test if site is accessible*/
        $this->call('GET', '/');
        $this->assertResponseOk();
    }

    public function test_registartion_and_login_pages()
    {
        /* Test if login/register pages are active */
        $this->call('GET', '/login');
        $this->assertResponseOk();

        $this->call('GET', '/register');
        $this->assertResponseOk();
    }

    public function test_unauthorized_access()
    {
        $this->call('GET', '/books');
        $this->assertRedirectedTo('/login');
    }

    public function test_authorized_access(){
        Auth::loginUsingId(1);
        $this->visit('/books')->see('Create');
    }
}
