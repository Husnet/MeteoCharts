<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ $device->name . ' ' . __('Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6">
                    @isset($device->logs)
                        @foreach($device->logs->sortByDesc('created_at') as $log)
                            <x-device-log-card :log="$log" />
                        @endforeach
                    @else
                        {{ __('No logs found for this device.') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

