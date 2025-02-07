<div class="grid grid-cols-1 gap-4">
    <div class="flex-1">
        <x-input-label for="router_name" :value="__('Select router')" class="mt-3"></x-input-label>
        <select wire:model="routerId" name="router_name" id="router_name"
            class="mt-1 block  w-full rounded-md border border-gray-300">
            <option value="">{{ __('Select router') }}</option>
            @foreach ($routers as $router)
                <option value="{{ $router->id }}">{{ $router->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex-1">
        <x-input-label for="package_name" :value="__('Select package')" ></x-input-label>
        <select name="package_name" id="package_name" class="mt-1 block w-full rounded-md border border-gray-300">
            <option value="">{{ __('Select package') }}</option>
            @foreach ($packages as $package)
                <option value="{{ $package->id }}">{{ $package->name }}</option>
            @endforeach
        </select>
    </div>
</div>
