<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-4 sm:p-8">
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
                        {{ __('Modify Transaction') }}
                    </h2>

                    <form method="post" action="{{ route('transaction.update', $transaction->id) }}"
                        class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Transaction') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Modify Transaction") }}
                                </p>
                            </div>

                            <div>

                                <div>
                                    <x-input-label for="user_id" :value="__('User ID')" class="mt-4"
                                        disabled></x-input-label>
                                    <x-text-input id="user_id" name="user_id" type="text" readonly
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $user->detail->user_id ?? '' }}"></x-text-input>
                                </div>
                                <div>
                                    <x-input-label for="first_name" :value="__('User First name')" class="mt-4"
                                        disabled></x-input-label>
                                    <x-text-input id="first_name" name="first_name" type="text" readonly
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $user->detail->first_name ?? '' }}"></x-text-input>
                                </div>

                                <div>
                                    <x-input-label for="last_name" :value="__('User Last name')" class="mt-4"
                                        disabled></x-input-label>
                                    <x-text-input id="last_name" name="last_name" type="text" readonly
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $user->detail->last_name ?? '' }}"></x-text-input>
                                </div>

                                <div>
                                    <x-input-label for="payment_amount" :value="__('User Payment amount')" class="mt-4"
                                        disabled></x-input-label>
                                    <x-text-input id="payment_amount" name="payment_amount" type="text"
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $transaction->payment_amount ?? '' }}"></x-text-input>
                                </div>

                                <div>
                                    <x-input-label for="payment_date" :value="__('User Payment Date')" class="mt-4"
                                        disabled></x-input-label>
                                    <x-text-input id="payment_date" name="payment_date" type="text"
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $transaction->payment_date ?? '' }}"></x-text-input>
                                </div>

                                <div>
                                    <x-input-label for="remarks" :value="__('Remarks')" class="mt-4"
                                        disabled></x-input-label>
                                    <x-text-input id="remarks" name="remarks" type="text"
                                        class="mt-1 block w-full bg-gray-100"
                                        value="{{ $transaction->remarks ?? '' }}"></x-text-input>
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
</x-app-layout>
