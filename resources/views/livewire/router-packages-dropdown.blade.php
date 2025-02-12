<div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
    <div style="flex: 1;">
        <label for="router_name" style="display: block; margin-top: 12px; font-weight: bold;">
            {{ __('Select router') }}
        </label>
        <select wire:model="routerId" name="router_name" id="router_name"
            style="margin-top: 4px; display: block; width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
            <option value="">{{ __('Select router') }}</option>
            @foreach ($routers as $router)
                <option value="{{ $router->id }}">{{ $router->name }}</option>
            @endforeach
        </select>
    </div>

    <div style="flex: 1;">
        <label for="package_name" style="display: block; font-weight: bold;">
            {{ __('Select package') }}
        </label>
        <select name="package_name" id="package_name"
            style="margin-top: 4px; display: block; width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
            <option value="">{{ __('Select package') }}</option>
            @foreach ($packages as $package)
                <option value="{{ $package->id }}">{{ $package->name }}</option>
            @endforeach
        </select>
    </div>
</div>
