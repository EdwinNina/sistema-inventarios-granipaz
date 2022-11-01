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
                    <p class="font-bold text-lg">Nombre: {{ $detalle['nombre'] }} </p>
                    <p class="font-bold">descripcion: {{ $detalle['descripcion'] }} </p>
                    <p class="font-bold">Precio Unitario: {{ $detalle['precio_unitario'] }} </p>
                    <p class="font-bold">Precio Venta: {{ $detalle['precio_venta'] }} </p>
                    <p class="font-bold">Stock: {{ $detalle['stock'] }} </p>
                    <p class="font-bold">SubCategoria: {{ $detalle['subcategoria']['nombre'] }} </p>
                </div>
            </div>
        @endif
    </div>
</div>
