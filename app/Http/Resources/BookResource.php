<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'link' => route('books.show', ['book' => $this]),
            "id" => $this->id,
            "title" => $this->title,
            "status" => $this->status,
            "publish_date" => $this->publish_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "category" => new CategoryResource($this->whenLoaded('category')),
            "author" => new AuthorResource($this->whenLoaded('author'))
        ];
    }
}
