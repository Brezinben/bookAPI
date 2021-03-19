<?php

namespace Tests\Unit;

use App\Models\Author;
use Tests\TestCase;

class ActionWithTokenTest extends TestCase
{

    public function testCreateWithoutToken()
    {
        $author = ['first_name' => 'John', 'last_name' => 'DOE', 'birth_date' => '2002-06-26', 'death_date' => '2003-06-26'];
        $response = $this->json('POST', route('authors.store'), $author);
        $response->assertUnauthorized();
    }

    public function testUpdateWithoutToken()
    {
        $author = Author::first();
        $data = ['first_name' => 'John', 'last_name' => 'DOE', 'birth_date' => '2002-06-26', 'death_date' => '2003-06-26'];

        $response = $this->json('PUT', route('authors.update', $author->id), $data);
        $response->assertUnauthorized();
    }

    public function testCreateBadToken()
    {
        $author = ['first_name' => 'John', 'last_name' => 'DOE', 'birth_date' => '2002-06-26', 'death_date' => '2003-06-26'];
        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . "pAEv5zPtXT5sMll8SuW9KkY5dQRg8OnaLIsFGaaa"])
            ->json('POST', route('authors.store'), $author);
        $response->assertUnauthorized();
    }

    public function testUpdateBadToken()
    {
        $author = Author::first();
        $data = ['first_name' => 'John', 'last_name' => 'DOE', 'birth_date' => '2002-06-26', 'death_date' => '2003-06-26'];

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . "pAEv5zPtXT5sMll8SuW9KkY5dQRg8OnaLIsFGaaa"])
            ->json('PUT', route('authors.update', $author->id), $data);
        $response->assertUnauthorized();
    }

    public function testDeleteWithEditorToken()
    {
        $author = Author::all()->last();
        $response =  $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->editorToken])
            ->json("DELETE",route('authors.destroy',  $author->id));
        $response->assertUnauthorized();
    }
}
