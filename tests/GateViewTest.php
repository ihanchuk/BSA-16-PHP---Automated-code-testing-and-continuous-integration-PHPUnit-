<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GateViewTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        Auth::loginUsingId(3);
    }

    public function testGateDeniesSingleUserInBooks(){
        $this->visit("/books/1");
        $this->seeText("Requires Admin access");
    }

    public function testGateDeniesSingleUserInUsers(){
        $this->visit("/users/1");
        $this->seeText("Requires Admin access");
    }
    public function testGateDeniesSetOwnerForSingleUser(){
        $this->visit("/books/1");
        $this->dontSeeElement("select");
    }
}
