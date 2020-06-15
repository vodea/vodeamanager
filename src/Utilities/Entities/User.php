<?php

namespace Vodeamanager\Core\Utilities\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use \OwenIt\Auditing\Auditable as AudibleTrait;
use Vodeamanager\Core\Rules\NotPresent;
use Vodeamanager\Core\Utilities\Traits\EntityFormRequest;
use Vodeamanager\Core\Utilities\Traits\ResourceTrait;
use Vodeamanager\Core\Utilities\Traits\Searchable;
use Vodeamanager\Core\Utilities\Traits\UserStamp;

abstract class User extends Authenticatable implements Auditable
{
    use Notifiable, SoftDeletes, UserStamp, HasApiTokens, Searchable, EntityFormRequest, AudibleTrait, ResourceTrait;

    /**
     * Columns and their priority in search results.
     * Columns with higher values are more important.
     * Columns with equal values have equal importance.
     ** @var array
     */
    protected $searchable = [
        'columns' => [],
        'joins' => [],
    ];

    public function scopeCriteria($query, Request $request) {
        $order = null;
        $sorted = null;

        if ($request->has('order_by')) {
            $sorted = $request->get('sorted_by') == 'desc' ? 'desc' : 'asc';
            $order = $request->get('order_by');
        } else if (config('vodeamanager.entity.sorting_default.active', false)) {
            $order = config('vodeamanager.entity.sorting_default.column', 'id');
            $sorted = config('vodeamanager.entity.sorting_default.order', 'desc') == 'desc' ? 'desc' : 'asc';
        }

        $query->when($order && $sorted && Schema::hasColumn($this->getTable(),$order), function ($query) use ($order, $sorted) {
            $query->orderBy($order, $sorted);
        });
    }

    public function scopeFilter($query, Request $request) {}

    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return new HasManySyncable(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey
        );
    }

    public function getDefaultRules() {
        $rules = [];

        foreach ($this->getFillable() as $field) {
            $rules[$field] = [ new NotPresent() ];
        }

        return $rules;
    }

    public function getLabel() {
        return $this->name;
    }

    // todo: can update by relation
    public function getCanUpdateAttribute() {
        return true;
    }

    // todo: create validation can delete by relation
    public function getCanDeleteAttribute() {
        return true;
    }

}
