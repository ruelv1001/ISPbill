

<div class="flex flex-col space-y-4">
    <span>UP Time: {{ $row->uptime ?? 'N/A' }}</span>
    <span>Down Time: {{ $row->downtime ?? 'N/A' }}</span>
    <span>Router Name: {{ $row->router_name ?? 'N/A' }}</span>
    <span>IP Address: {{ $row->router_ip ?? 'N/A' }}</span>
</div>
