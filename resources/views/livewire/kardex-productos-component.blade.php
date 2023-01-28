<div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">KARDEX DE PRODUCTO</h2>
    </header>
    <div class="p-3">
        <div class="px-3 flex mt-3 gap-10">
            <select class="select select-bordered py-0" wire:change="filtrarSubCategoria($event.target.value)">
                <option value="" selected>Filtrar por categoria</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
            <select class="select select-bordered py-0" wire:model.defer="sub_categoria_id">
                <option value="" selected>Seleccione la subcategoria</option>
                @foreach ($a_subcategorias as $subcategoria)
                    <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                @endforeach
            </select>
            <div class="flex-1 relative">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="search" id="default-search"
                        class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Buscar por nombre de productos"
                        wire:model.debounce.500ms="nombre"
                        wire:keydown.escape="resetBusqueda"
                        wire:keydown.tab="resetBusqueda"
                    >
                </div>
                <div wire:loading wire:target="nombre" class="absolute z-10 w-full bg-white rounded-t-none shadow-lg text-sm font-medium text-gray-900 rounded-lg border border-gray-200">
                    <div class="block py-2 px-4 w-full border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:text-blue-700">Searching...</div>
                </div>
                @if(!empty($nombre))
                    <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="resetBusqueda"></div>
                    <div class="absolute z-10 w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200">
                        @if(!empty($productos))
                            @foreach($productos as $i => $value)
                                <div class="block py-2 px-4 w-full border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:text-blue-700" wire:click="seleccionar({{ $value['id'] }})">{{ $value['nombre'] }}</div>
                            @endforeach
                        @else
                            <div class="block py-2 px-4 w-full border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:text-blue-700">No results!</div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="my-4 px-3">
            @if (!empty($productos))
                <div class="flex flex-col sm:flex-row justify-between gap-5">
                    @if (!empty($producto_seleccionado))
                        <section class="p-6 w-96 bg-white rounded-lg border border-gray-200 shadow-md">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $producto_seleccionado['nombre']}}</h5>
                            <p class="mb-3 font-normal text-gray-700">Detalle: {{ $producto_seleccionado['descripcion'] }}</p>
                            <p class="mb-3 font-normal text-gray-700">SubCategoria: {{ $producto_seleccionado['subcategoria']['nombre'] }}</p>
                            <p class="mb-3 font-normal text-gray-700">Stock Actual:
                                <span class=" text-sm font-bold p-2 {{ $producto_seleccionado['stock'] > $stock_minimo ? 'text-green-500' : 'text-red-500' }}">{{ $producto_seleccionado['stock'] }}</span>
                            </p>
                        </section>
                    @endif
                    @if (!empty($detalle_kardex))
                        <section class="overflow-x-auto relative shadow-md border-gray-200 sm:rounded-lg flex-1">
                            <div class="flex justify-between items-center p-4">
                                <section class="flex gap-5 items-end">
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
                                        wire:click.prevent="buscarKardexPorFecha()">
                                    @include('components/icons/search')</button>
                                </section>
                                <section>
                                    <form action="{{ route('reporte.kardex-producto') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="producto" value="{{ $producto_seleccionado['id'] }}">
                                        <input type="hidden" name="fecha_ini" value="{{ $fecha_ini }}">
                                        <input type="hidden" name="fecha_fin" value="{{ $fecha_fin }}">
                                        <button type="submit"
                                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none flex justify-center">
                                            @include('components/icons/print') <span class="ml-2">Imprimir Reporte</span>
                                        </button>
                                    </form>
                                </section>
                            </div>
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-5">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th colspan="2" class="py-3"></th>
                                        <th colspan="3" class="py-3 text-center">Entrada</th>
                                        <th colspan="3" class="py-3 text-center">Salida</th>
                                        <th scope="col" class="py-3 text-center">Saldo</th>
                                    </tr>
                                    <tr>
                                        <th class="py-3 px-3 w-20">Fecha</th>
                                        <th class="py-3 w-5">Detalle</th>
                                        <th class="py-3 px-3 w-7 text-center">Cantidad</th>
                                        <th class="py-3 px-3 w-7 text-center">Precio</th>
                                        <th class="py-3 px-3 w-7 text-center">Total</th>
                                        <th class="py-3 px-3 w-7 text-center">Cantidad</th>
                                        <th class="py-3 px-3 w-7 text-center">Precio</th>
                                        <th class="py-3 px-3 w-7 text-center">Total</th>
                                        <th class="py-3 px-3 w-7 text-center">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detalle_kardex as $kardex)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="py-4 px-3">{{ $kardex->fecha }}</td>
                                            <td class="py-4">{{ $kardex->detalle }}</td>
                                            <td class="py-4 text-center bg-blue-200">{{ $kardex->cantidad_ingreso }}</td>
                                            <td class="py-4 text-center bg-blue-200">{{ $kardex->precio_compra }}</td>
                                            <td class="py-4 text-center bg-blue-200">{{ $kardex->subtotal_ingreso }}</td>
                                            <td class="py-4 text-center bg-orange-200">{{ $kardex->cantidad_salida }}</td>
                                            <td class="py-4 text-center bg-orange-200">{{ $kardex->precio_venta }}</td>
                                            <td class="py-4 text-center bg-orange-200">{{ $kardex->subtotal_salida }}</td>
                                            <td class="py-4 text-center bg-green-200">{{ $kardex->stock }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>


