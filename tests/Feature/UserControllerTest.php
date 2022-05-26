<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "alif"
        ])->get('/login')->assertRedirect("/");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "alif",
            "password" => "rahasia"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "alif");
    }

    public function testLoginforUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "alif"
        ])->post('/login', [
            "user" => "alif",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }

    public function testValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText("User or password is required");
    }

    public function testFailed()
    {
        $this->post("/login", [
            "user" => "wrong",
            "password" => "edo"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "alif"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }
}
