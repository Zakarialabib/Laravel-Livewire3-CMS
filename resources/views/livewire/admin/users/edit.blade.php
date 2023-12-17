<div>
    <x-modal wire:model="editModal">
        <x-slot name="title">
            {{ __('Edit User') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="update">
                <div class="flex flex-wrap mb-3 space-y-2">
                    <div class="w-full lg:w-1/2 px-2">
                        <x-label for="name" :value="__('Name')" required />
                        <x-input id="name" class="block mt-1 w-full" type="text" wire:model="name"
                            required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="w-full lg:w-1/2 px-2">
                        <x-label for="phone" :value="__('Phone')" required />
                        <x-input id="phone" class="block mt-1 w-full" required type="text"
                            wire:model="phone" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="w-full lg:w-1/2 px-2">
                        <label for="role">{{ __('Role') }} <span class="text-red-500">*</span></label>
                        <select wire:model="role"
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            name="role" id="role" required>
                            <option value="" selected disabled>{{ __('Select Role') }}</option>
                            @foreach (\Spatie\Permission\Models\Role::where('name', '!=', 'admin')->get() as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full lg:w-1/2 px-2">
                        <x-label for="password" :value="__('Password')" />
                        <x-input id="password" class="block mt-1 w-full" type="password"
                            wire:model="password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="w-full lg:w-1/2 px-2">
                        <x-label for="password_confirmation" :value="__('Confirm password')" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            wire:model="password_confirmation" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <x-accordion title="{{ __('More Details') }}">
                        <div class="flex flex-wrap px-2 mb-3">

                            <div class="w-full lg:w-1/2 px-3 mb-6 lg:mb-0">
                                <x-label for="email" :value="__('Email')" />
                                <x-input id="email" class="block mt-1 w-full" type="email"
                                    wire:model="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="w-full lg:w-1/2 px-3 mb-6 lg:mb-0">
                                <x-label for="city" :value="__('City')" />
                                <x-input id="city" class="block mt-1 w-full" type="text"
                                    wire:model="city" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <div class="w-full lg:w-1/2 px-3 mb-6 lg:mb-0">
                                <x-label for="tax_number" :value="__('Tax Number')" />
                                <x-input id="tax_number" class="block mt-1 w-full" type="text"
                                    wire:model="tax_number" />
                                <x-input-error :messages="$errors->get('tax_number')" for="" class="mt-2" />
                            </div>
                        </div>
                    </x-accordion>

                    <div class="w-full flex justify-center px-3">
                        <x-button primary type="submit" wire:loading.attr="disabled" class="w-full">
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
