<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Http\Resources\SettingResource;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Setting extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->indexResource = $this->showResource = $this->selectResource = SettingResource::class;
    }

    protected $fillable = [
        'type',
        'attributes',
    ];

    protected $casts = [
        'attributes' => 'object',
    ];

}
