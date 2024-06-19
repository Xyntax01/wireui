<?php

namespace WireUi\View;

use Illuminate\Support\{Arr, Str};
use WireUi\Support\ComponentPack;

trait ManageProps
{
    protected array $packs = [];

    protected array $props = [];

    protected array $slots = [];

    protected function setupProps(array $data): void
    {
        foreach ($this->packs as $pack) {
            $this->managePacks($pack);
        }

        foreach ($this->props as $key => $prop) {
            $this->manageProps($key, $prop, $data);
        }
    }

    // private function getSlot(string $key, array $data): mixed
    // {
    //     return in_array($key, $this->slots, true) ? Arr::get($data, $key) : null;
    // }

    private function manageProps(string $key, mixed $value, array $data): void
    {
        $field = Str::camel($key);

        $this->{$field} = Arr::get($data, $key, $this->getData($field, $value));

        // $this->{$field} = with($this->getData($field, $value),
        //     fn ($value) => $this->getSlot($key, $data) ?? $value,
        // );

        $this->setVariables($field);
    }

    private function managePacks(string $value): void
    {
        $field = Str::camel($value);

        $config = Str::plural($value);

        /** @var ComponentPack $pack */
        $pack = resolve(config("wireui.{$this->config}.packs.{$config}"));

        $this->{$field} = $this->getData($field);

        $this->{"{$field}Classes"} = $pack->get($this->{$field});

        $this->setVariables([$field, "{$field}Classes"]);
    }
}
