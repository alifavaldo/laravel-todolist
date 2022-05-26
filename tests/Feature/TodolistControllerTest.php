<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "alif",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "edo"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("edo");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "alif"
        ])->post('/todolist', [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "alif"
        ])->post('/todolist', [
            "todo" => "Belajar"
        ])->assertRedirect("/todolist");
    }

    public function testremoveTodo()
    {
        $this->withSession([
            "user" => "alif",
            "todolist" => [
                [

                    "id" => "1",
                    "todo" => "edo"
                ],
                [
                    "id" => "2",
                    "todo" => "alif"
                ]
            ],
        ])->post('/todolist/1/delete')
            ->assertRedirect("/todolist");
    }
}
