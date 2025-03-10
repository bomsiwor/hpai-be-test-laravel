<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = $this->resource;

        // Check if the resource is object or array
        if (is_object($resource)) {
            $url = property_exists($resource, "path") ? asset($this->path) : null;
        } elseif (is_array($resource)) {

            $url = isset($resource["path"]) ? asset($resource["path"]) : null;
        } else {
            $url = null;
        }

        return [
            "alt" => $this->alt ?? "",
            "url" => $url,
            "uid" => $this->uid ?? ""
        ];
    }
}
