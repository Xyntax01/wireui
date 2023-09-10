<?php

use function Livewire\Volt\{state, rules};

state(['toggle' => false]);

rules(['toggle' => 'accepted'])->messages([
    'toggle.accepted' => 'accept it',
]);

$validateToggle = fn() => $this->validate();

?>

<div>
    <h1>Toggle test</h1>

    <span dusk="toggle">@json($toggle)</span>

    // test it_should_render_label_and_change_value
    <x-toggle label="Enable Notifications" wire:model.live="toggle" />

    <button wire:click="validateToggle" dusk="validate">validate</button>
</div>
