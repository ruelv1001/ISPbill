<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-4 sm:p-8" style="max-height: 80vh; overflow-y: auto;">
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2
                        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight border-b-2 border-slate-100 pb-4">
                        {{ __('Create user') }}
                    </h2>

                    <form method="post" action="{{ route('users.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div class="grid grid-cols-4 gap-4">
                            <!-- Column 1: Account Information -->
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Account') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Add user account information") }}
                                </p>
                            </div>

                            <!-- Column 2: User Details -->
                            <div>
                                <div>
                                    <x-input-label for="name" :value="__('User Name')" class="mt-4"></x-input-label>
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                        :value="old('name')" required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('name')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="phone" :value="__('Phone')" class="mt-4"></x-input-label>
                                    <x-text-input id="phone" name="phone" type="number" class="mt-1 block w-full"
                                        :value="old('phone')" required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Email address')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="email" name="email" type="text" class="mt-1 block w-full"
                                        :value="old('email')" required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')"></x-input-error>
                                </div>
                            </div>

                            <!-- Column 3: Address and Area -->
                            <div>
                                <div>
                                    <x-input-label for="address" :value="__('Billing Address')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                        :value="old('address')" required></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('address')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="area" :value="__('Area')" class="mt-4"></x-input-label>
                                    <select name="area" id="area" class="w-full">
                                        @if ($areas && $areas->isNotEmpty())
                                            @foreach($areas as $area)
                                                <option value="{{ $area->area }}">{{ $area->area }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No areas available</option>
                                        @endif
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('area')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="role" :value="__('Role')" class="mt-4"></x-input-label>
                                    <select name="role" id="role" class="w-full">
                                        @if ($role && $role->isNotEmpty())
                                            @foreach($role as $roles)
                                                <option value="{{ $roles->role }}">{{ $roles->role }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No areas available</option>
                                        @endif
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('roles')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="coordinates" :value="__('Coordinates')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="coordinates" name="coordinates" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                        :value="old('coordinates')" required readonly />
                                    <x-input-error class="mt-2" :messages="$errors->get('coordinates')" />
                                </div>
                            </div>
                            <div id="map" class="mt-4 hidden" style="height: 300px;"></div>
                            <!-- Column 4: Hidden Fields -->
                            <div class="hidden">
                                <div>
                                    <x-input-label for="dob" :value="__('Date of birth')" class="mt-4"></x-input-label>
                                    <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full"
                                        :value="old('dob')"></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('dob')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="pin" :value="__('Personal Identification Number')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="pin" name="pin" type="text" class="mt-1 block w-full"
                                        :value="old('pin')"></x-text-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('pin')"></x-input-error>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-4">
                            <!-- Column 1: Subscription Information -->
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Subscription') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Add subscription details") }}
                                </p>
                            </div>

                            <!-- Column 2: Router Packages -->
                            <div>
                                <div class="w-full">
                                    <livewire:router-packages-dropdown />
                                </div>

                                <div class="hidden">
                                    <x-input-label for="router_password" :value="__('Mikrotik password')"
                                        class="mt-4"></x-input-label>
                                    <x-text-input id="router_password" value="admin12345" name="router_password"
                                        type="text" class="mt-1 block w-full"></x-text-input>
                                    <x-input-error class="mt-2"
                                        :messages="$errors->get('router_password')"></x-input-error>
                                </div>
                            </div>

                            <!-- Column 3: OLT and NAP -->
                            <div>
                                <div>
                                    <x-input-label for="olt" :value="__('OLT')" class="mt-4"></x-input-label>
                                    <select name="olt" id="olt" class="w-full">
                                        @if ($olt && $olt->isNotEmpty())
                                            @foreach($olt as $data)
                                                <option value="{{ $data->olt_device }}">{{ $data->olt_device }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No olt available</option>
                                        @endif
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('olt')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="nap" :value="__('NAP')" class="mt-4"></x-input-label>
                                    <select name="nap" id="nap" class="w-full">
                                        @if ($nap && $nap->isNotEmpty())
                                            @foreach($nap as $data)
                                                <option value="{{ $data->nap }}">{{ $data->nap }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No olt available</option>
                                        @endif
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('nap')"></x-input-error>
                                </div>
                            </div>

                            <!-- Column 4: Port and Pon -->
                            <div>
                                <div>
                                    <x-input-label for="port" :value="__('Port')" class="mt-4"></x-input-label>
                                    <select name="port" id="port" class="w-full">
                                        @if ($port && $port->isNotEmpty())
                                            @foreach($port as $data)
                                                <option value="{{ $data->port }}">{{ $data->port }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No olt available</option>
                                        @endif
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('port')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="pon" :value="__('Pon')" class="mt-4"></x-input-label>
                                    <select name="pon" id="pon" class="w-full">
                                        @if ($pon && $pon->isNotEmpty())
                                            @foreach($pon as $data)
                                                <option value="{{ $data->pon }}">{{ $data->pon }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No olt available</option>
                                        @endif
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('pon')"></x-input-error>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mt-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
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