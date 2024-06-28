@props(['mTitle' => 'modal', 'mEvent' => 'modal'])
<div class="modal fade" id="modalCom" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ $mTitle }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                    wire:click="$set('isOpen','0')">
                    Close
                </button>
                <button @click="$dispatch('{{ $mEvent }}')" type="button" class="btn btn-primary">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>
