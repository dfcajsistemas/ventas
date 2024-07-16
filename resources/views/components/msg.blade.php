@props(['msg' => 'agregar mensaje', 'type' => 'info'])
@php
    switch ($type) {
        case 'info':
            $icon = 'fa-solid fa-info';
            break;
        case 'danger':
            $icon = 'bx bx-x';
            break;
        case 'warning':
            $icon = 'fa-solid fa-exclamation';
            break;
        case 'success':
            $icon = 'bx bx-check';
            break;
        default:
            $icon = 'fa-solid fa-info';
            break;
    }
@endphp

<div class="alert d-flex align-items-center bg-label-{{ $type }} mb-0" role="alert">
    <span class="badge badge-center rounded-pill bg-{{ $type }} border-label-{{ $type }} p-2 me-2">
        <i class="{{ $icon }}"></i>
    </span>
    <div class="ps-1">
        <span>{{ $msg }}</span>
    </div>
</div>
