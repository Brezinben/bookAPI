<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'link' => route('categories.show', ['category' => $this]),
            'id' => $this->id,
            'title' => $this->title
        ];

        if ($booksLinks->isEmpty()) {
            return $data;
        }

        $data['books'] = $booksLinks;
        return $data;
    }
}
