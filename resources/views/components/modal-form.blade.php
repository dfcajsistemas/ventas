@props(['mId' => 'modal', 'mTitle' => 'Título', 'mMethod' => 'render', 'mSize' => 'md'])
@php
    switch ($mSize ?? '') {
        case 'sm':
            $mSize = ' modal-sm';
            break;
        case 'md':
            $mSize = '';
            break;
        case 'lg':
            $mSize = ' modal-lg';
            break;
        case 'xl':
            $mSize = ' modal-xl';
            break;
        default:
            $mSize = '';
            break;
    }
@endphp
<div wire:ignore.self class="modal fade" id="{{ $mId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog {{ $mSize = '' ? '' : $mSize }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ $mTitle }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Cerrar
                </button>
                @if ($mMethod == 'store')
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="store">
                        <span class="spinner-border me-1" role="status" aria-hidden="true" wire:loading
                            wire:target="store"></span>
                        <span class="">Guardar</span>
                    </button>
                @elseif($mMethod == 'update')
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="update">
                        <span class="spinner-border me-1" role="status" aria-hidden="true" wire:loading
                            wire:target="update"></span>
                        <span class="">Actualizar</span>
                    </button>
                @elseif($mMethod == 'storeForm')
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="storeForm">
                        <span class="spinner-border me-1" role="status" aria-hidden="true" wire:loading
                            wire:target="storeForm"></span>
                        <span class="">Guardar</span>
                    </button>
                @elseif($mMethod == 'updateForm')
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="updateForm">
                        <span class="spinner-border me-1" role="status" aria-hidden="true" wire:loading
                            wire:target="updateForm"></span>
                        <span class="">Actualizar</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
