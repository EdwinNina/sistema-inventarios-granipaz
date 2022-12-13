<div>
    <button type="submit"
        wire:click.prevent="agregarProductoModal()"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"
    >Agregar Producto</button>

    <x-modal modalToggle="{{$modalToggle}}">
        <x-slot name="titulo">Listado de Productos</x-slot>
        <x-slot name="cuerpo">
            <div class="overflow-x-auto relative sm:rounded-lg">
                <div class="flex justify-end items-center">
                    <x-buscador criterio="Buscar por nombre" />
                </div>
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">Nombre</th>
                            <th scope="col" class="py-3 px-6">P.U.</th>
                            <th scope="col" class="py-3 px-6">Stock</th>
                            <th scope="col" class="py-3 px-6">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th class="py-4 px-6">{{ $producto->nombre }}</th>
                                <td class="py-4 px-6">{{ $producto->precio_unitario }}</td>
                                <td class="py-4 px-6 font-bold {{ $producto->stock > $stock_minimo ? 'text-green-500' : 'text-red-500' }}">{{ $producto->stock }}</td>
                                <td class="py-4 px-6">
                                    <button type="button" class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="productoCarrito({{ $producto }})" title="Agregar al carrito">
                                        @include('components/icons/shop')
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="w-full p-4">
                    {{ $productos->links() }}
                </div>
            </div>
        </x-slot>
        <x-slot name="footer"></x-slot>
    </x-modal>
</div>
