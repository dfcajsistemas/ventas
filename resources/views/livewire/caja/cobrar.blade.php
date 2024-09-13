<div>
    <h4><span class="text-muted fw-light">Caja /</span> Cobrar <span class="text-warning">(Sucursal:
            {{$sucursal->nombre}})</span></h4>
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="text-info">Juan Perez</h5>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Ventas</h5>
                </div>
                <div class="table-responsive text-noweap">
                    <table class="table table-sm table-hover text-small">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>total</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                    </table>
                </div>
                <div class="m-3">

                </div>

                <div class="mx-3 mb-3">
                    <x-msg type="info" msg="No se encontraron ventas cobradas" />
                </div>

            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Movimiento</h5>
                </div>
                <div class="table-responsive text-noweap">
                    <table class="table table-sm table-hover text-small">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                    </table>
                </div>
                <div class="m-3">

                </div>

                <div class="mx-3 mb-3">
                    <x-msg type="info" msg="No se encontraron movimientos" />
                </div>

            </div>
            <div class="card">
                <div class="card-header">
                    <h5>Resumen</h5>
                </div>
                <div class="table-responsive text-noweap">
                    <table class="table table-sm table-hover text-small">
                        <thead>
                            <tr>
                                <th>Modo pago</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                    </table>
                </div>
                <div class="m-3">

                </div>

                <div class="mx-3 mb-3">
                    <x-msg type="info" msg="Aún no se hay cobros" />
                </div>

            </div>
        </div>
    </div>


    @script
    <script>
        Livewire.on('sm', (e) => {
            $("#mModelo").modal('show')
        });
        Livewire.on('hm', (e) => {
            $("#mModelo").modal('hide')
            noti(e[0]['m'], e[0]['t'])
        })
        Livewire.on('re', (e) => {
            noti(e[0]['m'], e[0]['t'])
        })

        Livewire.on('smd', (e) => {
            $("#mDetails").modal('show')
        });

        Alpine.data('eliminar', () => ({
            confirmar(id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, bórralo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete', {
                            reposicion: id
                        })
                    }
                })
            }
        }))
    </script>
    @endscript
</div>
