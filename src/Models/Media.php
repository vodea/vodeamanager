<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Support\Facades\Storage;
use Vodeamanager\Core\Http\Resources\MediaResource;
use Vodeamanager\Core\Rules\ValidInConstant;
use Vodeamanager\Core\Utilities\Models\BaseModel;

class Media extends BaseModel
{
    protected $indexResource = MediaResource::class;
    protected $showResource = MediaResource::class;
    protected $selectResource = MediaResource::class;
    protected $relationResource = MediaResource::class;

    protected $fillable = [
        'name',
        'encoded_name',
        'size',
        'extension',
        'path',
        'disk',
    ];

    protected $validationRules = [
        'path' => 'required|string',
    ];

    public function mediaUses()
    {
        return $this->hasMany(config('vodeamanager.models.media_use'));
    }

    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function setValidationRules(array $request = [], $id = null)
    {
        $this->validationRules['disk'] = [
            'required',
            new ValidInConstant(array_keys(config('filesystems.disks', []))),
        ];

        $fileRules = ['required'];

        $mimes = @$request['mimes'] ?? [];
        if (!empty($mimes)) {
            $fileRules[] = 'mimes:' . (is_array($mimes) ? implode(',',$mimes) : $mimes);
        }

        if ($maxSize = @$request['max_size']) {
            $fileRules[] = 'max:' . $maxSize;
        }

        $this->validationRules['file'] = $fileRules;

        return $this;
    }

}
