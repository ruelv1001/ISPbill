<x-app-layout>
    <div style="padding: 24px;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 16px;">
            <div style="background: white; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 8px;">
                <div style="padding: 24px; color: #1a202c;">
                    <h2 style="font-weight: 600; font-size: 1.25rem; color: #2d3748; margin-bottom: 32px; border-bottom: 2px solid #e2e8f0; padding-bottom: 16px;">
                        {{ __('Dashboard') }}
                    </h2>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 24px; margin-bottom: 24px;">
                        @foreach ([['Total Bills', $totalBills], ['Total Payments', $totalPayments], ['Bills This Month', $billsThisMonth], ['Payments This Month', $paymentsThisMonth]] as [$label, $amount])
                        <div style="border: 1px solid #e2e8f0; padding: 16px; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <p style="font-size: 1.5rem; margin-top: 8px; font-weight: bold;">{{ config('app.currency') . $amount }}</p>
                            <h2 style="font-size: 1rem;">{{ __($label) }}</h2>
                        </div>
                        @endforeach
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                        <div>
                            <h3 style="margin-top: 24px; margin-bottom: 24px; font-weight: 600;">{{ __('Billing and payment per month') }}</h3>
                            <canvas id="monthlyChart"></canvas>
                        </div>
                        <div>
                            <h3 style="margin-top: 24px; margin-bottom: 24px; font-weight: 600;">{{ __('Billing and payment per day') }}</h3>
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            const billingData = @json($billingData);
            const paymentData = @json($paymentData);
            const labels = Array.from({ length: billingData.length }, (_, i) => (i + 1).toString());

            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Monthly Billing Amount',
                            data: billingData,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Monthly Payment Amount',
                            data: paymentData,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const dailyBillingData = @json($dailyBillingData);
            const dailyPaymentData = @json($dailyPaymentData);
            const dailyLabels = Array.from({ length: dailyBillingData.length }, (_, i) => (i + 1).toString());

            const dailyCtx = document.getElementById('dailyChart').getContext('2d');
            new Chart(dailyCtx, {
                type: 'bar',
                data: {
                    labels: dailyLabels,
                    datasets: [
                        {
                            label: 'Daily Billing Amount',
                            data: dailyBillingData,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Daily Payment Amount',
                            data: dailyPaymentData,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>

