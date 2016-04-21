<?php

namespace Shokai\Model\Extension;

trait ModelTrait
{
    public function getModel(array $params = [], $className = null)
    {
        if ($className === null) {
            $className = 'Shokai\\Model\\' . Util::toCamelCase($this->modelName);
        }
        return new $className($params);
    }
}
