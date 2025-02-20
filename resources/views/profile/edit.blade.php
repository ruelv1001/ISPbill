<x-app-layout>
    <x-slot name="header">
        <h2 style="font-weight: 600; font-size: 1.25rem; color: #2d3748; line-height: 1.75rem;">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div style="padding-top: 3rem; padding-bottom: 3rem;">
        <div
            style="max-width: 1280px; margin-left: auto; margin-right: auto; padding-left: 1.5rem; padding-right: 1.5rem; space-y: 1.5rem;">
            <div
                style="padding: 1rem; background-color: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 0.375rem;">
                <div style="max-width: 36rem;">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div
                style="padding: 1rem; background-color: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 0.375rem;">
                <div style="max-width: 36rem;">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')
