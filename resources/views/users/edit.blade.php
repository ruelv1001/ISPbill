<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="p-4 sm:p-8 max-h-[80vh] overflow-y-auto">
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

                    <div class="flex space-x-4 mt-5">
                        <form action="{{ route('users.archive', $user->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to archive this user?');">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white rounded-md px-3 py-1">
                                {{ __('Archive') }}
                            </button>
                        </form>

                        <form action="{{ route('transaction.user', $user->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white rounded-md px-3 py-1">
                                {{ __('Transaction list') }}
                            </button>
                        </form>


                    </div>

                    <form method="post" action="{{ route('users.update', $user->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 gap-4 borde">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Account') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Edit user account information") }}
                                </p>


                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 outline outline-2 outline-gray-300  p-4">
                                    <div>
                                        <x-input-label for="user_id" :value="__('User ID')" class="mt-4"
                                            disabled></x-input-label>
                                        <x-text-input id="user_id" name="user_id" type="text" readonly
                                            class="mt-1 block w-full bg-gray-100"
                                            value="{{ $user->id }}"></x-text-input>
                                    </div>

                                    <div>
                                        <x-input-label for="name" :value="__('User  Name')" class="mt-4"
                                            disabled></x-input-label>
                                        <x-text-input id="name" name="name" type="text"
                                            class="mt-1 block w-full bg-gray-100"
                                            value="{{ $user->detail->name }}"></x-text-input>
                                    </div>


                                    <div>
                                        <x-input-label for="subscription_date" :value="__('Subscription Date')"
                                            class="mt-4"></x-input-label>
                                        <x-text-input id="subscription_date" name="subscription_date" type="text"
                                            readonly class="mt-1 block w-full bg-gray-100"
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
                                        <x-input-label for="phone" :value="__('Phone number')"
                                            class="mt-4"></x-input-label>
                                        <x-text-input id="phone" name="phone" type="number" class="mt-1 block w-full"
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
                                        <x-input-label for="address" :value="__('Address')"
                                            class="mt-4"></x-input-label>
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

                                    <div>
                                        <x-input-label for="area" :value="__('area')" class="mt-4"></x-input-label>
                                        <select>
                                            <option value="" disabled selected>{{$user->detail->area}}</option>
                                            @if ($area && $area->isNotEmpty())
                                                @foreach($nap as $data)
                                                    @if ($data->area !== $user->detail->area)
                                                        <option value="{{ $data->area }}">{{ $data->area }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option disabled>No Area available</option>
                                            @endif
                                        </select>

                                    </div>

                                    <!-- Search Input -->


                                    <!-- Map -->
                                    <div class="hidden">
                                        <x-input-label for="is_lock" :value="__('Lock')" class="mt-4"></x-input-label>
                                        <select id="is_lock" name="is_lock" class="mt-1 block w-full bg-gray-100">
                                            <option value="lock" {{ $user->detail->is_lock == "lock" ? 'selected' : '' }}>
                                                {{ __('Lock') }}
                                            </option>
                                            <option value="unlock" {{ $user->detail->is_lock == "unlock" ? 'selected' : '' }}>
                                                {{ __('Unlock') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div id="map" style="height: 400px;" class="mt-6 rounded shadow hidden"></div>








                                </div>

                    <div class="space-y-4 outline outline-2 outline-gray-300  p-4 mt-4">
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __("PON management") }}
                        </p>

                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-2">
                                <x-input-label for="olt" :value="__('OLT Device')"></x-input-label>
                                <select id="olt" name="olt" class="border-gray-300 rounded-md shadow-sm">
                                    <option value="{{ $user->detail->olt }}" selected>{{ $user->detail->olt }}</option>
                                    @if ($olt && $olt->isNotEmpty())
                                        @foreach($olt as $data)
                                            @if ($data->olt_device !== $user->detail->olt)
                                                <option value="{{ $data->olt_device }}">{{ $data->olt_device }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option disabled>No OLT available</option>
                                    @endif
                                </select>
                            </div>

                            <div class="flex items-center gap-2">
                                <x-input-label for="pon" :value="__('Select PON')"></x-input-label>
                                <select id="pon" name="pon" class="border-gray-300 rounded-md shadow-sm">
                                    <option value="{{ $user->detail->pon }}" selected>{{ $user->detail->pon }}</option>
                                    @if ($pon && $pon->isNotEmpty())
                                        @foreach($pon as $data)
                                            @if ($data->pon !== $user->detail->pon)
                                                <option value="{{ $data->pon }}">{{ $data->pon }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option disabled>No PON available</option>
                                    @endif
                                </select>
                            </div>

                            <div class="flex items-center gap-2">
                                <x-input-label for="nap" :value="__('Select NAP')"></x-input-label>
                                <select id="nap" name="nap" class="border-gray-300 rounded-md shadow-sm">
                                    <option value="{{ $user->detail->nap }}" selected>{{ $user->detail->nap }}</option>
                                    @if ($nap && $nap->isNotEmpty())
                                        @foreach($nap as $data)
                                            @if ($data->nap !== $user->detail->nap)
                                                <option value="{{ $data->nap }}">{{ $data->nap }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option disabled>No NAP available</option>
                                    @endif
                                </select>
                            </div>

                            <div class="flex items-center gap-2">
                                <x-input-label for="port" :value="__('Select PORT')"></x-input-label>
                                <select id="port" name="port" class="border-gray-300 rounded-md shadow-sm">
                                    <option value="{{ $user->detail->port }}" selected>{{ $user->detail->port }}</option>
                                    @if ($port && $port->isNotEmpty())
                                        @foreach($port as $data)
                                            @if ($data->port !== $user->detail->port)
                                                <option value="{{ $data->port }}">{{ $data->port }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option disabled>No PORT available</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>


                                <div class="mt-4 outline outline-2 outline-gray-300  p-4">
                                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ __("MT Parameters") }}
                                        </p>
                                        <div class="grid grid-cols-4 gap-4">
                                        <x-input-label for="uptime" :value="__('Uptime')" class="mt-4"></x-input-label>
                                        <x-text-input id="uptime" name="uptime" type="text" class="mt-1 block w-full" readonly
                                            value="{{ $data['uptime'] ?? 'N/A' }}"></x-text-input>
                                        <x-input-error class="mt-2" :messages="$errors->get('uptime')" readonly></x-input-error>
                                        <x-input-label for="router_name" :value="__('Router Name')"
                                            class="mt-4"></x-input-label>
                                        <x-text-input id="router_name" name="router_name" type="text"
                                            class="mt-1 block w-full"
                                            value="{{ $data['router']['name'] ?? 'Unknown' }}" readonly></x-text-input>
                                        <x-input-error class="mt-2" readonly
                                            :messages="$errors->get('router_name')" readonly></x-input-error>

                                        <x-input-label for="router_ip" :value="__('Router IP')" readonly
                                            class="mt-4"></x-input-label>
                                        <x-text-input id="router_ip" name="router_ip" type="text" readonly
                                            class="mt-1 block w-full"
                                            value="{{ $data['router']['ip'] ?? 'N/A' }}"></x-text-input>
                                        <x-input-error class="mt-2"
                                            :messages="$errors->get('router_ip')" readonly></x-input-error>
                                        </div>

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
