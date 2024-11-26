@extends('Plantilla.principal')
@section('title', 'Gestionar compromisos')
@section('Contenido')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Gestionar compromisos</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="{{ url('/') }}">Inicio</a></li>
                        <li class="active">Gestionar compromisos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Listado de compromisos</strong>
                        </div>
                        <div class="card-body">
                            <table id="bootstrap-data-table-compromiso" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Tipo de compromiso</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="largeModalLabel">Gestionar compromiso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 id="titCompromiso">Agregar compromiso</h4>
                            </div>
                            <div class="card-body">
                                <form id="formCompromiso">

                                    <input type="hidden" name="idRegistro" id="idRegistro" />
                                    <input type="hidden" name="accRegistro" id="accRegistro" />
                                    <div class="form-group">
                                        <label for="tipoCompromiso">Tipo de compromiso</label>
                                        <select id="tipoCompromiso" name="tipoCompromiso" class="form-control">
                                            <option value="">Seleccione un tipo de compromiso</option>
                                            <option value="impuestos">Declaración de impuestos</option>
                                            <option value="informes">Presentación de informes</option>
                                            <option value="pago_cuotas">Pago de cuotas</option>
                                            <option value="actualizacion">Actualización de datos</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <input type="text" class="form-control" id="descripcion" name="descripcion"
                                            placeholder="Ingrese una escripción">
                                    </div>
                                    <div class="form-group">
                                        <label for="periodicidad">Periocidad</label>
                                        <select id="periodicidad" name="periodicidad" class="form-control">
                                            <option value="">Seleccione la periodicidad</option>
                                            <option value="mensual">Mensual</option>
                                            <option value="trimestral">Trimestral</option>
                                            <option value="semestral">Semestral</option>
                                            <option value="anual">Anual</option>
                                            <option value="unico">Único</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nit">Observación</label>
                                        <textarea name="observacion" id="observacion" rows="3" placeholder="Observación..." class="form-control"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" id="newRegistro" onclick="nuevoRegistro()" style="display: none;"
                        class="btn btn-secondary">Nuevo</button>
                    <button type="button" id="cancelRegistro" onclick="cancelRegistro()"
                        class="btn btn-secondary">Cancelar</button>
                    <button type="button" id="saveRegistro" onclick="guardarRegistro()"
                        class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            let menuP = document.getElementById("parametros");
            menuP.classList.add("active", "show");
            let menuS = document.getElementById("parametrosCompromiso");
            menuS.classList.add("active");

            $("#formCompromiso").validate({
                rules: {

                    descripcion: {
                        required: true
                    }
                },
                messages: {

                    descripcion: {
                        required: "Por favor, ingrese la descripción."
                    }
                },
                submitHandler: function(form) {
                    guardarRegistro();
                }
            });

            function cargarRegistros() {
                let url = "compromiso/cargarCompromisos"; //
                return new Promise((resolve, reject) => {
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute(
                                        'content')
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la respuesta del servidor');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Agregar datos a la tabla principal
                            const table = $('#bootstrap-data-table-compromiso').DataTable();
                            table.clear();
                            table.rows.add(data).draw();

                            resolve();
                        })
                        .catch(error => {
                            console.error('Error al cargar los registros:', error);
                            reject(error);
                        });
                });
            }

            // Llamar a la función para cargar datos al inicializar
            cargarRegistros().then(() => {
                console.log('Registros cargados correctamente');
            }).catch(error => {
                console.error('Error al inicializar las tablas:', error);
            });

            const tipoCompromisoTexto = {
                impuestos: "Declaración de impuestos",
                informes: "Presentación de informes",
                pago_cuotas: "Pago de cuotas",
                actualizacion: "Actualización de datos"
            };

            $('#bootstrap-data-table-compromiso').DataTable({
                lengthMenu: [
                    [10, 20, 50, -1],
                    [10, 20, 50, "Todos"]
                ],
                data: [], // Inicialmente vacío
                columns: [{
                        title: "Descripción",
                        data: "descripcion",
                    },
                    {
                        title: "Tipo de compromiso",
                        data: "tipo_compromiso",
                        render: function(data, type, row) {
                            // Devuelve el texto correspondiente al valor
                            return tipoCompromisoTexto[data] || "Desconocido";
                        }
                    },
                    {
                        title: "Opciones",
                        data: null, // No está relacionado con datos específicos
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-warning btn-sm editar-btn" data-id="${row.id}"><i class="fa fa-edit"></i> Editar</button>
                        <button class="btn btn-danger btn-sm eliminar-btn" data-id="${row.id}"><i class="fa fa-trash"></i> Eliminar</button>
                        `;
                        }
                    }
                ],
                language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "Ningún dato disponible en esta tabla",
                    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
                    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                    sSearch: "Buscar:",
                    oPaginate: {
                        sFirst: "Primero",
                        sLast: "Último",
                        sNext: "Siguiente",
                        sPrevious: "Anterior"
                    },
                    sLoadingRecords: "Cargando...",
                    sSearchPlaceholder: "Buscar registros"
                },
                initComplete: function() {
                    const buttonHtml =
                        '<button type="button" class="btn btn-primary" id="addCompanyBtnExport" style="margin-left: 10px;">Agregar compromiso</button>';
                    $('#bootstrap-data-table-compromiso_filter').append(buttonHtml);

                    $('#addCompanyBtnExport').on('click', function() {
                        var modal = new bootstrap.Modal(document.getElementById(
                            "largeModal"), {
                            backdrop: 'static',
                            keyboard: false
                        });
                        modal.show();
                        nuevoRegistro();
                    });
                }
            });

            $('#bootstrap-data-table-compromiso').on('click', '.editar-btn', function() {
                const idCompromiso = $(this).data('id');

                var modal = new bootstrap.Modal(document.getElementById("largeModal"), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
                document.getElementById("accRegistro").value = "editar";

                const url = "compromiso/infoCompromiso";

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            idCompromiso: idCompromiso
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al obtener los datos del registro')
                        }
                        return response.json();
                    })
                    .then(data => {

                        document.getElementById("descripcion").value = data.descripcion
                        document.getElementById("observacion").value = data.observacion
                        document.getElementById("tipoCompromiso").value = data.tipo_compromiso
                        document.getElementById("periodicidad").value = data.periocidad
                        document.getElementById("idRegistro").value = data.id

                        document.getElementById('saveRegistro').removeAttribute('disabled')
                        document.getElementById('newRegistro').style.display = 'none'
                        document.getElementById('cancelRegistro').style.display = 'initial'
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un problema al cargar los datos para editar.');
                    });



            });

            $('#bootstrap-data-table-compromiso').on('click', '.eliminar-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = "/compromiso/eliminar";
                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute(
                                        'content')
                                },
                                body: JSON.stringify({
                                    idReg: id
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        '¡Eliminado!',
                                        'El elemento ha sido eliminado.',
                                        'success'
                                    )
                                    recargarDataTable()
                                } else {
                                    swal("¡Alerta!",
                                        "La operación fue realizada exitosamente",
                                        data.message,
                                        "success");
                                }
                            })


                    }
                });

            });

        });

        function cancelRegistro() {
            const formCompromiso = document.getElementById('formCompromiso');
            formCompromiso.reset();
            document.getElementById('titCompromiso').innerText = 'Agregar compromiso';
            document.getElementById('accRegistro').value = 'guardar'
        }


        function nuevoRegistro() {
            cancelRegistro()
            document.getElementById('accRegistro').value = 'guardar'
            document.getElementById('saveRegistro').removeAttribute('disabled')
            document.getElementById('newRegistro').style.display = 'none'
            document.getElementById('cancelRegistro').style.display = 'initial'

        }

        function recargarDataTable() {
            fetch("compromiso/cargarCompromisos", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Error al cargar los datos");
                    }
                    return response.json();
                })
                .then(data => {
                    // Limpiar el DataTable actual
                    let table = $('#bootstrap-data-table-compromiso').DataTable();
                    table.clear(); // Limpia los datos existentes

                    // Agregar las nuevas filas
                    table.rows.add(data).draw(); // Agrega las nuevas filas y las dibuja
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        }

        function guardarRegistro() {
            if ($("#formCompromiso").valid()) {
                const formCompromiso = document.getElementById('formCompromiso');
                const formData = new FormData(formCompromiso);

                const url = "{{ route('form.guardarCompromiso') }}";

                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.success = 'success') {

                            Swal.fire({
                                title: '¡Bien hecho!',
                                text: 'Operación realizada exitosamente.',
                                icon: 'success', // 'success', 'error', 'warning', 'info', 'question'
                                confirmButtonText: 'Aceptar'
                            });
                            document.getElementById('saveRegistro').setAttribute('disabled', 'disabled')
                            document.getElementById('newRegistro').style.display = 'initial'
                            document.getElementById('cancelRegistro').style.display = 'none'

                            document.getElementById("accRegistro").value = "guardar"
                            recargarDataTable();
                        } else {
                            Swal.fire({
                                title: '¡Salio mal!',
                                text: 'La operación no pudo ser realizada.',
                                icon: 'warning', // 'success', 'error', 'warning', 'info', 'question'
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error al enviar los datos:", error);
                    });
            }
        }
    </script>
@endsection
