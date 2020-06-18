<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Http\Resources\LoginActivityResource;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class LoginActivity extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->indexResource = $this->showResource = $this->selectResource = LoginActivityResource::class;
    }

    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address',
    ];

    public function user() {
        return $this->belongsTo(config('vodeamanager.models.user'));
    }

}
