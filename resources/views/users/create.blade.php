<x-app-layout>
    <div style="padding: 1.5rem;">
        <div style="max-width: 90rem; margin: auto; padding: 1.5rem;">
            <div
                style="background-color: white; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-radius: 0.5rem; padding: 1rem;">

                @if(session('error'))
                    <div style="color: #dc2626; margin-bottom: 1rem;">
                        {{ session('error') }}
                    </div>
                @endif

                <h2
                    style="font-weight: 600; font-size: 1.25rem; color: #1f2937; border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem;">
                    {{ __('Create user') }}
                </h2>

                <form method="post" action="{{ route('users.store') }}" style="margin-top: 1.5rem;">
                    @csrf
                    <div>
                        <h2 style="font-size: 1.125rem; font-weight: 500; color: #1f2937;">{{ __('Account') }}</h2>
                        <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #6b7280;">
                            {{ __("Add user account information") }}
                        </p>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                        <!-- Column 1: Account Information -->


                        <!-- Column 2: User Details -->
                        <div style="margin-right: 20px; ">
                            <div style="margin-bottom: 15px; margin-top: 5px;">
                                <label for="name"
                                    style="font-weight: 500; color: #374151; margin: bottom 20px;">{{ __('User Name') }}</label>
                                <input id="name" name="name" type="text"
                                    style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; margin: bottom 20px;  "
                                    value="{{ old('name') }}" required>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label for="phone" style="font-weight: 500; color: #374151;">{{ __('Phone') }}</label>
                                <input id="phone" name="phone" type="number"
                                    style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;"
                                    value="{{ old('phone') }}" required>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label for="email"
                                    style="font-weight: 500; color: #374151;">{{ __('Email address') }}</label>
                                <input id="email" name="email" type="text"
                                    style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;"
                                    value="{{ old('email') }}" required>
                            </div>


                            <div style="margin-bottom: 15px;">
                                <label for="address"
                                    style="font-weight: 500; color: #374151;">{{ __('Billing Address') }}</label>
                                <input id="address" name="address" type="text"
                                    style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;"
                                    value="{{ old('address') }}" required>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label for="remarks"
                                    style="font-weight: 500; color: #374151;">{{ __('Remarks') }}</label>
                                <input id="remarks" name="remarks" type="text"
                                    style="margin-top: 0.25rem; display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;"
                                    value="{{ old('remarks') }}">
                            </div>


                            <div style="margin-bottom: 15px;">
                                <label for="area" style="font-weight: 500; color: #374151;">{{ __('Area') }}</label>
                                <select name="area" id="area"
                                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                                    @if ($areas && $areas->isNotEmpty())
                                        @foreach($areas as $area)
                                            <option value="{{ $area->area }}">{{ $area->area }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No areas available</option>
                                    @endif
                                </select>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label for="role" style="font-weight: 500; color: #374151;">{{ __('Role') }}</label>
                                <select name="role" id="role"
                                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                                    @if ($role && $role->isNotEmpty())
                                        @foreach($role as $roles)
                                            <option value="{{ $roles->role }}">{{ $roles->role }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No roles available</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- Column 3: Location -->
                        <div style="font-family: Arial, sans-serif; color: #374151; max-width: 500px; margin: auto;">

                            <div style="margin-bottom: 20px;">
                                <label for="coordinates"
                                    style="display: block; font-weight: 600; margin-bottom: 5px;">{{ __('Coordinates') }}</label>
                                <input id="coordinates" name="coordinates" type="text"
                                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); background: #f9f9f9;"
                                    value="{{ old('coordinates') }}" required readonly />
                            </div>

                            <div id="map" style="margin-top: 1rem; height: 300px; display: none;"></div>



                            <div style="margin-bottom: 20px; display: none;">
                                <label for="router_password"
                                    style="display: block; font-weight: 600; margin-bottom: 5px;">{{ __('Mikrotik Password') }}</label>
                                <input id="router_password" name="router_password" type="text" value="admin12345"
                                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);">
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label for="olt"
                                    style="display: block; font-weight: 600; margin-bottom: 5px;">{{ __('OLT') }}</label>
                                <select name="olt" id="olt"
                                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
                                    @if ($olt && $olt->isNotEmpty())
                                        @foreach($olt as $data)
                                            <option value="{{ $data->olt_device }}">{{ $data->olt_device }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No OLT available</option>
                                    @endif
                                </select>
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label for="nap"
                                    style="display: block; font-weight: 600; margin-bottom: 5px;">{{ __('NAP') }}</label>
                                <select name="nap" id="nap"
                                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
                                    @if ($nap && $nap->isNotEmpty())
                                        @foreach($nap as $data)
                                            <option value="{{ $data->nap }}">{{ $data->nap }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No NAP available</option>
                                    @endif
                                </select>
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label for="port"
                                    style="display: block; font-weight: 600; margin-bottom: 5px;">{{ __('Port') }}</label>
                                <select name="port" id="port"
                                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
                                    @if ($port && $port->isNotEmpty())
                                        @foreach($port as $data)
                                            <option value="{{ $data->port }}">{{ $data->port }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No port available</option>
                                    @endif
                                </select>
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label for="pon"
                                    style="display: block; font-weight: 600; margin-bottom: 5px;">{{ __('Pon') }}</label>
                                <select name="pon" id="pon"
                                    style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
                                    @if ($pon && $pon->isNotEmpty())
                                        @foreach($pon as $data)
                                            <option value="{{ $data->pon }}">{{ $data->pon }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No Pon available</option>
                                    @endif
                                </select>
                            </div>

                            <div style="margin-bottom: 20px;">
                                <livewire:router-packages-dropdown />
                                <div style="display: none;">
                                    <x-input-label for="router_password" :value="__('Mikrotik password')"
                                        style="margin-top: 1rem;"></x-input-label>
                                    <x-text-input id="router_password" value="admin12345" name="router_password"
                                        type="text"
                                        style="margin-top: 0.25rem; display: block; width: 100%;"></x-text-input>
                                    <x-input-error style="margin-top: 0.5rem;"
                                        :messages="$errors->get('router_password')"></x-input-error>
                                </div>

                            </div>

                        </div>




                    </div>
                    <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
                        <button type="submit"
                            style="background-color: #3b82f6; color: white; font-weight: 500; padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; cursor: pointer;">
                            {{ __('Create User') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')

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