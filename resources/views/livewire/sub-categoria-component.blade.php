<div class="overflow-x-auto mt-6 lg:mt-0">
    <div class="flex justify-end mt-6">
        <button wire:click.prevent="agregarSubcategoria()"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">Agregar SubCategoria</button>
    </div>
    @if (count($a_subcategorias))
        <h3 class="font-bold text-gray-500 mb-4">Datos de la subcategoria</h3>
        <div class="overflow-x-auto relative shadow-xl border sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">Nombre</th>
                        <th scope="col" class="py-3 px-6">Descripcion</th>
                        <th scope="col" class="py-3 px-6"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($a_subcategorias as $index => $value)
                        <tr>
                            <td class="py-4 px-6">
                                <input type="hidden" name="sub_categorias[{{$index}}][id]" value="{{ $value['id'] ?? '' }}">
                                <input type="text" placeholder="Nombre de la sub categoria" class="input input-bordered w-full" name="sub_categorias[{{$index}}][nombre]" value="{{ $value['nombre'] ?? '' }}"/>
                            </td>
                            <td class="py-4 px-6">
                                <input type="text" placeholder="Descripcion de la sub categoria" class="input input-bordered w-full" name="sub_categorias[{{$index}}][descripcion]" value="{{ $value['descripcion'] ?? '' }}"/>
                            </td>
                            <td>
                                <button type="button" class="bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                    wire:click="eliminarSubcategoria({{ $index }})"
                                    title="Eliminar Fila">
                                        @include('components/icons/delete')
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
