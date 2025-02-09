<x-app-layout>
    <div style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
        <div style="max-width: 90rem; margin-left: auto; margin-right: auto; padding-left: 1.5rem; padding-right: 1.5rem;">
            <div style="background-color: white; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                <div style="padding: 1rem; max-height: 80vh; overflow-y: auto;">
                    @if(session('error'))
                        <div style="color: #dc2626;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 style="font-weight: 600; font-size: 1.25rem; color: #1f2937; line-height: 1.25; border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem;">
                        {{ __('Create user') }}
                    </h2>

                    <form method="post" action="{{ route('users.store') }}" style="margin-top: 1.5rem;">
                        @csrf

                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                            <!-- Column 1: Account Information -->
                            <div>
                                <h2 style="font-size: 1.125rem; font-weight: 500; color: #1f2937;">{{ __('Account') }}</h2>
                                <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #6b7280;">
                                    {{ __("Add user account information") }}
                                </p>
                            </div>

                            <!-- Column 2: User Details -->
                            <div>
                                <div>
                                    <x-input-label for="name" :value="__('User Name')" style="margin-top: 1rem;"></x-input-label>
                                    <x-text-input id="name" name="name" type="text" style="margin-top: 0.25rem; display: block; width: 100%;"
                                        :value="old('name')" required></x-text-input>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('name')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="phone" :value="__('Phone')" style="margin-top: 1rem;"></x-input-label>
                                    <x-text-input id="phone" name="phone" type="number" style="margin-top: 0.25rem; display: block; width: 100%;"
                                        :value="old('phone')" required></x-text-input>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('phone')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Email address')" style="margin-top: 1rem;"></x-input-label>
                                    <x-text-input id="email" name="email" type="text" style="margin-top: 0.25rem; display: block; width: 100%;"
                                        :value="old('email')" required></x-text-input>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('email')"></x-input-error>
                                </div>
                            </div>

                            <!-- Column 3: Address and Area -->
                            <div>
                                <div>
                                    <x-input-label for="address" :value="__('Billing Address')" style="margin-top: 1rem;"></x-input-label>
                                    <x-text-input id="address" name="address" type="text" style="margin-top: 0.25rem; display: block; width: 100%;"
                                        :value="old('address')" required></x-text-input>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('address')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="area" :value="__('Area')" style="margin-top: 1rem;"></x-input-label>
                                    <select name="area" id="area" style="width: 100%;">
                                        @if ($areas && $areas->isNotEmpty())
                                            @foreach($areas as $area)
                                                <option value="{{ $area->area }}">{{ $area->area }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No areas available</option>
                                        @endif
                                    </select>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('area')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="role" :value="__('Role')" style="margin-top: 1rem;"></x-input-label>
                                    <select name="role" id="role" style="width: 100%;">
                                        @if ($role && $role->isNotEmpty())
                                            @foreach($role as $roles)
                                                <option value="{{ $roles->role }}">{{ $roles->role }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No areas available</option>
                                        @endif
                                    </select>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('roles')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="coordinates" :value="__('Coordinates')" style="margin-top: 1rem;"></x-input-label>
                                    <x-text-input id="coordinates" name="coordinates" type="text"
                                        style="margin-top: 0.25rem; display: block; width: 100%; border: 1px solid #d1d5db; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);"
                                        :value="old('coordinates')" required readonly />
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('coordinates')" />
                                </div>
                            </div>
                            <div id="map" style="margin-top: 1rem; height: 300px; display: none;"></div>

                            <!-- Column 4: Hidden Fields -->
                            <div style="display: none;">
                                <div>
                                    <x-input-label for="dob" :value="__('Date of birth')" style="margin-top: 1rem;"></x-input-label>
                                    <x-text-input id="dob" name="dob" type="date" style="margin-top: 0.25rem; display: block; width: 100%;"
                                        :value="old('dob')"></x-text-input>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('dob')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="pin" :value="__('Personal Identification Number')" style="margin-top: 1rem;"></x-input-label>
                                    <x-text-input id="pin" name="pin" type="text" style="margin-top: 0.25rem; display: block; width: 100%;"
                                        :value="old('pin')"></x-text-input>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('pin')"></x-input-error>
                                </div>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                            <!-- Column 1: Subscription Information -->
                            <div>
                                <h2 style="font-size: 1.125rem; font-weight: 500; color: #1f2937;">
                                    {{ __('Subscription') }}
                                </h2>
                                <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #6b7280;">
                                    {{ __("Add subscription details") }}
                                </p>
                            </div>

                            <!-- Column 2: Router Packages -->
                            <div>
                                <div style="width: 100%;">
                                    <livewire:router-packages-dropdown />
                                </div>

                                <div style="display: none;">
                                    <x-input-label for="router_password" :value="__('Mikrotik password')" style="margin-top: 1rem;"></x-input-label>
                                    <x-text-input id="router_password" value="admin12345" name="router_password"
                                        type="text" style="margin-top: 0.25rem; display: block; width: 100%;"></x-text-input>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('router_password')"></x-input-error>
                                </div>
                            </div>

                            <!-- Column 3: OLT and NAP -->
                            <div>
                                <div>
                                    <x-input-label for="olt" :value="__('OLT')" style="margin-top: 1rem;"></x-input-label>
                                    <select name="olt" id="olt" style="width: 100%;">
                                        @if ($olt && $olt->isNotEmpty())
                                            @foreach($olt as $data)
                                                <option value="{{ $data->olt_device }}">{{ $data->olt_device }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No olt available</option>
                                        @endif
                                    </select>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('olt')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="nap" :value="__('NAP')" style="margin-top: 1rem;"></x-input-label>
                                    <select name="nap" id="nap" style="width: 100%;">
                                        @if ($nap && $nap->isNotEmpty())
                                            @foreach($nap as $data)
                                                <option value="{{ $data->nap }}">{{ $data->nap }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No olt available</option>
                                        @endif
                                    </select>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('nap')"></x-input-error>
                                </div>
                            </div>

                            <!-- Column 4: Port and Pon -->
                            <div>
                                <div>
                                    <x-input-label for="port" :value="__('Port')" style="margin-top: 1rem;"></x-input-label>
                                    <select name="port" id="port" style="width: 100%;">
                                        @if ($port && $port->isNotEmpty())
                                            @foreach($port as $data)
                                                <option value="{{ $data->port }}">{{ $data->port }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No olt available</option>
                                        @endif
                                    </select>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('port')"></x-input-error>
                                </div>

                                <div>
                                    <x-input-label for="pon" :value="__('Pon')" style="margin-top: 1rem;"></x-input-label>
                                    <select name="pon" id="pon" style="width: 100%;">
                                        @if ($pon && $pon->isNotEmpty())
                                            @foreach($pon as $data)
                                                <option value="{{ $data->pon }}">{{ $data->pon }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No olt available</option>
                                        @endif
                                    </select>
                                    <x-input-error style="margin-top: 0.5rem;" :messages="$errors->get('pon')"></x-input-error>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1rem;">
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
