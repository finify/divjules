<div class="space-y-6">
    <x-filament::section>
        <x-slot name="heading">Social Media Links</x-slot>
        <x-slot name="description">Set the URLs for each social media platform shown on the Contact page.</x-slot>

        <form wire:submit.prevent="save" class="space-y-6">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                <div>
                    <label class="block text-sm font-medium text-gray-950 dark:text-white mb-1">
                        Facebook URL
                    </label>
                    <input type="url" wire:model="social_facebook" placeholder="https://facebook.com/yourpage"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-white/20 dark:bg-white/5 dark:text-white" />
                    @error('social_facebook') <p class="mt-1 text-xs text-danger-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-950 dark:text-white mb-1">
                        Twitter / X URL
                    </label>
                    <input type="url" wire:model="social_twitter" placeholder="https://twitter.com/yourhandle"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-white/20 dark:bg-white/5 dark:text-white" />
                    @error('social_twitter') <p class="mt-1 text-xs text-danger-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-950 dark:text-white mb-1">
                        Instagram URL
                    </label>
                    <input type="url" wire:model="social_instagram" placeholder="https://instagram.com/yourprofile"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-white/20 dark:bg-white/5 dark:text-white" />
                    @error('social_instagram') <p class="mt-1 text-xs text-danger-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-950 dark:text-white mb-1">
                        LinkedIn URL
                    </label>
                    <input type="url" wire:model="social_linkedin" placeholder="https://linkedin.com/company/yourcompany"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-white/20 dark:bg-white/5 dark:text-white" />
                    @error('social_linkedin') <p class="mt-1 text-xs text-danger-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-950 dark:text-white mb-1">
                        YouTube URL
                    </label>
                    <input type="url" wire:model="social_youtube" placeholder="https://youtube.com/@yourchannel"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-white/20 dark:bg-white/5 dark:text-white" />
                    @error('social_youtube') <p class="mt-1 text-xs text-danger-600">{{ $message }}</p> @enderror
                </div>

            </div>

            <div>
                <x-filament::button type="submit" icon="heroicon-o-check-circle">
                    Save Links
                </x-filament::button>
            </div>

        </form>
    </x-filament::section>
</div>
