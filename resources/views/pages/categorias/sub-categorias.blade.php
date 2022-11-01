<div class="modal modal-bottom sm:modal-middle {{ $modalToggleSubProductos ? 'modal-open' : 'modal-close' }}">
    <div class="modal-box relative w-11/12 max-w-5xl">
        <button class="btn btn-sm btn-circle absolute right-2 top-2 {{ !$modalToggleSubProductos && 'modal-close' }}" wire:click="cerrarModalSubCategorias()">✕</button>
        <h3 class="text-center font-bold">Sub Categorias</h3>
        <div class="divider"></div>

        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">Nombre</th>
                    <th scope="col" class="py-3 px-6">Descripcion</th>
                </tr>
            </thead>
            <tbody>
                @if (count($subcategorias))
                    @foreach ($subcategorias as $subcategoria)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $subcategoria->nombre }}</th>
                            <td class="py-4 px-6">{{ $subcategoria->descripcion }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
