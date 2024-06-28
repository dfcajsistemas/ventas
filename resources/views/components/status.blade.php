@props(['status'])
<span class="badge badge-center rounded-pill bg-label-{{$status==1 ? 'success' : 'danger'}}">
    @if ($status==1)
    <i class="fa-solid fa-check fa-xs"></i>
    @else
    <i class="fa-solid fa-xmark fa-xs"></i>
    @endif
</span>
