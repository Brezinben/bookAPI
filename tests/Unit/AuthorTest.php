<?php

namespace Tests\Unit;

use App\Models\Author;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    public function testCreate()
    {
        $author = ['first_name' => 'John', 'last_name' => 'DOE', 'birth_date' => '2002-06-26', 'death_date' => '2003-06-26'];

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->editorToken])
            ->json('POST', route('authors.store'), $author);

        $response->assertStatus(201);
        $this->assertDatabaseHas('authors', $author);
    }


    public function testUpdate()
    {
        Author::factory(1)->create();
        $author = Author::all()->last();
        $data = ['first_name' => 'John', 'last_name' => 'DOE', 'birth_date' => '2002-06-26', 'death_date' => '2003-06-26'];

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->editorToken])
            ->json('PUT', route('authors.update', $author->id), $data);

        $response->assertStatus(200);
        $response->assertDontSeeText($data);
        $this->assertDatabaseHas('authors', $data);

    }

    public function testShow()
    {
        $author = Author::first();
        $response = $this->json("GET", route('authors.show', $author->id));
        $response->assertStatus(200);
    }

    public function testDelete()
    {
        Author::factory(1)->create();
        $author = Author::all()->last();
        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->adminToken])
            ->json("DELETE", route('authors.destroy', $author->id));
        $response->assertStatus(204);
    }

    public function testIndex()
    {

        $response = $this->json("GET", route('authors.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'count',
            'data' => [
                '*' => [
                    'link',
                    "first_name",
                    "last_name",
                    "birth_date",
                    "death_date",
                    "created_at",
                    "updated_at",
                ]
            ]
        ]);
    }
}
