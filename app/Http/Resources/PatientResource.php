<?php

namespace App\Http\Resources;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->patient_id,
            'name' => $this->name,
            'contact' => $this->contact,
            'file' => $this->file,
            'doctor'=>  new DoctorResource($this->doctor),
            // 'doctor'=>$this->doctor,
           
        ];
    }
}
