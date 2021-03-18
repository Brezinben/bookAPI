<?php

namespace Tests\Unit;

use Tests\TestCase;

class AuthorTest extends TestCase
{

    public function testCreate()
    {
        $author = ['first_name' => 't', 'last_name' => 'g', 'birth_date' => '2002-06-26', 'death_date' => '2003-06-26'];

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . "YCJ3e7r5GskJQv8pQFEwZsD9KbEEZcxtXeEIhzW4"])
            ->json('POST', route('authors.store'), $author);

        $response->assertStatus(201);
    }

}
