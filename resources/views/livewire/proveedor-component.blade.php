<div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">LISTADO DE {{ $tipo_persona }}</h2>
        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 focus:outline-none" wire:click="abrirModal()">Nuevo {{ Str::ucfirst(Str::lower($tipo_persona)) }}</button>
    </header>

    @include('pages.proveedor.form-modal')

    <div class="px-3 flex justify-end mt-3">
        <x-buscador criterio="Buscar por paterno, materno, nombre o empresa"/>
    </div>

    <div class="p-3">
        <div class="overflow-x-auto mt-6 lg:mt-0 rounded shadow">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">Nombre Completo</th>
                            <th scope="col" class="py-3 px-6">Tipo de Documento</th>
                            <th scope="col" class="py-3 px-6">Nro de Documento</th>
                            <th scope="col" class="py-3 px-6">Empresa</th>
                            <th scope="col" class="py-3 px-6">Email</th>
                            <th scope="col" class="py-3 px-6">Celular</th>
                            <th scope="col" class="py-3 px-6">Estado</th>
                            <th scope="col" class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach ($proveedores as $proveedor)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ $proveedor->nombreCompleto }}</td>
                            <td class="py-4 px-6">{{ $proveedor->tipo_documento }}</td>
                            <td class="py-4 px-6">{{ $proveedor->nro_documento }}</td>
                            <td class="py-4 px-6">{{ Str::ucfirst($proveedor->empresa) }}</td>
                            <td class="py-4 px-6">{{ $proveedor->email }}</td>
                            <td class="py-4 px-6">{{ $proveedor->celular }}</td>
                            <td class="py-4 px-6">
                                <span class="py-2 px-3 text-white rounded-3xl {{ $proveedor->estado ? 'bg-green-500' : 'bg-red-500' }}">{{ $proveedor->estado ? 'Activo' : 'Inactivo' }}</span>
                            </td>
                            <td class="py-4 px-6 flex justify-center items-center gap-2">
                                <button class="bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center" wire:click="editar({{ $proveedor->id }})" title="Editar Proveedor">
                                    @include('components/icons/edit')
                                </button>
                                <button type="button"
                                    class="bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:ring-teal-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                    wire:click="actualizarEstado({{ $proveedor->id }})"
                                    title="Habilitar/Deshabilitar Producto">
                                    @if ($proveedor->estado)
                                        @include('components/icons/enable')
                                    @else
                                        @include('components/icons/disable')
                                    @endif
                                </button>
                                <button class="bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                    wire:click="eliminarProveedor({{ $proveedor->id }})" title="Eliminar Proveedor">
                                    @include('components/icons/delete')
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-3 py-3">
                {{ $proveedores->links() }}
            </div>
        </div>
    </div>
</div>


