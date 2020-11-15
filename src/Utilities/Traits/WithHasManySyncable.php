<?php


namespace Vodeamanager\Core\Utilities\Traits;


use Vodeamanager\Core\Utilities\Models\HasManySyncable;

trait WithHasManySyncable
{
    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $localKey = $localKey ?: $this->getKeyName();

        return new HasManySyncable(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey
        );
    }
}
