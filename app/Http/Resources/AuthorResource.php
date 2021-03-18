<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $linksMovies = collect($this->whenLoaded('books'))->map(fn($book) => '/api/books/' . $book->id);

        return [
            'link' => '/api/authors/' . $this->id,
            "id" => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "birth_date" => $this->birth_date,
            "death_date" => $this->death_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'books' => $linksMovies
        ];
    }
}
