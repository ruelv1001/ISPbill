<x-app-layout>
    
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Pay Bill') }}
                        </h2>

                        <a href="{{ route('paybill.due') }}"
                                    class="ml-2 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white rounded uppercase">
                                    {{ __('Set Billing Date') }}
                                </a>
                    </div>
                    <div>
                        <livewire:pay-bill-table />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')