<div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">LISTADO DE USUARIOS</h2>
        <div class="flex">
            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none"
                wire:click="abrirModal()">Crear usuario
            </button>
        </div>
    </header>

    @include('pages.usuarios.form')

    <div class="p-3">
        <div class="overflow-x-auto mt-6 lg:mt-0 rounded shadow">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">Nombre de Usuario</th>
                            <th scope="col" class="py-3 px-6">Correo electronico</th>
                            <th scope="col" class="py-3 px-6">Role</th>
                            <th scope="col" class="py-3 px-6">Estado</th>
                            <th scope="col" class="py-3 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ Str::title($usuario->name) }}</th>
                                <td class="py-4 px-6">{{ $usuario->email }}</td>
                                <td class="py-4 px-6">{{ Str::title($usuario->role->nombre) }}</td>
                                <td class="py-4 px-6">
                                    <span class="py-2 px-3 text-white rounded-3xl {{ $usuario->estado ? 'bg-green-500' : 'bg-red-500' }}">{{ $usuario->estado ? 'Activo' : 'Inactivo' }}</span>
                                </td>
                                <td class="py-4 px-6 flex justify-center items-center gap-3">
                                    <button type="button"
                                        class="bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="editar({{ $usuario->id }})"
                                        title="Editar Usuario">
                                        @include('components/icons/edit')
                                    </button>
                                    <button type="button"
                                        class="bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:ring-teal-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="actualizarEstado({{ $usuario->id }})"
                                        title="Habilitar/Deshabilitar Usuario">
                                        @if ($usuario->estado)
                                            @include('components/icons/enable')
                                        @else
                                            @include('components/icons/disable')
                                        @endif
                                    </button>
                                    <button type="button" title="Eliminar Usuario"
                                        class="bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 focus:outline-none rounded-full h-10 w-10 flex justify-center items-center"
                                        wire:click="eliminar({{ $usuario->id }})">
                                        @include('components/icons/delete')
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-4 py-3">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>
</div>


