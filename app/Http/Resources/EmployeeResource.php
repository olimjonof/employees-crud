<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    return [
        'id' => $this->id,
        'firstName' => $this->first_name,
        'lastName' => $this->last_name,
        'email' => $this->email,
        'phone' => $this->phone,
        'position' => $this->position,
        'salary' => $this->salary,
        'hiredAt' => $this->hired_at,
        'status' => $this->status,
        'updatedAt' => $this->updated_at->toIso8601String(),
    ];
}
}
