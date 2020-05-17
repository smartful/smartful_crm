<?php

abstract class Base
{
    /**
     * Retourne un tableau d'attributs
     */
    protected function arrayAttributes() : array
    {
        $attributes = [];
        foreach ($this as $key => $value) {
            $attributes[] = $key;
        }

        return $attributes;
    }

    /**
     * Getter (accesseur)
     */
    public function get(string $attribute)
    {
        $attributes = $this->arrayAttributes();
        if (in_array($attribute, $attributes)) {
            return $this->$attribute;
        }
    }

    /**
     * Setter (mutateur)
     */
    public function set(string $attribute, $value) : void
    {
        $attributes = $this->arrayAttributes();
        if (in_array($attribute, $attributes)) {
            $this->$attribute = $value;
        }
    }

    /**
     * Alloue les valeurs rentrées en paramêtre aux attributs
     */
    public function hydrate(array $data) : void
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }
}