<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight border-b-2 border-slate-100 pb-4">
                        {{ __('Create Payment') }}
                    </h2>

                    <form method="post" action="{{ route('paybill.due_update') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            <div>

                            </div>
     
                                <div>
                                    <x-input-label for="no_day" :value="__(key: 'Set number of days for Billing Date')" class="mt-4" />
                                    <x-text-input id="no_day" name="no_day" type="number"
                                        class="mt-1 block w-full bg-gray-100"
                                         aria-required="" />
                                </div>
                              
                               


                                <div class="flex items-center gap-4 mt-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
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
