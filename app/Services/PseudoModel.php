<?php

namespace App\Services;


abstract class PseudoModel
{
    protected $modelData = [];
    protected $allowedAttributes = [];

    public function update(array $data):PseudoModel
    {
        foreach ($data as $key=>$value) {
            if(!in_array($key,$this->allowedAttributes))
                throw new \RuntimeException("Model " . static::class . " doesn't have such mass assignable attribute: {$key}");
            $this->modelData[$key] = $value;
        }
        return $this;
    }

    public function serialize():array
    {
        return $this->modelData;
    }

}