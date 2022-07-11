<x-jet-action-section>
    <x-slot name="title">
        {{ __('Delete Account') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete your account.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <button wire:click="confirmUserDeletion" wire:loading.attr="disabled" class="flex ml-1 px-6 py-1.5 rounded-full text-white bg-red-500 hover:bg-red-600 hover:transition hover:duration-300">
                {{ __('Delete Account') }}
            <button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Delete Account') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-jet-input type="password" class="mt-1 block w-3/4"
                                placeholder="{{ __('Password') }}"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="deleteUser" />

                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled" class="flex ml-1 px-6 py-1.5 text-gray-400 border-2 solid border-gray-400 rounded-full hover:bg-white hover:text-gray-300 hover:border-gray-300 hover:transition hover:duration-300">
                    {{ __('Cancel') }}
                </button>

                <button wire:click="deleteUser" wire:loading.attr="disabled" class="flex ml-1 px-6 py-2 rounded-full text-white bg-red-500 hover:bg-red-600 hover:transition hover:duration-300">
                    {{ __('Delete Account') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
