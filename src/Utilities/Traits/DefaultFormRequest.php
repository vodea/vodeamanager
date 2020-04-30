<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Illuminate\Support\Arr;

trait DefaultFormRequest
{
    public function rules() {
        return $this->getRules();
    }

    public function messages() {
        return $this->getMessages();
    }

    public function properties() {
        return $this->getProperties();
    }

    public function getRules() {
        $className = Arr::last(explode('\\',get_class($this)));
        $nameSpace = "App\\Entities\\" . preg_replace('/(CreateRequest|UpdateRequest)/','',$className);
        $model = app($nameSpace);

        $model->setRules($this->all(), @$this->id);

        return $model->getRules();
    }

    public function getMessages() {
        $className = Arr::last(explode('\\',get_class($this)));
        $nameSpace = "App\\Entities\\" . preg_replace('/(CreateRequest|UpdateRequest)/','',$className);
        $model = app($nameSpace);

        $model->setMessages($this->all(), @$this->id);

        return $model->getMessages();
    }

    public function getProperties() {
        $className = Arr::last(explode('\\',get_class($this)));
        $nameSpace = "App\\Entities\\" . preg_replace('/(CreateRequest|UpdateRequest)/','',$className);
        $model = app($nameSpace);

        $model->setProperties($this->all(), @$this->id);

        return $model->getProperties();
    }
}