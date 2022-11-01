<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-full bg-white shadow-lg rounded-sm border border-gray-200">
                <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="font-semibold text-gray-800">Registrar Nueva Categoria</h2>
                    <div class="divider"></div>
                </header>
                <div class="px-4 pb-4 mt-4">
                    <form action="{{ route('categorias.store') }}" method="post">
                        @csrf
                        <div class="form-control w-full">
                            <label class="label">
                              <span class="label-text">Nombre</span>
                            </label>
                            <input type="text" placeholder="Ingrese la categoria" class="input input-bordered w-full @error('nombre') input-error @enderror" name="nombre" />
                            @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                              <span class="label-text">Descripcion</span>
                            </label>
                            <input type="text" placeholder="Ingrese la descripcion" class="input input-bordered w-full" name="descripcion"/>
                        </div>
                        @livewire('sub-categoria-component')
                        <div class="mt-8 flex justify-end">
                            <a href="{{ route('categorias.index') }}" type="submit" class="text-white bg-slate-400 hover:bg-slate-500 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-slate-600 dark:hover:bg-slate-700 focus:outline-none dark:focus:ring-slate-800">Atras</a>
                            <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">Guardar Compra</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
