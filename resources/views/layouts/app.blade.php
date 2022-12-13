<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        @livewireStyles

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- <link rel="stylesheet" href="{{ assets('build/assets/app.26d6963b.css') }}">
        <script src="{{ assets('build/assets/app.1e8afd10.js') }}" defer></script> --}}
    </head>
    <body
        class="font-inter antialiased bg-slate-100 text-slate-600"
        :class="{ 'sidebar-expanded': sidebarExpanded }"
        x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
        x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"
    >

        <script>
            if (localStorage.getItem('sidebar-expanded') == 'true') {
                document.querySelector('body').classList.add('sidebar-expanded');
            } else {
                document.querySelector('body').classList.remove('sidebar-expanded');
            }
        </script>

        <!-- Page wrapper -->
        <div class="flex h-screen overflow-hidden">

            <x-app.sidebar />

            <!-- Content area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden @if($attributes['background']){{ $attributes['background'] }}@endif" x-ref="contentarea">

                <x-app.header />

                <main>
                    {{ $slot }}
                </main>

            </div>

        </div>

        <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        @livewireScripts

        <script>
            window.livewire.on('existe', (mensaje) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: mensaje,
                })
            })

            window.livewire.on('successMessage', value => {
                Livewire.emit('refreshData')
                switch (value) {
                    case 'crear':
                        toastr.success('Correcto', 'Registro agregado correctamente');
                        break;
                    case 'actualizar':
                        toastr.success('Correcto', 'Registro actualizado correctamente');
                    break;
                    case 'eliminar':
                        toastr.success('Correcto', 'Registro eliminado correctamente');
                    break;
                    case 'anulacionCompra':
                        toastr.success('Correcto', 'Se ha anulado la compra correctamente');
                    break;
                    case 'habilitarCompra':
                        toastr.success('Correcto', 'Se ha habilitado nuevamente la compra');
                    break;
                }
            });
        </script>
    </body>
</html>
