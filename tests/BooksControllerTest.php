<?php

class BooksControllerTest extends TestCase
{
    protected $credentials= [
        'email' => 'mfc2005@ukr.net',
        'password' => '123456789',
        ];

    public function testMethodIndexWithAuthorizedUser(){
        Auth::loginUsingId(1);
        $this->visit("/books");
        $this->assertViewHas('books');
    }

    public function testMethodIndexWithUnAuthorizedUser(){
        $response = $this->call('GET', 'home');
        $this->assertTrue($response->isRedirection());
    }

    public function testMethodCreateWithUnAuthorizedUser(){
        $response = $this->call('GET', '/books/create');
        $this->assertTrue($response->isRedirection());
    }

    public function testMethodCreateWithAuthorizedRegularUser(){
        Auth::loginUsingId(3);
        $response = $this->call('GET', '/books/create');
        $this->assertTrue($response->isRedirection());
        $this->assertSessionHas('dialog','Users not allowed for this action. Only admin');
    }

    public function testMethodCreateWithAdminCredentials(){

        $this->assertTrue(Auth::attempt($this->credentials));
        $response = $this->call('GET', '/books/create');
        $this->assertFalse($response->isRedirection());
        $this->assertResponseOk();
        $this->SeeElement("form");
        $this->SeeElement("input[type=submit]");
    }

    public function  testMethodStoreWithAdminCredentialsAndValidData(){
        $this->assertTrue(Auth::attempt($this->credentials));

        $response = $this->call('POST', '/books', array(
            '_token' => csrf_token(),
            'author' => 'Valid Author',
            'year' => 2000,
            'title' => 'Valid title',
            'genre' =>'Comedy'
        ));

        $this->assertTrue($response->isRedirection("/books"));
        $this->assertSessionHas('dialog', 'New book is created');
    }

    public function  testMethodStoreWithAdminCredentialsAndBadData(){
        $this->assertTrue(Auth::attempt($this->credentials));

        $response = $this->call('POST', '/books', array(
            '_token' => csrf_token(),
            'author' => '',
            'year' => 'string',
            'title' => null,
            'genre' =>null
        ));

        $this->assertTrue($response->isRedirection("/books"));
        $this->assertSessionHas('errors');
    }

    public function testMethodShowWithAuthorizedUser(){
        $this->assertTrue(Auth::attempt($this->credentials));
        $response = $this->call('GET', '/books/1');
        $this->assertFalse($response->isRedirection());
        $this->assertViewHas("book");
    }

    public function testMethodShowWithUnAuthorizedUser(){
        $response = $this->call('GET', '/books/1');
        $this->assertTrue($response->isRedirection());
    }

    public function testMethodEditWithUnAuthorizedUser(){
        $response = $this->call('GET', '/books/1/edit');
        $this->assertTrue($response->isRedirection());
    }

    public function testMethodEditWithAuthorizedUser(){
        $this->assertTrue(Auth::attempt($this->credentials));
        $response = $this->call('GET', '/books/1/edit');
        $this->assertFalse($response->isRedirection());
        $this->see("Update book");
    }

}