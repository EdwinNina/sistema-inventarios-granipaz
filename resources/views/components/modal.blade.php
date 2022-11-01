<div class="modal modal-bottom sm:modal-middle {{ $modalToggle ? 'modal-open' : 'modal-close' }}">
    <div class="modal-box relative w-11/12 max-w-5xl">
        <button class="btn btn-sm btn-circle absolute right-2 top-2 {{ !$modalToggle && 'modal-close' }}" wire:click.prevent="cerrarModal()">✕</button>

        <h3 class="text-center font-bold">{{ $titulo }}</h3>
        <div class="divider"></div>

        {{ $cuerpo }}

        <div class="modal-action">
            {{ $footer }}
        </div>
    </div>
</div>
