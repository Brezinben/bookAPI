<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $linksMovies = collect($this->whenLoaded('books'))->map(fn($book) => '/api/books/' . $book->id);

        return [
            'link'=>'/api/categories/'.$this->id,
            'id' => $this->id,
            'title'=>$this->title,
            'books' =>  $linksMovies
        ];
    }
}
