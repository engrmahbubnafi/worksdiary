<?php

namespace App\Abilities;


class UnitName
{

    public function __construct(public array $attributes)
    {
    }

    private function generate(): string
    {
        $string = "";

        if (isset($this->attributes['code'])) {
            $string .= $this->attributes['code'];
        }

        if (isset($this->attributes['name'])) {
            $string .= '|' . $this->attributes['name'];
        }

        if (isset($this->attributes['mobile'])) {
            $string .= '|' . $this->attributes['mobile'];
        }

        if (isset($this->attributes['as_dealer']) && $this->attributes['as_dealer']) {
            $string .= '(Dealer Unit)';
        }

        return $string;
    }

    public function __toString(): string
    {
        return $this->generate();
    }

    public function __invoke(): string
    {
        return $this->generate();
    }
}
