<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Ticket ID #') . $ticket->number }}
                        </h2>

                    </div>



                    <div>


                        @if($ticket->status == "Open")

                        <form action="{{ route('assign.ticket', ['ticket' => $ticket->id]) }}" method="post">
                                @csrf

                                <x-text-input name="ticket_id" type="hidden" value="{{ $ticket->id }}"></x-text-input>
                                <div>
                                    <x-input-label for="user_type" :value="__('User Type ')" class="mt-4" />
                                    <select id="user_type" name="user_type" class="mt-1 block w-1/2 bg-gray-100 select2" required onchange="toggleRefCode()">
                                        <option value="">Select User</option>
                                        @foreach($userLimits as $limit)
                                            <option value="{{ $limit->user->id  }}">{{ $limit->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="flex items-center gap-4 mt-4">
                                    <x-success-button>{{ __('Assign') }}</x-success-button>
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
