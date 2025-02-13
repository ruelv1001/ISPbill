<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 24px;">
                    @if(session('error'))
                        <div style="color: #f44336; padding: 12px; background-color: #f8d7da; border-radius: 4px; font-size: 14px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 style="font-weight: 600; font-size: 20px; color: #374151; line-height: 1.25; border-bottom: 2px solid #e5e7eb; padding-bottom: 16px;">
                        {{ __('Create Ticket') }}
                    </h2>

                    <form method="post" action="{{ route('ticket.store') }}" style="margin-top: 24px;">
                        @csrf

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <h2 style="font-size: 18px; font-weight: 500; color: #374151;">{{ __('Ticket') }}</h2>
                                <p style="margin-top: 4px; font-size: 14px; color: #6b7280;">
                                    {{ __("Create a new ticket") }}
                                </p>
                            </div>

                            <div>
                                <div>
                                    <label for="subject" style="font-weight: 500; color: #374151; display: block; margin-top: 8px;">{{ __('Subject') }}</label>
                                    <input id="subject" name="subject" type="text" style="margin-top: 4px; width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #d1d5db;" value="{{ old('subject') }}" required>
                                    <div style="color: #f44336; margin-top: 8px;">
                                        @error('subject') {{ $message }} @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="message" style="font-weight: 500; color: #374151; display: block; margin-top: 16px;">{{ __('Message') }}</label>
                                    <textarea name="message" style="padding: 12px; width: 100%; border-radius: 8px; border: 1px solid #d1d5db;" rows="5"></textarea>
                                    <div style="color: #f44336; margin-top: 8px;">
                                        @error('message') {{ $message }} @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="priority" style="font-weight: 500; color: #374151; display: block; margin-top: 16px;">{{ __('Priority') }}</label>
                                    <select name="priority" id="priority" style="margin-top: 4px; width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #d1d5db;">
                                        <option value="High">{{ __('High') }}</option>
                                        <option value="Normal">{{ __('Normal') }}</option>
                                        <option value="Low">{{ __('Low') }}</option>
                                    </select>
                                </div>

                                <div style="display: flex; align-items: center; gap: 16px; margin-top: 24px;">
                                    <button type="submit" style="padding: 8px 16px; background-color: #4b5563; color: white; border-radius: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')