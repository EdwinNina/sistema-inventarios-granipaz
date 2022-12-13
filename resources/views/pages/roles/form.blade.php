<x-modal modalToggle="{{$modalToggle}}">
    <x-slot name="titulo">Guardar Usuario</x-slot>
    <x-slot name="cuerpo">
        <div class="flex flex-col flex-wrap gap-8 md:flex-row md:flex-nowrap">
            <section class="flex-1">
                <div class="form-control w-full">
                    <label class="label">
                      <span class="label-text">Nombre *</span>
                    </label>
                    <input type="text" placeholder="Ingrese el nombre del rol" class="input input-bordered w-full @error('nombre') input-error @enderror" wire:model.defer="nombre" />
                    @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="form-control w-full">
                    <label class="label">
                      <span class="label-text">Descripcion</span>
                    </label>
                    <input type="text" placeholder="Ingrese la descripcion" class="input input-bordered w-full @error('descripcion') input-error @enderror" wire:model.defer="descripcion" />
                    @error('descripcion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </section>
        </div>
    </x-slot>
    <x-slot name="footer">
        <button
        class="text-white bg-gray-300 hover:bg-gray-400 focus:ring-4 focus:ring-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none {{ !$modalToggle && 'modal-close' }}" wire:click="cerrarModal()" title="Cerrar Modal">Cerrar</button>
        @if ($role_id)
            <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none"
                wire:click="actualizar()"
                title="Actualizar Role"
            >Actualizar</button>
        @else
            <button
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none"
                wire:click="guardar()"
                title="Guardar Role"
            >Guardar</button>
        @endif
    </x-slot>
</x-modal>
