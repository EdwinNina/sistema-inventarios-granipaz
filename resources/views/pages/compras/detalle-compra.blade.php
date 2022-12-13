<x-modal modalToggle="{{$modalToggle}}">
    <x-slot name="titulo">Productos Adquiridos</x-slot>
    <x-slot name="cuerpo">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">Nombre</th>
                    <th scope="col" class="py-3 px-6">Detalle</th>
                    <th scope="col" class="py-3 px-6">Precio Unitario (Bs)</th>
                    <th scope="col" class="py-3 px-6">Cantidad</th>
                    <th scope="col" class="py-3 px-6">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @if (count($productos))
                    @foreach ($productos as $producto)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $producto->nombre }}</th>
                            <td class="py-4 px-6">{{ $producto->descripcion }}</td>
                            <td class="py-4 px-6">{{ $producto->precio_unitario }}</td>
                            <td class="py-4 px-6">{{ $producto->cantidad }}</td>
                            <td class="py-4 px-6">{{ $producto->subtotal }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </x-slot>
    <x-slot name="footer"></x-slot>
</x-modal>
