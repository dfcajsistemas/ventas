<div>
    <h4><span class="text-muted fw-light">Mantenimiento /</span> Empresa</h4>
    <div class="row">
        <div class="card">
            <div class="card-body row g-3">
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-info pt-4">
                            <i class="fa-solid fa-building text-muted"></i>
                            {{$empresa->razon_social}}
                        </h3>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="info-container">
                            <div class="border-bottom d-block pt-2 fw-normal text-uppercase text-muted my-3">
                                DATOS EMPRESA
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-medium me-2">RUC:</span>
                                    <span>{{$empresa->ruc}}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">RAZÓN SOCIAL:</span>
                                    <span>{{$empresa->razon_social}}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">NOMBRE COMERCIAL:</span>
                                    <span>{{$empresa->nom_comercial}}</span>
                                </li>

                                <li class="mb-3">
                                    <span class="fw-medium me-2">REPRESENTANTE LEGAL:</span>
                                    <span>{{$empresa->rep_legal}}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">DOMICILIO FISCAL:</span>
                                    <span>{{$empresa->dom_fiscal}}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">DISTRITO:</span>
                                    <span>{{$empresa->distrito->nombre}}</span>
                                </li>
                            </ul>
                            @can('mantenimiento.empresas.editardatos')
                            <div class="justify-content-center pt-3">
                                <button class="btn btn-primary" wire:click="edit({{ $empresa->id }})">Editar</button>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="info-container">
                            <div class="border-bottom d-block pt-2 fw-normal text-uppercase text-muted my-3">
                                DATOS SUNAT
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <span class="fw-medium me-2">USUARIO SOL:</span>
                                    <span>{{$empresa->usuario_sol}}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-medium me-2">CLAVE SOL:</span>
                                    <span>{{$empresa->clave_sol}}</span>
                                </li>
                            </ul>
                            @can('mantenimiento.empresas.editarsunat')
                            <div class="justify-content-center pt-3">
                                <button class="btn btn-primary"
                                    wire:click="editSunat({{ $empresa->id }})">Editar</button>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('mantenimiento.empresas.editardatos')
    <x-modal-form mId="mEmp" :mTitle="$mTitle" :mMethod="$mMethod" mSize="lg">
        <div class="row">
            <div class="col-12 col-md-4">
                <x-label for="ruc" value="RUC" />
                <x-input type="text" id="ruc" wire:model="ruc" />
                <x-input-error for="ruc" />
            </div>
            <div class="col-12 col-md-8">
                <x-label for="razon_social" value="Razon Social" />
                <x-input type="text" id="razon_social" wire:model="razon_social" />
                <x-input-error for="razon_social" />
            </div>
            <div class="col-12 col-md-8">
                <x-label for="nom_comercial" value="Nombre Comercial" />
                <x-input type="text" id="nom_comercial" wire:model="nom_comercial" />
                <x-input-error for="nom_comercial" />
            </div>
            <div class="col-12 col-md-4">
                <x-label for="rep_legal" value="Representante Legal" />
                <x-input type="text" id="rep_legal" wire:model="rep_legal" />
                <x-input-error for="rep_legal" />
            </div>
            <div class="col-12">
                <x-label for="dom_fiscal" value="Domicilio Fiscal" />
                <x-input type="text" id="dom_fiscal" wire:model="dom_fiscal" />
                <x-input-error for="dom_fiscal" />
            </div>
            <div class="col-12 col-md-4">
                <x-label for="departamentoId" value="Departamento" />
                <x-select id="departamentoId" wire:model.live="departamentoId">
                    <option value="">Seleccione Departamento</option>
                    @if($departamentos)
                    @foreach ($departamentos as $departamento)
                    <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                    @endforeach
                    @endif
                </x-select>
                <x-input-error for="departamentoId" />
            </div>
            <div class="col-12 col-md-4">
                <x-label for="provinciaId" value="Provincia" />
                <x-select id="provinciaId" wire:model.live="provinciaId">
                    <option value="">Seleccione Provincia</option>
                    @if ($provincias)
                    @foreach ($provincias as $provincia)
                    <option value="{{$provincia->id}}">{{$provincia->nombre}}</option>
                    @endforeach
                    @endif
                </x-select>
                <x-input-error for="provinciaId" />
            </div>
            <div class="col-12 col-md-4">
                <x-label for="distritoId" value="Distrito" />
                <x-select id="distritoId" wire:model.live="distritoId">
                    <option value="">Seleccione Distrito</option>
                    @if ($distritos)
                    @foreach ($distritos as $distrito)
                    <option value="{{$distrito->id}}">{{$distrito->nombre}}</option>
                    @endforeach
                    @endif
                </x-select>
                <x-input-error for="distritoId" />
            </div>
        </div>
    </x-modal-form>
    @endcan
    @can('mantenimiento.empresas.editarsunat')
    <x-modal-form mId="mSunat" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
        <div class="row">
            <div class="col-12">
                <x-label for="usuario_sol" value="Usuario Sol" />
                <x-input type="text" id="usuario_sol" wire:model="usuario_sol" />
                <x-input-error for="usuario_sol" />
            </div>
            <div class="col-12">
                <x-label for="clave_sol" value="Clave Sol" />
                <x-input type="text" id="clave_sol" wire:model="clave_sol" />
                <x-input-error for="clave_sol" />
            </div>
        </div>
    </x-modal-form>
    @endcan
    @script
    <script>
        Livewire.on('sm', (e) => {
            $("#mEmp").modal('show')
        });
        Livewire.on('hm', (e) => {
            $("#mEmp").modal('hide')
            noti(e[0]['m'], e[0]['t'])
        })
        Livewire.on('sms', (e) => {
            $("#mSunat").modal('show')
        });
        Livewire.on('hms', (e) => {
            $("#mSunat").modal('hide')
            noti(e[0]['m'], e[0]['t'])
        })
        $(document).ready(function(){
            $("#mEmp").on('hidden.bs.modal', function (e) {
                Livewire.dispatch('dispro');
            });
        });
    </script>
    @endscript
</div>
