@props(['title' => __('Confirm Password'), 'content' => __('For your security, please confirm your password to continue.'), 'button' => __('Confirm')])

@php
$confirmableId = md5($attributes->wire('then'));
@endphp

<span {{ $attributes->wire('then') }} x-data x-ref="span" x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')" x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);">
    {{ $slot }}
</span>

@once
<x-jet-dialog-modal wire:model="confirmingPassword">
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        {{ $content }}

        <div class="mt-4" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
            <x-jet-input type="password" class="mt-1 block w-3/4" placeholder="{{ __('Password') }}" x-ref="confirmable_password" wire:model.defer="confirmablePassword" wire:keydown.enter="confirmPassword" />

            <x-jet-input-error for="confirmable_password" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <button wire:click="stopConfirmingPassword" wire:loading.attr="disabled" class="flex ml-1 px-6 py-1.5 text-gray-400 border-2 solid border-gray-400 rounded-full hover:bg-white hover:text-gray-300 hover:border-gray-300 hover:transition hover:duration-300">
            {{ __('Cancel') }}
        </button>

        <button dusk="confirm-password-button" wire:click="confirmPassword" wire:loading.attr="disabled" class="flex ml-1 px-6 py-2 rounded-full text-white bg-teal-600 hover:bg-teal-700 hover:transition hover:duration-300">
            {{ $button }}
        </button>
    </x-slot>
</x-jet-dialog-modal>
@endonce