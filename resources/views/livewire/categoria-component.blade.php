<div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">LISTADO DE CATEGORIAS</h2>
        <a href="{{ route('categorias.create') }}"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">Crear Categoria</a>
    </header>

    @include('pages.categorias.sub-categorias')

    <div class="p-3">
        <div class="overflow-x-auto mt-6 lg:mt-0 rounded shadow">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">Nombre</th>
                            <th scope="col" class="py-3 px-6">Descripcion</th>
                            <th scope="col" class="py-3 px-6">Estado</th>
                            <th scope="col" class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ Str::title($categoria->nombre) }}</th>
                                <td class="py-4 px-6">{{ Str::title($categoria->descripcion) }}</td>
                                <td class="py-4 px-6">
                                    <span class="py-2 px-3 text-white rounded-3xl {{ $categoria->estado ? 'bg-green-500' : 'bg-red-500' }}">{{ $categoria->estado ? 'Activo' : 'Inactivo' }}</span>
                                </td>
                                <td class="py-4 px-6 flex justify-center gap-3">
                                    <a href="{{ route('categorias.edit', $categoria->id) }}"
                                        class="bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        title="Editar Categoria">
                                        @include('components/icons/edit')
                                    </a>
                                    <button type="button" class="bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:ring-teal-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="actualizarEstado({{ $categoria->id }})"
                                        title="Habilitar/Deshabilitar Categoria">
                                        @if ($categoria->estado)
                                            @include('components/icons/enable')
                                        @else
                                            @include('components/icons/disable')
                                        @endif
                                    </button>
                                    <button type="button" class="bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="mostrarSubCategorias({{ $categoria->id }})"
                                        title="Mostrar Sub Categorias">
                                            @include('components/icons/category')
                                    </button>
                                    <button type="button" class="bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="eliminarCategoria({{ $categoria->id }})"
                                        title="Eliminar Categoria">
                                            @include('components/icons/delete')
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-4 py-3">
                    {{ $categorias->links() }}
                </div>
            </div>
        </div>
    </div>
</div>


