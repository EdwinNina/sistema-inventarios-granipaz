<div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
    <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">INFORMACION DE LA EMPRESA</h2>
    </header>
    <div class="flex flex-col sm:flex-row justify-between gap-5 p-3">
        <div class="max-w-sm max-h-64 bg-white rounded-lg border border-gray-200 shadow-md">
            <img class="rounded-t-lg object-cover w-full" src="{{ Storage::url($logotipo) }}" alt="{{ $empresa }}">
            <div class="p-3 text-center">
                <h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">Logotipo del Sistema</h5>
            </div>
        </div>
        <section class="overflow-x-auto relative flex-1">
            <div class="form-control w-full">
                <label class="label">
                  <span class="label-text">Nombre de la Empresa</span>
                </label>
                <input type="text" placeholder="Ingrese la categoria" class="input input-bordered w-full @error('empresa') input-error @enderror" wire:model.defer="empresa" />
                @error('empresa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="form-control w-full">
                <label class="label label-text">Nit</label>
                <input type="number" placeholder="Ingrese el Nit de la empresa" class="input input-bordered w-full @error('nit') input-error @enderror" wire:model.defer="nit" />
                @error('nit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="form-control w-full">
                <label class="label label-text">Direccion</label>
                <input type="text" placeholder="Ingrese la direccion de la empresa" class="input input-bordered w-full @error('direccion') input-error @enderror" wire:model.defer="direccion" />
                @error('direccion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 my-3 gap-5">
                <div class="form-control w-full">
                    <label class="label label-text">Correo</label>
                    <input type="email" class="input input-bordered w-full @error('correo') input-error @enderror" wire:model.defer="correo" />
                    @error('correo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="form-control w-full">
                    <label class="label label-text">Celular</label>
                    <input type="number" placeholder="Ingrese el celular de la empresa" class="input input-bordered w-full @error('celular') input-error @enderror" wire:model.defer="celular" />
                    @error('celular') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 my-3 gap-5">
                <div class="form-control w-full">
                    <label class="label label-text">Logotipo</label>
                    <input type="file" class="input input-bordered w-full @error('logotipo') input-error @enderror" wire:model.defer="logotipo" />
                    @error('logotipo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="form-control w-full">
                    <label class="label label-text">Stock Minimo</label>
                    <input type="number" placeholder="Ingrese el stock minimo" class="input input-bordered w-full @error('stock_minimo') input-error @enderror" wire:model.defer="stock_minimo" />
                    @error('stock_minimo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 my-3 gap-5">
                <div class="form-control w-full">
                    <label class="label label-text">Paterno Propietario</label>
                    <input type="text" class="input input-bordered w-full @error('paterno') input-error @enderror" wire:model.defer="paterno" />
                    @error('paterno') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="form-control w-full">
                    <label class="label label-text">Materno Propietario</label>
                    <input type="text" class="input input-bordered w-full @error('materno') input-error @enderror" wire:model.defer="materno" />
                    @error('materno') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="form-control w-full">
                    <label class="label label-text">Nombre Propietario</label>
                    <input type="text" class="input input-bordered w-full @error('nombre') input-error @enderror" wire:model.defer="nombre" />
                    @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex justify-end">
                <button
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-10 mb-2 focus:outline-none"
                    wire:click="guardar()"
                    title="Guardar">Guardar</button>
            </div>
        </section>
    </div>
</div>


