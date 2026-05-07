<div class="space-y-6">
    <x-filament::section>
        <x-slot name="heading">WhatsApp Floating Button</x-slot>
        <x-slot name="description">Configure the floating WhatsApp chat button shown on all public pages.</x-slot>

        <form wire:submit.prevent="save" class="space-y-6">

            {{-- Enable toggle --}}
            <div class="flex items-center gap-x-3">
                <button type="button"
                    wire:click="$toggle('whatsapp_enabled')"
                    @class([
                        'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none',
                        'bg-primary-600' => $whatsapp_enabled,
                        'bg-gray-200 dark:bg-white/10' => !$whatsapp_enabled,
                    ])
                    role="switch">
                    <span @class([
                        'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                        'translate-x-5' => $whatsapp_enabled,
                        'translate-x-0' => !$whatsapp_enabled,
                    ])></span>
                </button>
                <span class="text-sm font-medium text-gray-950 dark:text-white">Enable WhatsApp Button</span>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-950 dark:text-white mb-1">
                        WhatsApp Phone Number <span class="text-danger-600">*</span>
                    </label>
                    <input type="text" wire:model="whatsapp_number" placeholder="2348012345678"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-white/20 dark:bg-white/5 dark:text-white" />
                    <p class="mt-1 text-xs text-gray-500">International format, no + or spaces — e.g. 2348012345678</p>
                    @error('whatsapp_number') <p class="mt-1 text-xs text-danger-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-950 dark:text-white mb-1">
                        Button Position <span class="text-danger-600">*</span>
                    </label>
                    <select wire:model="whatsapp_position"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-white/20 dark:bg-white/5 dark:text-white">
                        <option value="bottom-right">Bottom Right</option>
                        <option value="bottom-left">Bottom Left</option>
                    </select>
                    @error('whatsapp_position') <p class="mt-1 text-xs text-danger-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-950 dark:text-white mb-1">
                    Pre-filled Chat Message <span class="text-danger-600">*</span>
                </label>
                <textarea wire:model="whatsapp_message" rows="3"
                    placeholder="Hello! I'd like to inquire about your services."
                    class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-white/20 dark:bg-white/5 dark:text-white"></textarea>
                @error('whatsapp_message') <p class="mt-1 text-xs text-danger-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <x-filament::button type="submit" icon="heroicon-o-check-circle">
                    Save Settings
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</div>
