<x-modal modalToggle="{{$modalToggle}}">
    <x-slot name="titulo">Guardar Proveedor</x-slot>
    <x-slot name="cuerpo">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-3">
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Paterno</span></label>
                <input type="text" placeholder="Ingrese el Apellido Paterno"
                    class="input input-bordered w-full @error('paterno') input-error @enderror" wire:model.defer="paterno" />
                @error('paterno') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Materno</span></label>
                <input type="text" placeholder="Ingrese el Apellido Materno"
                    class="input input-bordered w-full @error('materno') input-error @enderror" wire:model.defer="materno" />
                @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Nombre</span></label>
                <input type="text" placeholder="Ingrese el nombre del proveedor"
                    class="input input-bordered w-full @error('nombre') input-error @enderror" wire:model.defer="nombre" />
                @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Tipo de Documento</span></label>
                <select class="select select-bordered @error('tipo_documento') select-error @enderror" wire:model.defer="tipo_documento">
                    <option selected>Seleccione el Tipo de Documento</option>
                    <option value="NIT">NIT</option>
                    <option value="CI">CI</option>
                    <option value="PASAPORTE">PASAPORTE</option>
                    <option value="RUA">RUA</option>
                </select>
                @error('tipo_documento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Nro de Documento</span></label>
                <input type="number" placeholder="Ingrese el nro de documento"
                    class="input input-bordered w-full @error('nro_documento') input-error @enderror" wire:model.defer="nro_documento"/>
                @error('nro_documento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Complemento</span></label>
                <input type="number" placeholder="Ingrese el complemento" class="input input-bordered w-full" wire:model.defer="complemento"/>
            </div>
        </div>
        <h3 class="text-sm text-blue-600 font-bold mt-4 border-b-2">Datos de la Empresa</h3>
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Nombre de la Empresa</span></label>
            <input type="text" placeholder="Ingrese el nombre de la empresa"
                class="input input-bordered w-full @error('empresa') input-error @enderror" wire:model.defer="empresa" />
            @error('empresa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Correo electronico</span></label>
                <input type="email" placeholder="Ingrese el correo electronico de la empresa"
                    class="input input-bordered w-full @error('email') input-error @enderror" wire:model.defer="email" />
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Celular</span></label>
                <input type="number" placeholder="Ingrese el numero de celular"
                    class="input input-bordered w-full @error('celular') input-error @enderror" wire:model.defer="celular" />
                @error('celular') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <button
            class="text-white bg-gray-300 hover:bg-gray-400 focus:ring-4 focus:ring-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none {{ !$modalToggle && 'modal-close' }}" wire:click="cerrarModal()">Cerrar</button>
        @if ($persona_id)
            <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none"
                wire:click="actualizar()"
                title="Actualizar Producto"
            >Actualizar</button>
        @else
            <button
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none"
                wire:click="guardar()"
                title="Guardar Producto"
            >Guardar</button>
        @endif
    </x-slot>
</x-modal>
