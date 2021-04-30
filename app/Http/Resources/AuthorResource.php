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
        $booksLinks = collect($this->whenLoaded('books'))->map(fn($book) => route('books.show', compact('book')));
        $data = [
            'link' => route('authors.show', ['author' => $this]),
            "id" => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "birth_date" => $this->birth_date,
            "death_date" => $this->death_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'book_count' => count($this->books),
        ];
        if ($booksLinks->isEmpty()) {
            return $data;
        }
        $data['books'] = $booksLinks;
        return $data;
    }
}
