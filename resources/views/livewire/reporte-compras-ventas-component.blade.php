<div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200 px-5 py-4">
    <header class="border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">REPORTE DE {{ $tipo }}</h2>
    </header>
    <section class="flex flex-col sm:flex-row sm:justify-between sm:items-end my-7">
        <div class="flex mt-3 sm:mt-0 items-end flex-wrap gap-5 justify-end">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Fecha Inicio</label>
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        @include('components/icons/date')
                    </div>
                    <input type="date"
                        class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        wire:model.defer="fecha_ini">
                </div>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Fecha Fin</label>
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        @include('components/icons/date')
                    </div>
                    <input type="date"
                        class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        wire:model.defer="fecha_fin">
                </div>
            </div>
            <button type="button"
                class="bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg w-10 h-10 text-sm focus:outline-none flex justify-center items-center"
                wire:click.prevent="listarVentasPorFecha()">
            @include('components/icons/search')</button>
        </div>
    </section>
    <section class="lg:mt-0 rounded shadow">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6 w-36">Fecha</th>
                    <th scope="col" class="py-3 px-6">Producto</th>
                    <th scope="col" class="py-3 px-6">Detalle</th>
                    <th scope="col" class="py-3 px-6">Cantidad Mts Total</th>
                    @if ($tipo === 'VENTA')
                        <th scope="col" class="py-3 px-6">Medida</th>
                    @endif
                    <th scope="col" class="py-3 px-6">Precio</th>
                    <th scope="col" class="py-3 px-6">Total(Bs)</th>
                </tr>
            </thead>
            <tbody>
                @if (count($datos) > 0)
                    @foreach ($datos as $dato)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6 text-sm font-bold w-36">{{ $dato->fecha }}</td>
                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ Str::title($dato->nombre) }}</td>
                            <td class="py-4 px-6 text-sm">{{ $dato->descripcion }}</td>
                            <td class="py-4 px-6 text-sm font-bold">{{ $dato->cantidad }}</td>
                            @if ($tipo === 'VENTA')
                                <td class="py-4 px-6">{{ $dato->medida ?? '----' }}</td>
                            @endif
                            <td class="py-4 px-6">{{ $dato->precio }}</td>
                            <td class="py-4 px-6 font-bold text-gray-900">{{ $dato->total }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center py-3 px-3 font-bold">No existen datos con la fecha de inicio {{ $fecha_ini }} y de fin {{ $fecha_fin }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </section>
</div>
