<div class="modal modal-bottom sm:modal-middle {{ $modalToggleDetalle ? 'modal-open' : 'modal-close' }}">
    <div class="modal-box relative w-11/12 max-w-5xl">
        <button class="btn btn-sm btn-circle absolute right-2 top-2 {{ !$modalToggleDetalle && 'modal-close' }}" wire:click="$set('modalToggleDetalle', false)">✕</button>
        <h3 class="text-center font-bold">Detalle producto</h3>
        <div class="divider"></div>

        @if (isset($detalle))
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="col-span-1">
                    <img src="{{ Storage::url($detalle['imagen']) }}" alt="{{ $detalle->nombre }}" class="object-cover w-full rounded-lg">
                </div>
                <div class="col-span-2">
                    <p><span class="font-bold text-lg">Nombre:</span> {{ $detalle['nombre'] }} </p>
                    <p><span class="font-bold">Descripcion:</span> {{ $detalle['descripcion'] }} </p>
                    <p><span class="font-bold">Stock:</span> {{ $detalle['stock'] }} </p>
                    <p><span class="font-bold">SubCategoria:</span> {{ $detalle['subcategoria']['nombre'] }} </p>
                </div>
            </div>
        @endif
    </div>
</div>
