<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight border-b-2 border-slate-100 pb-4">
                            {{ __('Create user') }}
                        </h2>

                    <form method="post" action="{{ route('users.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Account') }}</h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Add user account information") }}</p>
                            </div>

                            <div>


                                <div>
                                    <x-input-label for="first_name" :value="__('First name')" class="mt-4"></x-input-label>
                                    <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')"
                                        required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('first_name')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="last_name" :value="__('Last name')" class="mt-4"></x-input-label>
                                    <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('first_name')"
                                        required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('first_name')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="phone" :value="__('Phone')" class="mt-4"></x-input-label>
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')"
                                        required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')"></x-input-error>
                                </div>



                                <div>
                                    <x-input-label for="email" :value="__('Email address')" class="mt-4"></x-input-label>
                                    <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email')" required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="password" :value="__('Password')" class="mt-4"></x-input-label>
                                    <x-text-input name="password" type="password" class="mt-1 block w-full" value=""></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('password')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Password confirm')" class="mt-4"></x-input-label>
                                    <x-text-input name="password_confirmation" type="password" class="mt-1 block w-full" value=""></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="address" :value="__('Billing Address')" class="mt-4"></x-input-label>
                                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('address')"></x-input-error>
                                </div>
                                <div>
                                    <x-input-label for="area" :value="__('Area')" class="mt-4"></x-input-label>
                                    <select id="area" name="area" class="mt-1 block w-full">
                                        <option value="" disabled selected>{{ __('Select Area') }}</option>
                                        <option value="1" {{ old('area') == 1 ? 'selected' : '' }}>Area 1</option>
                                        <option value="2" {{ old('area') == 2 ? 'selected' : '' }}>Area 2</option>
                                        <option value="3" {{ old('area') == 3 ? 'selected' : '' }}>Area 3</option>
                                        <option value="4" {{ old('area') == 4 ? 'selected' : '' }}>Area 4</option>
                                        <option value="5" {{ old('area') == 5 ? 'selected' : '' }}>Area 5</option>
                                        <option value="6" {{ old('area') == 6 ? 'selected' : '' }}>Area 6</option>
                                        <option value="7" {{ old('area') == 7 ? 'selected' : '' }}>Area 7</option>
                                        <option value="8" {{ old('area') == 8 ? 'selected' : '' }}>Area 8</option>
                                        <option value="9" {{ old('area') == 9 ? 'selected' : '' }}>Area 9</option>
                                        <option value="10" {{ old('area') == 10 ? 'selected' : '' }}>Area 10</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('area')"></x-input-error>
                                </div>

                                <div class="hidden">
                                    <x-input-label for="my_profile" :value="__('Profile')" class="mt-4"></x-input-label>
                            <select id="my_profile" name="my_profile" class="mt-1 block w-full">
                                <option value="" disabled selected>{{ __('Select Profile') }}</option>
                                <option value="Profile 1" {{ old('my_profile') == 'Profile 1' ? 'selected' : '' }}>Profile 1</option>
                                <option value="Profile 2" {{ old('my_profile') == 'Profile 2' ? 'selected' : '' }}>Profile 2</option>
                                <option value="Profile 3" {{ old('my_profile') == 'Profile 3' ? 'selected' : '' }}>Profile 3</option>
                            </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('my_profile')"></x-input-error>
                                </div>

                                <div class="mt-4 hidden">
                                    <x-input-label for="search" :value="__('Search Place')" />
                                    <x-text-input id="search" name="search" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                        placeholder="Search a location" />
                                    <x-input-error class="mt-2" :messages="$errors->get('search')" />
                                </div>

                                <div >
                                    <x-input-label for="coordinates" :value="__('Coordinates')" class="mt-4"></x-input-label>
                                    <x-text-input id="coordinates" name="coordinates" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="old('coordinates')" required readonly />
                                    <x-input-error class="mt-2" :messages="$errors->get('coordinates')" />
                                </div>

                    <!-- Search Input -->


                    <!-- Map -->
                                <div id="map" style="height: 400px;" class="mt-6 rounded shadow"></div>
                                            <div class="hidden">
                                                <x-input-label for="dob" :value="__('Date of birth')" class="mt-4"></x-input-label>
                                                <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob')" ></x-text-input>
                                                <x-input-error class="mt-2" :messages="$errors->get('dob')"></x-input-error>
                                            </div>

                                            <div  class="hidden">
                                                <x-input-label for="pin" :value="__('Personal Identification Number')" class="mt-4"></x-input-label>
                                                <x-text-input id="pin" name="pin" type="text" class="mt-1 block w-full" :value="old('pin')" ></x-text-input>
                                                <x-input-error class="mt-2" :messages="$errors->get('pin')"></x-input-error>
                                            </div>
                                        </div>
                                    </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Subscription') }}</h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Add subscription details") }}</p>
                            </div>

                            <div>
                                <div>
                                    <livewire:router-packages-dropdown />
                                </div>
                                <div class="hidden">
                                    <x-input-label for="router_password" :value="__('Mikrotik password')" class="mt-4"></x-input-label>
                                    <x-text-input id="router_password" value="admin12345" name="router_password" type="text" class="mt-1 block w-full"  ></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('router_password')"></x-input-error>
                                </div>

                                <div class="flex items-center gap-4 mt-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
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

