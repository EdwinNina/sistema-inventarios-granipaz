<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
                <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="font-semibold text-gray-800">Editar Compra</h2>
                    <div class="divider"></div>
                </header>
                <div class="px-4 pb-4 mt-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-12">
                        <div>
                            @livewire('listado-productos-component', ['tipo' => 'compra'])
                        </div>
                        <div>
                            <form action="{{ route('compras.update', $compra->id) }}" method="post">
                                @method('PUT')
                                @csrf
                                <h3 class="font-bold text-blue-500 mb-4">Datos de la Compra</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Fecha de Compra</label>
                                        <div class="relative">
                                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <input type="text"
                                                class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 datepicker
                                                @error('fecha') input-error @enderror" name="fecha" value="{{ \Carbon\Carbon::parse($compra->fecha)->format('d-m-Y') }}">
                                            @error('fecha')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label for="proveedores" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Proveedores</label>
                                        <select id="proveedores"
                                            class="select select-bordered w-full @error('proveedor') select-error @enderror"
                                            name="proveedor">
                                            <option value="" disabled>Seleccionar proveedor</option>
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}"
                                                    {{ $proveedor->id == $compra->proveedor_id ? 'selected' : '' }}>{{ $proveedor->empresa }}</option>
                                            @endforeach
                                        </select>
                                        @error('proveedor')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 my-3">
                                    <div>
                                        <label for="tipo_comprobante" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Tipo de Comprobante</label>
                                        <select id="tipo_comprobante"
                                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 border-gray-300"
                                            name="tipo_comprobante">
                                            <option value="" disabled>Selecciona el tipo de Comprobante</option>
                                            @foreach ($tipo_comprobantes as $tipo)
                                                <option value="{{ $tipo }}" {{ $tipo === $compra->tipo_comprobante ? 'selected' : ''}}>{{ $tipo }}</option>
                                            @endforeach
                                        </select>
                                        @error('tipo_comprobante')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nro de Comprobante</label>
                                        <input type="number"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" name="nro_comprobante" value="{{ $compra->nro_comprobante }}">
                                        @error('nro_comprobante')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @livewire('productos-carrito-component', ['productos' => $productos, 'total' => $total])
                                <div class="my-8 flex justify-end">
                                    <a href="{{ route('compras.index') }}" type="submit" class="text-white bg-slate-400 hover:bg-slate-500 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-slate-700 focus:outline-none dark:focus:ring-slate-800">Atras</a>
                                    <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Guardar Compra</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
