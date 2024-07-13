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
    $kb=rand(1,99);
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
                <button wire:key='{{$kb}}' type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="{{$mMethod}}">
                    <span class="spinner-border me-1" role="status" aria-hidden="true" wire:loading
                        wire:target="{{$mMethod}}"></span>
                    <span class="">Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>
