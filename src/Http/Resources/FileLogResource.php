<?php

namespace Vodeamanager\Core\Http\Resources;

class FileLogResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function resource($request)
    {
        return [
            'name' => $this->name,
            'encoded_name' => $this->encoded_name,
            'size' => $this->size,
            'extension' => $this->extension,
            'path' => $this->path,
            'disk' => $this->disk,
            'url' => $this->url,
        ];
    }

}
