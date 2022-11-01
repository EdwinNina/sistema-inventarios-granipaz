<div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">LISTADO DE VENTAS</h2>
        <a href="{{ route('ventas.create') }}"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 focus:outline-none">Nueva Venta</a>
    </header>

    <div class="pr-3 flex justify-end mt-3">
        <x-buscador criterio="Buscar por cliente" />
    </div>

    @include('pages/ventas/detalle-ventas')

    <div class="p-3">
        <div class="mt-6 lg:mt-0 rounded shadow">
            <table class="w-full text-sm text-left">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">Codigo</th>
                        <th scope="col" class="py-3 px-6">Tipo Comprobante</th>
                        <th scope="col" class="py-3 px-6">Nro Comprobante</th>
                        <th scope="col" class="py-3 px-6">Fecha</th>
                        <th scope="col" class="py-3 px-6">Proveedor</th>
                        <th scope="col" class="py-3 px-6">Cantidad Mts</th>
                        <th scope="col" class="py-3 px-6">Total (Bs)</th>
                        <th scope="col" class="py-3 px-6">Estado</th>
                        <th scope="col" class="py-3 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6">{{ $venta->codigo }}</td>
                            <td class="py-4 px-6">{{ $venta->tipo_comprobante }}</td>
                            <td class="py-4 px-6">{{ $venta->nro_comprobante }}</td>
                            <td class="py-4 px-6">{{  \Carbon\Carbon::parse($venta->fecha)->format('d-m-Y') }}</td>
                            <td class="py-4 px-6">{{ Str::title($venta->empresa) }}</td>
                            <td class="py-4 px-6">{{ $venta->cantidad }}</td>
                            <td class="py-4 px-6">{{ $venta->total }}</td>
                            <td class="py-4 px-6">
                                <span class="py-2 px-3 text-white rounded-3xl {{ $venta->estado ? 'bg-green-500' : 'bg-red-500' }}">{{ $venta->estado ? 'Realizado' : 'Anulado' }}</span>
                            </td>
                            <td class="py-4 px-6 flex justify-center items-center">
                                <div class="flex justify-start gap-3">
                                    <button type="button" title="Productos de la Venta"
                                        class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="mostrarProductos({{ $venta->id }})">
                                        @include('components/icons/shop')
                                    </button>
                                    <a href="{{ route('ventas.edit', $venta->id )}}" title="Editar la Venta"
                                        class="bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center">
                                        @include('components/icons/edit')
                                    </a>
                                    <form action="{{ route('reporte.venta-individual') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="venta_id" value="{{ $venta->id }}">
                                        <button type="submit" title="Imprimir reporte de venta"
                                            class="bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center">
                                            @include('components/icons/print')
                                        </button>
                                    </form>
                                    @if ($venta->estado)
                                        <button type="button" title="Anular la Venta"
                                            class="bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                            wire:click="cambiarEstadoVenta({{ $venta->id }}, 'anularVenta')">
                                            @include('components/icons/cancel')
                                        </button>
                                    @else
                                        <button type="button" title="Habilitar Venta"
                                            class="bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                            wire:click="cambiarEstadoVenta({{ $venta->id }}, 'habilitarVenta')">
                                            @include('components/icons/enable-purchase')
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">
                {{ $ventas->links() }}
            </div>
        </div>
    </div>
</div>


