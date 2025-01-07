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

                            <form action="{{ route('add.comment') }}" method="post">
                                @csrf

                                <x-text-input name="ticket_id" type="hidden" value="{{ $ticket->id }}"></x-text-input>
                                    <div>
                                        <x-input-label for="user_type" :value="__('Payment Method')" class="mt-4" />
                                        <select id="user_type" name="user_type" class="mt-1 block w-1/2 bg-gray-100" required onchange="toggleRefCode()">
                                            <option value="">Select a payment method</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Gcash">Gcash</option>
                                            <option value="Maya">Maya</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                <div>
                                    <x-input-label for="asssign_id" :value="__('Payment Method')" class="mt-4" />
                                    <select id="asssign_id" name="asssign_id" class="mt-1 block w-1/2 bg-gray-100"
                                        required onchange="toggleRefCode()">
                                        <option value="">Select a payment method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Gcash">Gcash</option>
                                        <option value="Maya">Maya</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-4 mt-4">
                                    <x-success-button>{{ __('Submit') }}</x-success-button>
                                </div>
                            </form>

                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
