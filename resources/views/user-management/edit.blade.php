<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    <x-slot name="header">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ $user->name }}
                        </h2>
                    </x-slot>
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2
                        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight border-b-2 border-slate-100 pb-4">
                        {{ __('Edit user') }}
                    </h2>

                    <form method="post" action="{{ route('users.update', $user->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Account') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Edit user account information") }}
                                </p>
                            </div>

                            <div>
                                <div>
                                    <x-input-label for="user_id" :value="__('User ID')" class="mt-4"
                                        disabled></x-input-label>
                                    <x-text-input id="user_id" name="user_id" type="text" readonly
                                        class="mt-1 block w-full bg-gray-100" value="{{ $user->id }}"></x-text-input>
                                </div>
                                <div>
                                    <x-input-label for="first_name" :value="__('User FIrst Name')" class="mt-4"
                                        disabled></x-input-label>
                                    <x-text-input id="first_name" name="first_name" type="text"
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $user->detail->first_name }}"></x-text-input>
                                </div>
                                <div>
                                    <x-input-label for="last_name" :value="__('User FIrst Name')" class="mt-4"
                                        disabled></x-input-label>
                                    <x-text-input id="last_name" name="last_name" type="text"
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $user->detail->last_name }}"></x-text-input>
                                </div>

                                <div>
                                    <x-input-label for="subscription_date" :value="__('Subscription Date')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="subscription_date" name="subscription_date" type="text" readonly
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $user->service_details->subscription_date ?? '' }}"></x-text-input>
                                </div>
                                <div>
                                    <x-input-label for="billing_date" :value="__('Next Billing Date')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="billing_date" name="billing_date" type="datetime-local"
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ old('billing_date', $user->service_details->billing_date ?? '2025-02-07T00:00') }}">
                                    </x-text-input>
                                </div>

                                <div>
                                    <x-input-label for="active_due_date" :value="__('Active Due Date')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="active_due_date" name="active_due_date" type="text"
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $user->service_details->active_due_date ?? '' }}"></x-text-input>
                                </div>

                                <div>
                                    <x-input-label for="previous_due_date" :value="__('Previous Due Date')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="previous_due_date" name="previous_due_date" type="text"
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $user->service_details->previous_due_date ?? '' }}"></x-text-input>
                                </div>
                                <div>
                                    <x-input-label for="phone" :value="__('Phone number')" class="mt-4"></x-input-label>
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                        value="{{ $user->detail->phone }}"></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')"></x-input-error>
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email address')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="email" name="email" type="text"
                                        class="mt-1 block w-full bg-gray-100" value="{{ $user->email }}"
                                        disabled></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="password" :value="__('Password')" class="mt-4"></x-input-label>
                                    <x-text-input name="password" type="password" class="mt-1 block w-full"
                                        value=""></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('password')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Password confirm')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input name="password_confirmation" type="password" class="mt-1 block w-full"
                                        value=""></x-text-input>
                                    <x-input-error class="mt-2"
                                        :messages="$errors->get('password_confirmation')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="address" :value="__('Address')" class="mt-4"></x-input-label>
                                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                        value="{{ $user->detail->address }}"></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('address')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="coordinates" :value="__('Coordinates')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="coordinates" name="coordinates" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                        :value="old('coordinates')" readonly />
                                    <x-input-error class="mt-2" :messages="$errors->get('coordinates')" />
                                </div>

                                <!-- Search Input -->


                                <!-- Map -->
                                <div id="map" style="height: 400px;" class="mt-6 rounded shadow"></div>

                                <div class="hidden">
                                    <x-input-label for="dob" :value="__('Date of birth')" class="mt-4"></x-input-label>
                                    <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full"
                                        value="{{ $user->detail->dob }}"></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('dob')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="pin" :value="__('Personal Identification Number')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="pin" name="pin" type="text" class="mt-1 block w-full"
                                        value="{{ $user->detail->pin }}"></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('pin')"></x-input-error>
                                </div>

                                <div class="flex items-center gap-4 mt-4">
                                    <x-primary-button>{{ __('Update') }}</x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the map
        var map = L.map('map').setView([51.505, -0.09], 13); // Default coordinates and zoom level

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add a draggable marker
        var marker = L.marker([51.505, -0.09], { draggable: true }).addTo(map);

        // Update the coordinates input when the marker is dragged
        marker.on('dragend', function (e) {
            var latLng = marker.getLatLng();
            document.getElementById('coordinates').value = `${latLng.lat}, ${latLng.lng}`;
        });

        // Update the marker position when the map is clicked
        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            document.getElementById('coordinates').value = `${e.latlng.lat}, ${e.latlng.lng}`;
        });

        // Use Geolocation API to get user's precise location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    // Update map and marker to user's location
                    var userLatLng = [lat, lng];
                    map.setView(userLatLng, 13);
                    marker.setLatLng(userLatLng);
                    document.getElementById('coordinates').value = `${lat}, ${lng}`;
                },
                function (error) {
                    console.error('Error getting location:', error.message);
                }
            );
        } else {
            alert('Geolocation is not supported by your browser.');
        }

        // Handle search functionality
        var searchInput = document.getElementById('search');
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                var query = searchInput.value;

                // Fetch location data from Nominatim API
                fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            var place = data[0];
                            var latLng = [place.lat, place.lon];
                            map.setView(latLng, 13); // Center map to the place
                            marker.setLatLng(latLng); // Move marker to the place
                            document.getElementById('coordinates').value = `${place.lat}, ${place.lon}`;
                        } else {
                            alert('Place not found.');
                        }
                    });
            }
        });
    });
</script>
