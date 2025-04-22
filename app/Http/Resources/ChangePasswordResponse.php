<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChangePasswordResponse extends JsonResource
{
    public function toArray($request)
    {
        return [
            'status'  => true,
            'message' => 'Password updated successfully',
        ];
    }
}
