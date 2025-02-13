<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 24px; color: #1f2937;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 2px solid #e5e7eb; padding-bottom: 16px;">
                        <h2 style="font-weight: 600; font-size: 20px; color: #374151; line-height: 1.25;">
                            {{ __('Ticket ID #') . $ticket->number }}
                        </h2>
                    </div>

                    <div>
                        @if($ticket->status == "Open")
                            <form action="{{ route('assign.ticket', ['ticket' => $ticket->id]) }}" method="post">
                                @csrf

                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                <div>
                                    <label for="user_type" style="font-weight: 500; color: #374151; display: block; margin-top: 16px;">{{ __('User Type ') }}</label>
                                    <select id="user_type" name="user_type" style="margin-top: 4px; width: 50%; padding: 8px; border-radius: 8px; border: 1px solid #d1d5db;" required onchange="toggleRefCode()">
                                        <option value="">Select User</option>
                                        @foreach($userLimits as $limit)
                                            <option value="{{ $limit->user->id  }}">{{ $limit->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div style="display: flex; align-items: center; gap: 16px; margin-top: 16px;">
                                    <button type="submit" style="padding: 8px 16px; background-color: #4b5563; color: white; border-radius: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">
                                        {{ __('Assign') }}
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select a User",
            allowClear: true
        });
    });
</script>
