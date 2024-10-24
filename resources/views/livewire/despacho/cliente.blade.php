<div class="col-1 col-md-2">
    <button class="btn btn-icon btn-primary" wire:click='create' title="Agregar cliente"><i
            class="tf-icons fa-solid fa-user-plus"></i></button>
    <x-modal-form mId="mModelo" :mTitle="$mTitle" :mMethod="$mMethod" mSize="lg">
        <div class="row">
            <div class="col-4">
                <x-label for="tdocumento">Tipo Documento</x-label>
                <x-select id="tdocumento" wire:model="tdocumento">
                    <option value="">Seleccione...</option>
                    @foreach ($tdocumentos as $k => $tdocumento)
                        <option value="{{ $k }}">{{ $tdocumento }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="tdocumento" />
            </div>
            <div class="col-6">
                <x-label for="ndocumento"># Documento</x-label>
                <x-input type="text" id="ndocumento" wire:model="ndocumento" />
                <x-input-error for="ndocumento" />
            </div>
            <div class="col-2 d-flex align-items-end">
                <button class="btn btn-warning btn-lg" title="Buscar y rellenar" wire:click='bDocumento'
                    wire:loading.attr='disabled'>
                    <span class="spinner-grow spinner-grow-sm" aria-hidden="true" wire:loading
                        wire:target='bDocumento'></span>
                    <i class="tf-icons fa-solid fa-magnifying-glass" wire:loading.remove wire:target='bDocumento'></i>
                </button>
            </div>
            <div class="col-9">
                <x-label for="razon_social">Nombre/Razon Social</x-label>
                <x-input type="text" id="razon_social" wire:model="razon_social" />
                <x-input-error for="razon_social" />
            </div>
            <div class="col-3">
                <x-label for="fnacimiento">F. Nacimiento</x-label>
                <x-input type="date" id="fnacimiento" wire:model="fnacimiento" />
                <x-input-error for="fnacimiento" />
            </div>
            <div class="col-12">
                <x-label for="direccion">Dirección</x-label>
                <x-input type="text" id="direccion" wire:model="direccion" />
                <x-input-error for="direccion" />
            </div>
            <div class="col-8">
                <x-label for="referencia">Referencia</x-label>
                <x-input type="text" id="referencia" wire:model="referencia" />
                <x-input-error for="referencia" />
            </div>
            <div class="col-4">
                <x-label for="ubigeo">Ubigeo</x-label>
                <x-input type="text" id="ubigeo" wire:model="ubigeo" />
                <x-input-error for="ubigeo" />
            </div>
            <div class="col-5">
                <x-label for="telefono">Teléfono</x-label>
                <x-input type="text" id="telefono" wire:model="telefono" />
                <x-input-error for="telefono" />
            </div>
            <div class="col-7">
                <x-label for="correo">Correo</x-label>
                <x-input type="email" id="correo" wire:model="correo" />
                <x-input-error for="correo" />
            </div>
        </div>
    </x-modal-form>
    @script
        <script>
            Livewire.on('smc', (e) => {
                $("#mModelo").modal('show')
            });
            Livewire.on('hmc', (e) => {
                $("#mModelo").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })
            Livewire.on('rec', (e) => {
                noti(e[0]['m'], e[0]['t'])
            })
        </script>
    @endscript
</div>
