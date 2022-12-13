<x-modal modalToggle="{{$modalToggle}}">
    <x-slot name="titulo">Guardar Usuario</x-slot>
    <x-slot name="cuerpo">
        <div class="flex flex-col flex-wrap gap-8 md:flex-row md:flex-nowrap">
            <section class="flex-1">
                <div class="form-control w-full">
                    <label class="label">
                      <span class="label-text">Nombre *</span>
                    </label>
                    <input type="text" placeholder="Ingrese el nombre del usuario" class="input input-bordered w-full @error('name') input-error @enderror" wire:model.defer="name" />
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="form-control w-full">
                    <label class="label">
                      <span class="label-text">Correo electronico *</span>
                    </label>
                    <input type="email" placeholder="Ingrese el correo electronico" class="input input-bordered w-full @error('email') input-error @enderror" wire:model.defer="email" />
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 mt-2 gap-2">
                    <div class="form-control w-full">
                        <label class="label">
                          <span class="label-text">Contraseña *</span>
                        </label>
                        <input type="password" placeholder="Ingrese la contraseña" class="input input-bordered w-full @error('password') input-error @enderror" wire:model.defer="password" />
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Roles</span>
                        </label>
                        <select class="select select-bordered" wire:model="role_id">
                            <option value="" selected>Seleccione el rol</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ Str::title($role->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>
        </div>
    </x-slot>
    <x-slot name="footer">
        <button
        class="text-white bg-gray-300 hover:bg-gray-400 focus:ring-4 focus:ring-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none {{ !$modalToggle && 'modal-close' }}" wire:click="cerrarModal()" title="Cerrar Modal">Cerrar</button>
        @if ($usuario_id)
            <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none"
                wire:click="actualizar()"
                title="Actualizar Usuario"
            >Actualizar</button>
        @else
            <button
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none"
                wire:click="guardar()"
                title="Guardar Usuario"
            >Guardar</button>
        @endif
    </x-slot>
</x-modal>
