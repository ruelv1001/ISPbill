<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="alert alert-success text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Customer') }}
                        </h2>
                        <div class="flex items-center  ">
                            @if (auth()->user()->isAdmin())
                                <form action="{{ route('due.user.disable') }}" method="post" class="hidden">
                                    @csrf
                                    <x-danger-button>{{ __('Disable all Customer with due') }}</x-danger-button>
                                </form>
                                <a href="{{ route('user.download') }}"
                                    class="ml-2 inline-flex items-center px-4 py-2 bg-orange-400 text-white dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs rounded uppercase">
                                    {{ __('Download') }}
                                </a>

                        
                                <a href="{{ route('users.create') }}"
                                    class="ml-2 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
                                    {{ __('Create') }}
                                </a>


                                <a href="{{ route('archieve-users.index') }}"
                                    class="ml-2 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
                                    {{ __('Archive') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <div>
                        <livewire:user-table />

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('sweetalert::alert')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script>
    window.addEventListener('updatePaginationUrl', function (event) {
        const url = new URL(window.location);
        url.searchParams.set('page', event.detail.page);
        history.pushState(null, '', url);
    });

    window.addEventListener('reloadPage', function () {

        location.reload();
    });
</script>
