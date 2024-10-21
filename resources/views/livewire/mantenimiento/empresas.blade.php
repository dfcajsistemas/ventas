<div>
    <h4><span class="text-muted fw-light">Mantenimiento /</span> Empresa</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="card-title m-0">EMPRESA</h6>
                    @can('mantenimiento.empresas.editardatos')
                        <button class="btn btn-icon btn-info btn-sm" wire:click="edit({{ $empresa->id }})">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    @endcan
                </div>
                <div class="card-body row">
                    <div class="col-12">
                        <h3 class="text-primary">
                            <i class="fa-solid fa-building text-muted"></i>
                            {{ $empresa->razon_social }}
                        </h3>
                    </div>
                    <div class="col-md-12">
                        <div class="info-container">
                            <div class="border-bottom d-block pt-2 fw-normal text-uppercase text-muted my-3">
                                DATOS EMPRESA
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <span class="fw-medium me-2">RUC:</span>
                                    <span>{{ $empresa->ruc }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-medium me-2">RAZÓN SOCIAL:</span>
                                    <span>{{ $empresa->razon_social }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-medium me-2">NOMBRE COMERCIAL:</span>
                                    <span>{{ $empresa->nom_comercial }}</span>
                                </li>

                                <li class="mb-2">
                                    <span class="fw-medium me-2">REPRESENTANTE LEGAL:</span>
                                    <span>{{ $empresa->rep_legal }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-medium me-2">DOMICILIO FISCAL:</span>
                                    <span>{{ $empresa->dom_fiscal }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-medium me-2">DISTRITO:</span>
                                    <span>{{ $empresa->distrito->nombre }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-medium me-2">PROVINCIA:</span>
                                    <span>{{ $empresa->distrito->provincia->nombre }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-medium me-2">DEPARTAMENTO:</span>
                                    <span>{{ $empresa->distrito->provincia->departamento->nombre }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-medium me-2">UBIGEO:</span>
                                    <span>{{ $empresa->ubigeo }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="card-title m-0">LOGO</h6>
                    @can('mantenimiento.empresas.editarlogo')
                        <button class="btn btn-icon btn-info btn-sm" wire:click="editLogo({{ $empresa->id }})">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    @endcan
                </div>
                <div class="card-body row">
                    <div class="col-12">
                        <div class="info-container">
                            @if ($empresa->logo)
                                <img src="{{ asset('storage/' . $empresa->logo) }}" alt="logo" class="img-fluid">
                            @else
                                No se ha cargado un logo
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="card-title m-0">DATOS SUNAT</h6>
                    @can('mantenimiento.empresas.editarsunat')
                        <button class="btn btn-icon btn-info btn-sm" wire:click="editSunat({{ $empresa->id }})">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    @endcan
                </div>
                <div class="card-body row">
                    <div class="col-12">
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <span class="fw-medium me-2">USUARIO SOL:</span>
                                    <span>{{ $empresa->usuario_sol }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-medium me-2">CLAVE SOL:</span>
                                    <span>{{ $empresa->clave_sol }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="card-title m-0">DATOS CERTIFICADO</h6>
                    @can('mantenimiento.empresas.editarcertificado')
                        <button class="btn btn-icon btn-info btn-sm" wire:click="editCertificado({{ $empresa->id }})">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    @endcan
                </div>
                <div class="card-body row">
                    <div class="col-12">
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <span class="fw-medium me-2">CERTIFICADO:</span>
                                    <span>{{ $empresa->certificado }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-medium me-2">CONTRASEÑA:</span>
                                    <span>{{ $empresa->pas_certificado }}</span>
                                </li>
                                <li class="mb-2">
                                    <span class="fw-medium me-2">F. VENCIMIENTO:</span>
                                    <span>{{ $empresa->ven_certificado }}</span>
                                </li>
                            </ul>
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
                        @if ($departamentos)
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
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
                                <option value="{{ $provincia->id }}">{{ $provincia->nombre }}</option>
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
                                <option value="{{ $distrito->id }}">{{ $distrito->nombre }}</option>
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
    @can('mantenimiento.empresas.editarcertificado')
        <x-modal-form mId="mCertificado" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
            <div class="row">
                <div class="col-12">
                    <x-label for="certificado" value="Certificado" />
                    <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
                        x-on:livewire-upload-error="uploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <x-input type="file" id="certificado" wire:model="certificado" />
                        <div x-show="uploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>
                    <x-input-error for="certificado" />
                </div>
                <div class="col-12">
                    <x-label for="pas_certificado" value="Contraseña" />
                    <x-input type="text" id="pas_certificado" wire:model="pas_certificado" />
                    <x-input-error for="pas_certificado" />
                </div>
                <div class="col-12">
                    <x-label for="ven_certificado" value="Vencimiento" />
                    <x-input type="date" id="ven_certificado" wire:model="ven_certificado" />
                    <x-input-error for="ven_certificado" />
                </div>
            </div>
        </x-modal-form>
    @endcan
    @can('mantenimiento.empresas.editarlogo')
        <x-modal-form mId="mLogo" :mTitle="$mTitle" :mMethod="$mMethod" mSize="sm">
            <div class="row">
                <div class="col-12">
                    <x-label for="logo" value="Usuario Sol" />
                    <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
                        x-on:livewire-upload-error="uploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <x-input type="file" id="logo" wire:model="logo" accept="image/*" />
                        <div x-show="uploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>
                    <x-input-error for="logo" />
                </div>
                <div class="col-12 mt-3">
                    @if ($logo)
                        <img src="{{ $logo->temporaryUrl() }}" alt="Vista previa del logo" class="img-fluid">
                    @endif
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
            Livewire.on('smc', (e) => {
                $("#mCertificado").modal('show')
            });
            Livewire.on('hmc', (e) => {
                $("#mCertificado").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })
            Livewire.on('sml', (e) => {
                $("#mLogo").modal('show')
            });
            Livewire.on('hml', (e) => {
                $("#mLogo").modal('hide')
                noti(e[0]['m'], e[0]['t'])
            })
            $(document).ready(function() {
                $("#mEmp").on('hidden.bs.modal', function(e) {
                    Livewire.dispatch('dispro');
                });
            });
        </script>
    @endscript
</div>
