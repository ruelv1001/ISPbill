<x-app-layout>
    <div style="padding: 1.5rem 0;">
        <div style="max-width: 1440px; margin: 0 auto; padding: 0 1rem;">
            <div style="background: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-radius: 0.75rem;">
                <div style="padding: 1.5rem; max-height: 85vh; overflow-y: auto;">
                    <x-slot name="header">
                        <h2 style="font-weight: 600; font-size: 1.5rem; color: #1a202c; margin: 0;">
                            {{ $user->name }}
                        </h2>
                    </x-slot>

                    @if (session('error'))
                        <div
                            style="color: #e53e3e; margin-bottom: 1rem; padding: 0.75rem; background: #FED7D7; border-radius: 0.5rem;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div
                        style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 1rem; margin-bottom: 1.5rem;">
                        <h2 style="font-weight: 600; font-size: 1.25rem; color: #1a202c;">
                            {{ __('Edit user') }}
                        </h2>

                        <div style="display: flex; gap: 1rem;">
                            <form action="{{ route('users.archive', $user->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to archive this user?');">
                                @csrf
                                <button type="submit"
                                    style="background: #e53e3e; color: white; border-radius: 0.5rem; padding: 0.5rem 1rem; transition: background-color 0.2s; hover:background-color: #c53030;">
                                    {{ __('Archive') }}
                                </button>
                            </form>

                            <form action="{{ route('transaction.user', $user->id) }}" method="GET">
                                @csrf
                                <button type="submit"
                                    style="background: #4299e1; color: white; border-radius: 0.5rem; padding: 0.5rem 1rem; transition: background-color 0.2s; hover:background-color: #3182ce;">
                                    {{ __('Transaction list') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <form method="post" action="{{ route('users.update', $user->id) }}" style="margin-top: 1.5rem;">
                        @csrf
                        @method('patch')

                        <div>
                            <h2 style="font-size: 1.25rem; font-weight: 500; color: #1a202c; margin-bottom: 1rem;">
                                {{ __('Account Information') }}
                            </h2>

                            <div
                                style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 2rem;">
                                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
                                    <!-- User Details Section -->
                                    <div
                                        style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="user_id" :value="__('User ID')" 
                                            style="font-weight: bold; font-size: 0.9rem; color: #4a5568; display: block; margin-bottom: 0.3rem;">
                                        </x-input-label>
                                        <x-text-input id="user_id" name="user_id" type="text" readonly
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $user->id }}">
                                        </x-text-input>
                                    </div>

                                    <div
                                    style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="name" :value="__('User Name')"></x-input-label>
                                        <x-text-input id="name" name="name" type="text"
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $user->detail->name }}"></x-text-input>
                                    </div>

                                    <div
                                    style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="email" :value="__('Email')"></x-input-label>
                                        <x-text-input id="email" name="email" type="email"
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $user->email }}" disabled></x-text-input>
                                    </div>

                                    <div
                                    style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="phone" :value="__('Phone')"></x-input-label>
                                        <x-text-input id="phone" name="phone" type="text"
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $user->detail->phone }}"></x-text-input>
                                    </div>

                                    <!-- Subscription Details -->
                                    <div
                                    style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="subscription_date" :value="__('Subscription Date')"></x-input-label>
                                        <x-text-input id="subscription_date" name="subscription_date" type="text"
                                            readonly style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $user->service_details->subscription_date ?? '' }}"></x-text-input>
                                    </div>

                                    <div
                                    style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="billing_date" :value="__('Next Billing Date')"></x-input-label>
                                        <x-text-input id="billing_date" name="billing_date" type="datetime-local"
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ old('billing_date', $user->service_details->billing_date ?? '') }}"></x-text-input>
                                    </div>

                                    <div
                                    style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="active_due_date" :value="__('Active Due Date')"></x-input-label>
                                        <x-text-input id="active_due_date" name="active_due_date" type="text"
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $user->service_details->active_due_date ?? '' }}"></x-text-input>
                                    </div>

                                    <div
                                    style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="address" :value="__('Address')"></x-input-label>
                                        <x-text-input id="address" name="address" type="text"
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $user->detail->address }}"></x-text-input>
                                    </div>

                                    <!-- Area and Coordinates -->
                                    <div
                                    style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="coordinates" :value="__('Coordinates')"></x-input-label>
                                        <x-text-input id="coordinates" name="coordinates" type="text"
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ old('coordinates', $user->detail->coordinates ?? '') }}"
                                            readonly></x-text-input>
                                    </div>

                                    <div
                                    style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="area" :value="__('Area')"></x-input-label>
                                        <select name="area" id="area"
                                            style="width: 100%; margin-top: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem; padding: 0.5rem;">
                                            <option value="" disabled selected>{{ $user->detail->area }}</option>
                                            @if ($area && $area->isNotEmpty())
                                                @foreach ($nap as $data)
                                                    @if ($data->area !== $user->detail->area)
                                                        <option value="{{ $data->area }}">{{ $data->area }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option disabled>No Area available</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div
                                    style="padding: 1rem; border-radius: 0.5rem;  ">
                                        <x-input-label for="remarks" :value="__('Remarks')"></x-input-label>
                                        <x-text-input id="remarks" name="remarks" type="text"
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $user->detail->remarks }}"></x-text-input>
                                    </div>
                                </div>
                            </div>

                            <!-- PON Management Section -->
                            <div
                                style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 2rem;">
                                <h3
                                    style="font-size: 1.125rem; font-weight: 500; color: #1a202c; margin-bottom: 1rem;">
                                    {{ __('PON Management') }}
                                </h3>
                                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
                                    <div
                                        style="background: white; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                                        <x-input-label for="olt" :value="__('OLT Device')"></x-input-label>
                                        <select id="olt" name="olt"
                                            style="width: 100%; margin-top: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem; padding: 0.5rem;">
                                            <option value="{{ $user->detail->olt }}" selected>
                                                {{ $user->detail->olt }}</option>
                                            @if ($olt && $olt->isNotEmpty())
                                                @foreach ($olt as $data)
                                                    @if ($data->olt_device !== $user->detail->olt)
                                                        <option value="{{ $data->olt_device }}">
                                                            {{ $data->olt_device }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div
                                        style="background: white; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                                        <x-input-label for="pon" :value="__('PON')"></x-input-label>
                                        <select id="pon" name="pon"
                                            style="width: 100%; margin-top: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem; padding: 0.5rem;">
                                            <option value="{{ $user->detail->pon }}" selected>
                                                {{ $user->detail->pon }}</option>
                                            @if ($pon && $pon->isNotEmpty())
                                                @foreach ($pon as $data)
                                                    @if ($data->pon !== $user->detail->pon)
                                                        <option value="{{ $data->pon }}">{{ $data->pon }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div
                                        style="background: white; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                                        <x-input-label for="nap" :value="__('NAP')"></x-input-label>
                                        <select id="nap" name="nap"
                                            style="width: 100%; margin-top: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem; padding: 0.5rem;">
                                            <option value="{{ $user->detail->nap }}" selected>
                                                {{ $user->detail->nap }}</option>
                                            @if ($nap && $nap->isNotEmpty())
                                                @foreach ($nap as $data)
                                                    @if ($data->nap !== $user->detail->nap)
                                                        <option value="{{ $data->nap }}">{{ $data->nap }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div
                                        style="background: white; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                                        <x-input-label for="port" :value="__('PORT')"></x-input-label>
                                        <select id="port" name="port"
                                            style="width: 100%; margin-top: 0.5rem; border: 1px solid #e2e8f0; border-radius: 0.375rem; padding: 0.5rem;">
                                            <option value="{{ $user->detail->port }}" selected>
                                                {{ $user->detail->port }}</option>
                                            @if ($port && $port->isNotEmpty())
                                                @foreach ($port as $data)
                                                    @if ($data->port !== $user->detail->port)
                                                        <option value="{{ $data->port }}">{{ $data->port }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- MT Parameters Section -->
                            <div
                                style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 2rem;">
                                <h3
                                    style="font-size: 1.125rem; font-weight: 500; color: #1a202c; margin-bottom: 1rem;">
                                    {{ __('MT Parameters') }}
                                </h3>
                                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
                                    <div
                                        style="background: white; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                                        <x-input-label for="uptime" :value="__('Uptime')"></x-input-label>
                                        <x-text-input id="uptime" name="uptime" type="text" readonly
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $data['uptime'] ?? 'N/A' }}"></x-text-input>
                                    </div>

                                    <div
                                        style="background: white; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                                        <x-input-label for="router_name" :value="__('Router Name')"></x-input-label>
                                        <x-text-input id="router_name" name="router_name" type="text" readonly
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $data['router']['name'] ?? 'Unknown' }}"></x-text-input>
                                    </div>

                                    <div
                                        style="background: white; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                                        <x-input-label for="router_ip" :value="__('Router IP')"></x-input-label>
                                        <x-text-input id="router_ip" name="router_ip" type="text" readonly
                                            style="width: 90%; margin-top: 0.5rem; background: #ffff; border-radius: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #e2e8f0;"
                                            value="{{ $data['router']['ip'] ?? 'N/A' }}"></x-text-input>
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; justify-content: flex-end; margin-top: 2rem;">
                                <x-primary-button style="padding: 0.75rem 2rem; font-size: 1rem;">
                                    {{ __('Update') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the coordinates from the input field
        var coordinatesInput = document.getElementById('coordinates');
        var initialCoordinates = coordinatesInput.value;

        // Initialize the map
        var map = L.map('map');

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Initialize marker with default position
        var marker = L.marker([0, 0], {
            draggable: true
        }).addTo(map);

        // If we have existing coordinates, use them
        if (initialCoordinates) {
            var coords = initialCoordinates.split(',').map(coord => parseFloat(coord.trim()));
            if (coords.length === 2 && !isNaN(coords[0]) && !isNaN(coords[1])) {
                map.setView(coords, 13);
                marker.setLatLng(coords);
            }
        }
        // If no existing coordinates, try to get user's location
        else if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var userLatLng = [lat, lng];
                    map.setView(userLatLng, 13);
                    marker.setLatLng(userLatLng);
                    coordinatesInput.value = `${lat}, ${lng}`;
                },
                function(error) {
                    console.error('Error getting location:', error.message);
                    // Default view if geolocation fails
                    map.setView([0, 0], 2);
                }
            );
        } else {
            // Default view if geolocation is not supported
            map.setView([0, 0], 2);
        }

        // Update coordinates when marker is dragged
        marker.on('dragend', function(e) {
            var latLng = marker.getLatLng();
            coordinatesInput.value = `${latLng.lat}, ${latLng.lng}`;
        });

        // Update marker position when map is clicked
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            coordinatesInput.value = `${e.latlng.lat}, ${e.latlng.lng}`;
        });

        // Handle search functionality
        var searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    var query = searchInput.value;

                    fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                var place = data[0];
                                var latLng = [place.lat, place.lon];
                                map.setView(latLng, 13);
                                marker.setLatLng(latLng);
                                coordinatesInput.value = `${place.lat}, ${place.lon}`;
                            } else {
                                alert('Place not found.');
                            }
                        });
                }
            });
        }
    });
</script>
