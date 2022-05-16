<x-student-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('RFQ List') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            Accessible only for Clients.
            <?php include resource_path() . '/views/client/rfq/jotform/jotform-rfq.html'; ?>
        </div>
    </div>
</x-student-layout>
