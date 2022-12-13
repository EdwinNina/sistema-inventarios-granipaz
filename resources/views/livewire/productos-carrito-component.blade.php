<div>
    <h3 class="font-bold text-blue-500 my-4">Productos Seleccionados</h3>
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        @if (count($productos))
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">Nombre</th>
                        <th scope="col" class="py-3 px-6">Detalle</th>
                        <th scope="col" class="py-3 px-6 text-center">Cantidad Mts</th>
                        <th scope="col" class="py-3 px-6">Stock</th>
                        <th scope="col" class="py-3 px-6">Medida</th>
                        <th scope="col" class="py-3 px-6">Precio Uni</th>
                        <th scope="col" class="py-3 px-6">Subtotal</th>
                        <th scope="col" class="py-3 px-6">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <input type="hidden" name="productos[{{ $producto['id'] }}][producto_id]" value="{{ $producto['id'] }}">
                            <td class="py-4 px-6 font-semibold text-gray-900 text-xs">{{ $producto['nombre'] }}</td>
                            <td class="py-4 px-6 text-xs">{{ $producto['descripcion'] }}</td>
                            <td class="py-4 px-6">
                                <input type="text" class="input input-bordered w-full"
                                    value="{{ $producto['cantidad'] }}" name="productos[{{ $producto['id'] }}][cantidad]"
                                    wire:keydown.enter.prevent="aumentarCantidadManual({{ $producto['id'] }}, $event.target.value)"
                                    wire:keydown.debounce.150ms="aumentarCantidadManual({{ $producto['id'] }}, $event.target.value)"
                                >
                            </td>
                            <td class="py-4 px-6 font-semibold text-gray-900">{{ $producto['stock'] }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-900">
                                <input type="text" class="input input-bordered w-full" name="productos[{{ $producto['id'] }}][medida]" value="{{ $producto['medida'] }}">
                            </td>
                            <td class="py-4 px-6 font-semibold text-gray-900">{{ $producto['precio'] }}
                                <input type="hidden" name="productos[{{ $producto['id'] }}][precio]" value="{{ $producto['precio'] }}">
                            </td>
                            <td class="py-4 px-6 font-semibold text-gray-900">{{ $producto['subtotal'] }}</td>
                            <td class="py-4 px-6">
                                <button class="w-9 h-9 rounded-full flex justify-center items-center bg-red-500" wire:click.prevent="quitarProducto({{ $producto['id'] }})">
                                    @include('components/icons/delete')
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-semibold text-gray-900">
                        <th scope="row" class="py-3 px-6 text-base" colspan="6">Total</th>
                        <td class="py-3 px-6">{{ $total }} Bs</td>
                    </tr>
                </tfoot>
            </table>
        @else
            @error('productos')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500 flex justify-center">{{ $message }}</p>
            @else
                <span class="text-red-500 flex justify-center text-sm">Aún no seleccionaste ningun producto</span>
            @enderror
        @endif
    </div>
</div>
