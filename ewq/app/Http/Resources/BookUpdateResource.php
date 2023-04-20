<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookUpdateResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'title'=> $this->title,
            'image'=>url('/storage') . '/' . $this ->image
        ];
    }
}
