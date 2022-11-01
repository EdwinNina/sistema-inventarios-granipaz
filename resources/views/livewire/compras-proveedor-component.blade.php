<div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200 px-5 py-4">
    <header class="border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">LISTADO DE COMPRAS POR PROVEEDOR</h2>
    </header>
    @if (session('mensaje'))
        <div class=" border-l-4 px-5 py-2 rounded mb-3 text-center
            {{session('mensaje') === 'exito' ? 'bg-green-500 border-green-600' : 'bg-red-500 border-red-600'}}">
            <span class="text-white text-center">
                {{ session('mensaje') === 'error'
                    ? 'Debes seleccionar un proveedor para obtener el reporte'
                    : ''
                }}
            </span>
        </div>
    @endif
    <section class="flex flex-col sm:flex-row sm:justify-between my-7">
        <div class="flex items-end gap-2">
            <div>
                <label for="proveedores" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Proveedores</label>
                <select id="proveedores" class="select select-bordered w-full" wire:model="proveedor">
                    <option value="" selected>Seleccionar proveedor</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->empresa }}</option>
                    @endforeach
                </select>
            </div>
            <form action="{{ route('reporte.compras-proveedor') }}" method="post">
                @csrf
                <input type="hidden" name="fecha_ini" wire:model.defer="fecha_ini">
                <input type="hidden" name="fecha_fin" wire:model.defer="fecha_fin">
                <input type="hidden" name="proveedor" wire:model.defer="proveedor">
                <button type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none flex justify-center">
                    @include('components/icons/print') <span class="ml-2">Imprimir Reporte</span>
                </button>
            </form>
        </div>
        <div class="flex mt-3 sm:mt-0 items-end flex-wrap gap-5 justify-end">
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
                wire:click.prevent="buscarComprasPorFecha()">
            @include('components/icons/search')</button>
        </div>
    </section>

    @if (count($compras))
        <section class="lg:mt-0 rounded shadow">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">Codigo</th>
                        <th scope="col" class="py-3 px-6">Fecha</th>
                        <th scope="col" class="py-3 px-6">Producto</th>
                        <th scope="col" class="py-3 px-6">Cantidad</th>
                        <th scope="col" class="py-3 px-6">Precio (Bs)</th>
                        <th scope="col" class="py-3 px-6">Total (Bs)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-4 px-6">{{ $compra->codigo }}</td>
                            <td class="py-4 px-6">{{  \Carbon\Carbon::parse($compra->fecha)->format('d-m-Y') }}</td>
                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ Str::title($compra->nombre) }}</td>
                            <td class="py-4 px-6">{{ $compra->cantidad }}</td>
                            <td class="py-4 px-6">{{ $compra->precio_compra }}</td>
                            <td class="py-4 px-6">{{ $compra->subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    @endif
</div>
