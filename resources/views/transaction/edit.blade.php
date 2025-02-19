<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 16px 32px;">
                    <x-slot name="header">
                        <h2
                            style="font-size: 20px; font-weight: 600; color: #374151; padding-bottom: 16px; border-bottom: 2px solid #d1d5db;">
                            {{ $user->name }}
                        </h2>
                    </x-slot>
                    @if(session('error'))
                        <div style="color: red; font-size: 14px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2
                        style="font-size: 20px; font-weight: 600; color: #374151; border-bottom: 2px solid #d1d5db; padding-bottom: 16px;">
                        {{ __('View Transaction') }}
                    </h2>

                    <form method="post" action="{{ route('transaction.update', $transaction->id) }}"
                        style="margin-top: 24px; padding-bottom: 24px;">
                        @csrf
                        @method('patch')

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <h2 style="font-size: 18px; font-weight: 500; color: #374151;">{{ __('Transaction') }}
                                </h2>
                                <p style="margin-top: 8px; font-size: 14px; color: #4b5563;">
                                    {{ __('View Transaction') }}</p>
                            </div>

                            <div>
                                <div style="display: none;">
                                    <label for="transaction_id"
                                        style="font-weight: 500; color: #374151;">{{ __('Customer name') }}</label>
                                    <input id="transaction_id" name="transaction_id" type="text"
                                        style="margin-top: 8px; display: block; width: 100%; padding: 8px; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px;"
                                        value="{{ $transaction->id }}">
                                </div>
                                <div>
                                    <label for="user_id"
                                        style="font-weight: 500; color: #374151;">{{ __('User ID') }}</label>
                                    <input id="user_id" name="user_id" type="text" readonly
                                        style="margin-top: 8px; display: block; width: 100%; padding: 8px; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px;"
                                        value="{{ $user->detail->user_id ?? '' }}">
                                </div>
                                <div>
                                    <label for="first_name"
                                        style="font-weight: 500; color: #374151;">{{ __('User Full name') }}</label>
                                    <input id="first_name" name="first_name" type="text" readonly
                                        style="margin-top: 8px; display: block; width: 100%; padding: 8px; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px;"
                                        value="{{ $user->detail->name ?? '' }}">
                                </div>
                                <div>
                                    <label for="payment_amount"
                                        style="font-weight: 500; color: #374151;">{{ __('User Payment amount') }}</label>
                                    <input id="payment_amount" name="payment_amount" type="text" readonly
                                        style="margin-top: 8px; display: block; width: 100%; padding: 8px; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px;"
                                        value="{{ $transaction->payment_amount ?? '' }}">
                                </div>
                                <div>
                                    <label for="payment_date"
                                        style="font-weight: 500; color: #374151;">{{ __('User Payment Date') }}</label>
                                    <input id="payment_date" name="payment_date" type="text" readonly
                                        style="margin-top: 8px; display: block; width: 100%; padding: 8px; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px;"
                                        value="{{ $transaction->payment_date ?? '' }}">
                                </div>
                                <div>
                                    <label for="remarks"
                                        style="font-weight: 500; color: #374151;">{{ __('Remarks') }}</label>
                                    <input id="remarks" name="remarks" type="text" readonly
                                        style="margin-top: 8px; display: block; width: 100%; padding: 8px; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px;"
                                        value="{{ $transaction->remarks ?? '' }}">
                                </div>
                                <div
                                    style="display: flex; align-items: center; gap: 16px; margin-top: 16px; display: none;">
                                    <button type="submit"
                                        style="background-color: #4CAF50; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
                                        {{ __('Update') }}
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
