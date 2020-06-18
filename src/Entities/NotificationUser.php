<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Http\Resources\NotificationUserResource;
use Vodeamanager\Core\Scopes\MyScope;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class NotificationUser extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->indexResource = $this->showResource = $this->selectResource = NotificationUserResource::class;
    }

    protected $fillable = [
        'notification_id',
        'user_id',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new MyScope());
    }

    public function scopeNotRead($query)
    {
        $query->where('notification_users.is_read', 0);
    }

    public function notification()
    {
        return $this->belongsTo(config('vodeamanager.models.notification'));
    }

    public function user()
    {
        return $this->belongsTo(config('vodeamanager.models.user'));
    }

}
