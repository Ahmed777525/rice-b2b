<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('messages.name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('messages.email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Company Name -->
        <div class="mt-4">
            <x-input-label for="company_name" :value="__('messages.company_name')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <!-- Commercial Register -->
        <div class="mt-4">
            <x-input-label for="commercial_register" :value="__('messages.commercial_register')" />
            <x-text-input id="commercial_register" class="block mt-1 w-full" type="text" name="commercial_register" :value="old('commercial_register')" required />
            <x-input-error :messages="$errors->get('commercial_register')" class="mt-2" />
        </div>

        <!-- Tax Number (Optional) -->
        <div class="mt-4">
            <x-input-label for="tax_number" :value="__('messages.tax_number')" />
            <x-text-input id="tax_number" class="block mt-1 w-full" type="text" name="tax_number" :value="old('tax_number')" />
            <x-input-error :messages="$errors->get('tax_number')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('messages.phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Branch Selection -->
        <div class="mt-4">
            <x-input-label for="branch_id" :value="__('messages.select_branch')" />
            <select id="branch_id" name="branch_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                <option value="">-- {{ __('messages.select_branch') }} --</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->localized_name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('messages.password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('messages.confirm_password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('messages.already_registered') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('messages.register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>