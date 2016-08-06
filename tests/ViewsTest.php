<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        Auth::loginUsingId(1);
    }

    public function testBooksMainView(){
        $this->call('GET', '/books');
        $this->assertResponseOk();
        $this->assertViewHas('books');
    }

    public function testBookSingleView(){
        $this->call('GET', '/books/1');
        $this->assertResponseOk();
        $this->assertViewHas('book');
    }
}
