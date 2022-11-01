<div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">LISTADO DE PRODUCTOS</h2>
        <div class="flex">
            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none"
                wire:click="abrirModal()">Crear producto
            </button>
            <a href="{{ route('reporte.productos') }}" target="_blank"
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 focus:outline-none flex justify-center"
            >
                @include('components/icons/print') <span class="ml-2">Imprimir Reporte</span>
            </a>
        </div>
    </header>

    @include('pages.productos.form-modal')
    @include('pages.productos.detalle')

    <div class="px-3 flex justify-between mt-3">
        <section>
            <select class="select select-bordered py-0" wire:change="filtrarSubCategoria($event.target.value)">
                <option value="">Filtrar por categoria</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
            <select class="select select-bordered py-0" wire:model="filtrarSubCategoria">
                <option value="">Filtrar por SubCategoria</option>
                @foreach ($a_subcategorias as $subcategoria)
                    <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                @endforeach
            </select>
        </section>
        <x-buscador criterio="Buscar por Nombre o Categoria" />
    </div>

    <div class="p-3">
        <div class="overflow-x-auto mt-6 lg:mt-0 rounded shadow">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">Nombre</th>
                            <th scope="col" class="py-3 px-6">Precio Uni (Bs)</th>
                            <th scope="col" class="py-3 px-6">Stock</th>
                            <th scope="col" class="py-3 px-6">SubCategoria</th>
                            <th scope="col" class="py-3 px-6">Estado</th>
                            <th scope="col" class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ Str::title($producto->nombre) }}</th>
                                <td class="py-4 px-6">{{ $producto->precio_unitario }}</td>
                                <td class="py-4 px-6">
                                    <span class="w-9 h-9 text-xs rounded-full flex justify-center items-center font-bold text-white
                                        {{ $producto->stock > $stock_minimo ? 'bg-green-500' : 'bg-red-500' }}">{{ $producto->stock }}</span>
                                </td>
                                <td class="py-4 px-6">{{ $producto->sub_categoria }}</td>
                                <td class="py-4 px-6">
                                    <span class="py-2 px-3 text-white rounded-3xl {{ $producto->estado ? 'bg-green-500' : 'bg-red-500' }}">{{ $producto->estado ? 'Activo' : 'Inactivo' }}</span>
                                </td>
                                <td class="py-4 px-6 flex justify-center items-center gap-3">
                                    <button type="button"
                                        class="bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="editar({{ $producto->id }})"
                                        title="Editar Producto">
                                        @include('components/icons/edit')
                                    </button>
                                    <button type="button" class="bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="mostrarProducto({{ $producto->id }})"
                                        title="Mostrar detalle producto">
                                            @include('components/icons/category')
                                    </button>
                                    <button type="button"
                                        class="bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:ring-teal-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="actualizarEstado({{ $producto->id }})"
                                        title="Habilitar/Deshabilitar Producto">
                                        @if ($producto->estado)
                                            @include('components/icons/enable')
                                        @else
                                            @include('components/icons/disable')
                                        @endif
                                    </button>
                                    <button type="button" title="Eliminar Producto"
                                        class="bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="eliminarCategoria({{ $producto->id }})">
                                        @include('components/icons/delete')
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-4 py-3">
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>


