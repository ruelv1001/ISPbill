<x-app-layout>
    <div style="padding: 24px 0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 24px;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px;">
                <div style="padding: 24px; color: #1f2937;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 2px solid #e5e7eb; padding-bottom: 16px;">
                        <h2 style="font-size: 20px; font-weight: 600; color: #374151; line-height: 1.25;">
                            {{ __('Tickets') }}
                        </h2>
                        @if (auth()->user()->isUser())
                            <a href="{{ route('ticket.create') }}" style="padding: 8px 16px; background-color: #4b5563; color: white; border-radius: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase; text-align: center; display: inline-block;">
                                {{ __('Create Ticket') }}
                            </a>
                        @endif
                    </div>
                    <div>
                    <section>
                            @php
                                $headers = [
                                    'name' => 'name',
                                    'subject' => 'Subject',
                                    'action' => 'Action'
                                ];
                                $dropdownActions = [];
                                $dltAllbtn = [];
                                $tableActions = ['edit' => 'port.edit', 'delete-item' => 'port.destroy'];
                                $addButton = ['Add Ticket', 'ticket.create'];

                                $customMessage = [
                                    'success' => '',
                                    'delete' => 'This User will be permanently deleted if you proceed.',
                                ];
                            @endphp
                            <x-table :headers="$headers" :data="$data" title="Port" :dropdown="$dropdownActions"
                                :actions="$tableActions" tablename="Port" :addbtn="$addButton"
                                :searchField="false" :dltAllbtn="$dltAllbtn" itemName="Area" :message="$customMessage" />
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
