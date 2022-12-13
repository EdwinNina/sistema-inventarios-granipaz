<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        @if (session('estado'))
            <div class=" border-l-4 px-5 py-2 rounded mb-3 text-center
                {{session('estado') === 'exito' ? 'bg-green-500 border-green-600' : 'bg-red-500 border-red-600'}}">
                <span class="text-white text-center">
                    {{ session('estado') === 'exito'
                        ? session('mensajeExito')
                        : session('mensajeError')
                    }}
                </span>
            </div>
        @endif
        <div class="grid grid-cols-12 gap-6">
            @livewire('role-component')
        </div>
    </div>
</x-app-layout>
