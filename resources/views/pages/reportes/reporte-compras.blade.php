<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="grid grid-cols-12 gap-6">
            @livewire('reporte-compras-ventas-component', ['tipo' => 'COMPRAS'])
        </div>
    </div>
</x-app-layout>
