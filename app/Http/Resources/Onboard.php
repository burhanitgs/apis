<?php
namespace App\Models;
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Onboard extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
		
		return [
				'id' => $this->id,
				'birth_sex' => $this->birth_sex,
				'employment_status' => $this->employment_status,
				'occupation' => $this->occupation,
				'education_level' => $this->education_level,
				'total_children' => $this->total_children,
				'pregnant' => $this->pregnant,
				'gestation' => $this->gestation,
				'expected_babies' => $this->expected_babies,
				'user_id' => $this->user_id,
				'created_at' => $this->created_at->format('d/m/Y'),
				'updated_at' => $this->updated_at->format('d/m/Y'),
			];
        //return parent::toArray($request);
    }
}
