<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewTest extends TestCase
{
    /*
     *  Testing if view sucessfully recives data
     */
    public function test_books_main_view(){
        Auth::loginUsingId(1);
        $this->call('GET', '/books');
        $this->assertResponseOk();
        $this->assertViewHas('books');
    }

    public function test_book_single_view(){
        Auth::loginUsingId(1);
        $this->call('GET', '/books/1');
        $this->assertResponseOk();
        $this->assertViewHas('book');
    }
}
