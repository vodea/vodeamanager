<?php

namespace Vodeamanager\Core\Http\Resources;

class CreatorResource extends BaseResource
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
            'email' => $this->email,
            'telephone' => $this->telephone,
            'mobile_phone' => $this->mobile_phone,
        ];
    }

}
