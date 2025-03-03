<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class CvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resumeInfo = [
            'firstName' => $this->info->first_name,
            'lastName' => $this->info->last_name,
            'jobTitle' => $this->info->job_title,
            'address' => $this->info->address,
            'email' => $this->info->email,
            'phone' => $this->info->phone,
            'summery' => $this->info->summery,
            'Experience' => $this->info->experiences,
            'education' => $this->info->educations,
            'skills' => $this->info->skills,
            'languages' => $this->info->languages,
            'interests' => $this->info->interests,
        ];

        return [
            'documentId' => $this->resume_id,
            'title' => $this->title,
            'themeColor' => $this->theme_color,
            'sections' => $this->sections,
            ...$resumeInfo,
        ];
    }
}