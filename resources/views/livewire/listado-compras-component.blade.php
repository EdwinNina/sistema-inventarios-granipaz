<div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">LISTADO DE COMPRAS</h2>
        <a href="{{ route('compras.create') }}"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 focus:outline-none">Nueva Compra</a>
    </header>

    <div class="pr-3 flex justify-end mt-3">
        <x-buscador criterio="Buscar por proveedor" />
    </div>

    @include('pages/compras/detalle-compra')

    <div class="p-3">
        <div class="mt-6 lg:mt-0 rounded shadow">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">Codigo</th>
                        <th scope="col" class="py-3 px-6">Fecha</th>
                        <th scope="col" class="py-3 px-6">Proveedor</th>
                        <th scope="col" class="py-3 px-6">Cantidad</th>
                        <th scope="col" class="py-3 px-6">Total (Bs)</th>
                        <th scope="col" class="py-3 px-6">Estado</th>
                        <th scope="col" class="py-3 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-4 px-6">{{ $compra->codigo }}</td>
                            <td class="py-4 px-6">{{  \Carbon\Carbon::parse($compra->fecha)->format('d-m-Y') }}</td>
                            <td class="py-4 px-6">{{ Str::title($compra->empresa) }}</td>
                            <td class="py-4 px-6">{{ $compra->cantidad }}</td>
                            <td class="py-4 px-6">{{ $compra->total }}</td>
                            <td class="py-4 px-6">
                                <span class="py-2 px-3 text-white rounded-3xl {{ $compra->estado ? 'bg-green-500' : 'bg-red-500' }}">{{ $compra->estado ? 'Realizada' : 'Anulado' }}</span>
                            </td>
                            <td class="py-4 px-6 flex justify-center items-center">
                                <div class="flex justify-start gap-3">
                                    <button type="button" title="Productos de la Compra"
                                        class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="mostrarProductos({{ $compra->id }})">
                                        @include('components/icons/shop')
                                    </button>
                                    <a href="{{ route('compras.edit', $compra->id )}}" title="Editar la Compra"
                                        class="bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center">
                                        @include('components/icons/edit')
                                    </a>
                                    <form action="{{ route('reporte.compra-individual') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="compra_id" value="{{ $compra->id }}">
                                        <button type="submit" title="Imprimir reporte de compra"
                                            class="bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center">
                                            @include('components/icons/print')
                                        </button>
                                    </form>
                                    @if ($check_user_role)
                                        @if ($compra->estado)
                                            <button type="button" title="Anular la Compra"
                                                class="bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                                wire:click="cambiarEstadoCompra({{ $compra->id }}, 'anularCompra')">
                                                @include('components/icons/cancel')
                                            </button>
                                        @else
                                            <button type="button" title="Habilitar Compra"
                                                class="bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                                wire:click="cambiarEstadoCompra({{ $compra->id }}, 'habilitarCompra')">
                                                @include('components/icons/enable-purchase')
                                            </button>
                                        @endif
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">
                {{ $compras->links() }}
            </div>
        </div>
    </div>
</div>


