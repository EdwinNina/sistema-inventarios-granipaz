<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
                <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="font-semibold text-gray-800">Registrar Nueva Venta</h2>
                    <div class="divider"></div>
                </header>
                <div class="px-4 pb-4 mt-4">
                    <form action="{{ route('ventas.store') }}" method="post">
                        @csrf
                        <h3 class="font-bold text-blue-500 mb-4">Datos de la Venta</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Fecha de Venta</label>
                                <div class="relative">
                                    <div
                                        class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input type="text"
                                        class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500
                                        @error('fecha') input-error @enderror" name="fecha" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" readonly="true">
                                    @error('fecha')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="clientes" class="block mb-2 text-sm font-medium text-gray-900">Clientes</label>
                                <select id="clientes"
                                    class="select select-bordered w-full @error('proveedor') select-error @enderror" name="cliente">
                                    <option value="" selected disabled>Seleccionar Cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('cliente')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end items-end">
                                @livewire('listado-productos-component', ['tipo' => 'venta'])
                            </div>
                        </div>
                        @livewire('productos-carrito-component', ['tipo' => 'venta'])
                        <div class="my-8 flex justify-end">
                            <a href="{{ route('compras.index') }}" type="submit" class="text-white bg-slate-400 hover:bg-slate-500 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">Atras</a>
                            <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">Guardar Venta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
