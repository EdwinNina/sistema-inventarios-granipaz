<x-modal modalToggle="{{$modalToggle}}">
    <x-slot name="titulo">Guardar Producto</x-slot>
    <x-slot name="cuerpo">
        <div class="flex flex-col flex-wrap gap-8 md:flex-row md:flex-nowrap">
            <section class="flex-1">
                <div class="form-control w-full">
                    <label class="label">
                      <span class="label-text">Nombre *</span>
                    </label>
                    <input type="text" placeholder="Ingrese el nombre del producto" class="input input-bordered w-full @error('nombre') input-error @enderror" wire:model.defer="nombre" />
                    @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="form-control w-full">
                    <label class="label">
                      <span class="label-text">Descripcion</span>
                    </label>
                    <input type="text" placeholder="Ingrese la descripcion del producto" class="input input-bordered w-full" wire:model.defer="descripcion" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 mt-2 gap-2">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Categoria</span>
                        </label>
                        <select class="select select-bordered" wire:change="filtrarSubCategoria($event.target.value)" wire:model="categoria_seleccionada">
                            <option value="" disabled selected>Seleccione la categoria</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">SubCategoria *</span>
                        </label>
                        <select class="select select-bordered @error('sub_categoria_id') select-error @enderror" wire:model.defer="sub_categoria_id">
                            <option value="" disabled selected>Seleccione la subcategoria</option>
                            @foreach ($a_subcategorias as $subcategoria)
                                <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                            @endforeach
                        </select>
                        @error('sub_categoria_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </section>
            <section>
                <div class="bg-gray-400 w-full h-52">
                    @if ($imagen && $actualizar_imagen)
                        <img src="{{ $imagen->temporaryUrl() }}" class="w-full h-52 object-cover">
                    @elseif ($imagen)
                        <img src="{{ Storage::url($imagen) }}" class="w-full h-52 object-cover">
                    @endif
                </div>
                <div class="form-control w-full">
                    <label class="label label-text">Imagen *</label>
                    <input type="file" class="input input-bordered w-full @error('imagen') input-error @enderror" wire:model.defer="imagen" />
                    @error('imagen') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </section>
        </div>
    </x-slot>
    <x-slot name="footer">
        <button
        class="text-white bg-gray-300 hover:bg-gray-400 focus:ring-4 focus:ring-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none {{ !$modalToggle && 'modal-close' }}" wire:click="cerrarModal()" title="Cerrar Modal">Cerrar</button>
        @if ($productoId)
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
