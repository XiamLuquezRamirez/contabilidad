@extends('Plantilla.principal')
@section('title', 'Gestionar empresas')
@section('Contenido')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Gestionar empresas</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="{{ url('/') }}">Inicio</a></li>
                        <li class="active">Gestionar empresas</li>
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
                            <strong class="card-title">Listado de empresas</strong>
                        </div>
                        <div class="card-body">
                            <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>NIT</th>
                                        <th>Representante</th>
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
                    <h5 class="modal-title" id="largeModalLabel">Gestionar empresa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 id="titEmpresa">Agregar empresa</h4>
                            </div>
                            <div class="card-body">
                                <form id="formEmpresa">

                                    <input type="hidden" name="idRegistro" id="idRegistro" />
                                    <input type="hidden" name="accRegistro" id="accRegistro" />
                                    <input type="hidden" name="nitOriginal" id="nitOriginal" />
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            placeholder="Ingrese el nombre">
                                    </div>
                                    <div class="form-group">
                                        <label for="nit">NIT</label>
                                        <input type="text" class="form-control" id="nit" name="nit"
                                            placeholder="Ingrese el NIT">
                                    </div>
                                    <div class="form-group">
                                        <label for="representante">Representante</label>
                                        <input type="text" class="form-control" id="representante" name="representante"
                                            placeholder="Ingrese el nombre del representante">
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_ident_representante">Tipo de Identificación del
                                            Representante</label>
                                        <select class="form-control" id="tipo_ident_representante"
                                            name="tipo_ident_representante">
                                            <option value="">Seleccione el tipo de identificación</option>
                                            <option value="cc">Cédula de Ciudadanía</option>
                                            <option value="ce">Cédula de Extranjería</option>
                                            <option value="pp">Pasaporte</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ident_representante">Número de Identificación del Representante</label>
                                        <input type="text" class="form-control" id="ident_representante"
                                            name="ident_representante" placeholder="Ingrese el número de identificación">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Ingrese el correo electrónico">
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
    <div class="modal fade" id="largeModalAsigCompromiso" tabindex="-1" role="dialog"
        aria-labelledby="largeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 60%;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="largeModalLabel">Gestionar asignación de compromisos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 id="titEmpresaAsignar">Asignar compromiso </h4>
                            </div>
                            <div class="card-body">

                                <form id="formCompromiso" style="display: none;">
                                    <input type="hidden" name="idRegistroAsig" id="idRegistroAsig" />
                                    <input type="hidden" name="accRegistroAsig" id="accRegistroAsig" />
                                    <input type="hidden" name="nomEmpresa" id="nomEmpresa" />
                                    <input type="hidden" name="idEmpresa" id="idEmpresa" />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="compromiso">Compromiso:</label>
                                                <select id="compromiso" name="compromiso"
                                                    data-placeholder="seleccionar compromiso..." class="standardSelect">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="fechaPresentacion">Fecha de presentación:</label>
                                            <input type="date" id="fechaPresentacion" name="fechaPresentacion">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="fechaVencimiento">Fecha de vencimiento:</label>
                                            <input type="date" id="fechaVencimiento" name="fechaVencimiento">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="observacion">Observación:</label><br />
                                            <textarea id="observacion" class="form-control" name="observacion" rows="4"
                                                placeholder="Ingrese una observacion del compromiso"></textarea>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="estado">Estado:</label>
                                            <select class="form-select" id="estado" name="estado" required>
                                                <option value="pendiente" selected>Pendiente</option>
                                                <option value="presentado">Presentado</option>
                                                <option value="pagado">Pagado</option>
                                                <option value="vencido">Vencido</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-footer" style="align-items:flex-end">
                                        <button type="button" id="newRegistroCompromiso" onclick="nuevoCompromiso(0)"
                                            style="display: none;" class="btn btn-secondary"><i class="fa fa-plus"></i>
                                            Nuevo</button>
                                        <button type="button" id="cancelRegistroCompromiso" onclick="cancelCompromiso()"
                                            class="btn btn-secondary"><i class="fa fa-times"></i> Cancelar</button>
                                        <button type="button" id="saveRegistroCompromiso" onclick="guardarCompromiso()"
                                            class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                                </form>
                                <div id="listadoCompromisos">
                                    <table id="bootstrap-data-table-compromisos" style="width: 100%"
                                        class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Fecha de presentación</th>
                                                <th>Fecha de vencimiento</th>
                                                <th>Estado</th>
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
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            let menuP = document.getElementById("empresa");
            menuP.classList.add("active");

            $("#formEmpresa").validate({
                rules: {
                    nit: {
                        required: true,
                        remote: {
                            url: "/verificar-nit", // URL para verificar
                            type: "post",
                            data: {
                                nit: function() {
                                    return $("#nit").val();
                                },
                                nitOriginal: function() {
                                    return $("#nitOriginal").val() ||
                                        null; // Enviar id si es edición
                                },
                                _token: function() {
                                    return "{{ csrf_token() }}"; // Token CSRF para seguridad
                                }
                            }
                        },
                        minlength: 5,
                        maxlength: 20
                    },
                    nombre: {
                        required: true
                    },
                    representante: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                },
                messages: {
                    nit: {
                        required: "Por favor, ingresa el NIT.",
                        remote: "Este NIT ya está registrado.",
                        minlength: "El NIT debe tener al menos 5 caracteres.",
                        maxlength: "El NIT no puede exceder los 20 caracteres."
                    },
                    nombre: {
                        required: "Por favor, ingrese el nombre de al empresa o consorcio."
                    },
                    representante: {
                        required: "Por favor, ingrese el nombre del representante legal."
                    },
                    email: {
                        required: "Por favor, ingresa un email.",
                        email: "Por favor, ingresa un email válido."
                    }
                },
                submitHandler: function(form) {
                    guardarEmpresa();
                }
            });

            $("#formCompromiso").validate({
                rules: {

                    compromiso: {
                        required: true
                    },
                    fechaPresentacion: {
                        required: true
                    },
                    fechaVencimiento: {
                        required: true
                    },
                },
                messages: {

                    compromiso: {
                        required: "Por favor, seleccione el compromiso."
                    },
                    fechaPresentacion: {
                        required: "Por favor, seleccione la fecha de presentación"
                    },
                    fechaVencimiento: {
                        required: "Por favor, seleccione la fecha de vencimiento.",
                    }
                },
                submitHandler: function(form) {
                    guardarCompromiso();
                }
            });

            let url = "empresa/cargarEmpresas";


            function cargarRegistros() {
                return new Promise((resolve, reject) => {
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
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
                            const table = $('#bootstrap-data-table').DataTable();
                            table.clear();
                            table.rows.add(data).draw();

                            // Agregar datos a la tabla de exportación
                            const exportTable = $('#bootstrap-data-table-export').DataTable();
                            exportTable.clear();
                            exportTable.rows.add(data).draw();

                            resolve();
                        })
                        .catch(error => {
                            console.error('Error al cargar los registros:', error);
                            reject(error);
                        });
                });
            }

            cargarRegistros().then(() => {
                console.log('Registros cargados correctamente');
            }).catch(error => {
                console.error('Error al inicializar las tablas:', error);
            });

            // Inicializar tabla emprsas
            $('#bootstrap-data-table-export').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                data: [], // Inicialmente vacío
                columns: [{
                        title: "Nombre",
                        data: "nombre"
                    },
                    {
                        title: "NIT",
                        data: "nit"
                    },
                    {
                        title: "Representante",
                        data: "representante"
                    },
                    {
                        title: "Opciones",
                        data: null, // No está relacionado con datos específicos
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-warning btn-sm editar-btn" data-id="${row.id}"><i class='fa fa-edit'></i> Editar</button>
                        <button class="btn btn-danger btn-sm eliminar-btn" data-id="${row.id}"><i class='fa fa-trash'></i> Eliminar</button>
                        <button class="btn btn-primary btn-sm compromiso-btn" data-id="${row.id}"><i class='fa fa-calendar-o'></i> Asignar compromiso</button>
                    `;
                        }
                    }
                ],
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
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
                        '<button type="button" class="btn btn-primary" id="addCompanyBtnExport" style="margin-left: 10px;">Agregar empresa</button>';
                    $('#bootstrap-data-table-export_filter').append(buttonHtml);

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
            // Inicializar tabla compromisos
            $('#bootstrap-data-table-compromisos').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                data: [], // Inicialmente vacío               
                columns: [{
                        data: 'descripcion'
                    },
                    {
                        data: 'fecha_presentacion'
                    },
                    {
                        data: 'fecha_vencimiento'
                    },
                    {
                        data: 'estado'
                    },
                    {
                        data: null, // No está relacionado con datos específicos
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-warning btn-sm editarComp-btn" data-id="${row.id}"><i class='fa fa-edit'></i> Editar</button>
                        <button class="btn btn-danger btn-sm eliminarComp-btn" data-id="${row.id}"><i class='fa fa-trash'></i> Eliminar</button>
                    `;
                        }
                    }
                ],
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
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
                        '<button type="button" class="btn btn-primary" id="addCompromiso" style="margin-left: 10px;">Agregar compromiso</button>';
                    $('#bootstrap-data-table-compromisos_filter').append(buttonHtml);

                    $('#addCompromiso').on('click', function() {
                        document.getElementById('formCompromiso').style.display = 'initial'
                        document.getElementById('listadoCompromisos').style.display = 'none'
                        let titulo = document.getElementById("nomEmpresa").value
                        document.getElementById("titEmpresaAsignar").innerHTML =
                            `Asignar compromisos para ${titulo}`

                        document.getElementById('saveRegistroCompromiso').removeAttribute(
                            'disabled')
                        document.getElementById('newRegistroCompromiso').style.display =
                            'none'
                        document.getElementById('cancelRegistroCompromiso').style.display =
                            'initial'

                    });
                }
            });

            $('#bootstrap-data-table-compromisos').on('click', '.editarComp-btn', function() {
                const idComp = $(this).data('id');
                document.getElementById('formCompromiso').style.display = 'initial'
                document.getElementById('listadoCompromisos').style.display = 'none'
                document.getElementById('accRegistroAsig').value = 'editar'

                const url = "compromiso/infoAsigCompromiso";

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            idComp: idComp
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al obtener los datos del registro')
                        }
                        return response.json();
                    })
                    .then(data => {

                        document.getElementById("idEmpresa").value = data.empresa
                        document.getElementById("idRegistroAsig").value = data.id
                        document.getElementById("compromiso").value = data.compromiso
                        document.getElementById("fechaPresentacion").value = data.fecha_presentacion
                        document.getElementById("fechaVencimiento").value = data.fecha_vencimiento
                        document.getElementById("observacion").value = data.observacion
                        document.getElementById("estado").value = data.estado
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un problema al cargar los datos para editar.');
                    });

            });

            $('#bootstrap-data-table-compromisos').on('click', '.eliminarComp-btn', function() {
                const id = $(this).data('id');

            });

            // Agregar eventos para los botones de la columna Opciones
            $('#bootstrap-data-table-export').on('click', '.editar-btn', function() {
                const idEmpresa = $(this).data('id');

                var modal = new bootstrap.Modal(document.getElementById("largeModal"), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
                document.getElementById("accRegistro").value = "editar";

                const url = "empresa/infoEmpresa";

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            idEmpresa: idEmpresa
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al obtener los datos del registro')
                        }
                        return response.json();
                    })
                    .then(data => {

                        document.getElementById("idRegistro").value = data.id
                        document.getElementById("nitOriginal").value = data.nit
                        document.getElementById("nombre").value = data.nombre
                        document.getElementById("nit").value = data.nit
                        document.getElementById("representante").value = data.representante
                        document.getElementById("tipo_ident_representante").value = data
                            .tipo_ident_representante
                        document.getElementById("ident_representante").value = data
                            .ident_representante
                        document.getElementById("email").value = data.email


                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un problema al cargar los datos para editar.');
                    });
            });

            $('#bootstrap-data-table-export').on('click', '.eliminar-btn', function() {
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
                        let url = "/empresa/eliminar";
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
                                    cargarRegistros().then(() => {
                                        console.log(
                                            'Registros cargados correctamente');
                                    }).catch(error => {
                                        console.error(
                                            'Error al inicializar las tablas:',
                                            error);
                                    });
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

            $('#bootstrap-data-table-export').on('click', '.compromiso-btn', function() {
                const idEmpresa = $(this).data('id');
                document.getElementById("idEmpresa").value = idEmpresa

                const row = $(this).closest('tr');

                // Obtener el texto de la primera celda
                const descripcion = row.find('td:first').text();
                document.getElementById("nomEmpresa").value = descripcion
                document.getElementById("titEmpresaAsignar").innerHTML =
                    `Compromisos asignados para ${descripcion}`

                var modal = new bootstrap.Modal(document.getElementById("largeModalAsigCompromiso"), {
                    backdrop: 'static',
                    keyboard: false
                })
                modal.show()
                nuevoCompromiso(1)
                cargarCompromiso()
                cargarCompromisoEmpresa() // compromisos asignados
                recargarDataTableCompromiso()
            });

        });


        function cancelCompromiso() {
            const formCompromiso = document.getElementById('formCompromiso');
            formCompromiso.reset();
            document.getElementById('formCompromiso').style.display = 'none'
            document.getElementById('listadoCompromisos').style.display = 'initial'

        }

        function nuevoCompromiso(op) {
            const formCompromiso = document.getElementById('formCompromiso');
            formCompromiso.reset();
            document.getElementById('accRegistroAsig').value = 'guardar'

            if (op == 1) {
                document.getElementById('formCompromiso').style.display = 'none'
                document.getElementById('listadoCompromisos').style.display = 'initial'

            }

            document.getElementById('saveRegistro').removeAttribute('disabled')
            document.getElementById('newRegistro').style.display = 'none'
            document.getElementById('cancelRegistro').style.display = 'initial'

            let titulo = document.getElementById("nomEmpresa").value
            document.getElementById("titEmpresaAsignar").innerHTML = `Asignar compromisos para ${titulo}`

        }

        function cargarCompromisoEmpresa() {

        }

        function cancelRegistro() {
            const formEmpresa = document.getElementById('formEmpresa');
            formEmpresa.reset();
            document.getElementById('titEmpresa').innerText = 'Agregar empresa';
            document.getElementById('accRegistro').value = 'guardar'


        }

        function cargarCompromiso() {
            return new Promise((resolve, reject) => {
                let select = document.getElementById("compromiso")
                select.style.width = '100%'
                select.innerHTML = ''
                let url = "{{ route('compromiso.listCompromiso') }}"

                console.log(select);

                let defaultOption = document.createElement("option")
                defaultOption.value = "" // Valor en blanco
                defaultOption.text = "Selecciona una opción" // Texto que se mostrará
                defaultOption.disabled = true // Deshabilitar para que no pueda ser seleccionada
                defaultOption.selected = true // Que aparezca seleccionada por defecto
                select.appendChild(defaultOption)

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(compromiso => {

                            let option = document.createElement("option");
                            option.value = compromiso.id;
                            option.text = compromiso.descripcion;

                            select.appendChild(option);
                        });
                        resolve(); // Resuelve la promesa cuando los datos han sido cargados
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        reject(error); // Rechaza la promesa si ocurre un error
                    });
            });
        }

        function nuevoRegistro() {
            cancelRegistro()
            document.getElementById('accRegistro').value = 'guardar'
            document.getElementById('saveRegistro').removeAttribute('disabled')
            document.getElementById('newRegistro').style.display = 'none'
            document.getElementById('cancelRegistro').style.display = 'initial'
        }

        function recargarDataTable() {
            fetch("empresa/cargarEmpresas", {
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
                    let table = $('#bootstrap-data-table-export').DataTable();
                    table.clear(); // Limpia los datos existentes

                    // Agregar las nuevas filas
                    table.rows.add(data).draw(); // Agrega las nuevas filas y las dibuja
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        }

        function recargarDataTableCompromiso() {

            let idEmpresa = document.getElementById("idEmpresa").value
            fetch("compromiso/cargarAsigCompromiso", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        idEmpresa: idEmpresa
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Error al cargar los datos");
                    }
                    return response.json();
                })
                .then(data => {
                    // Limpiar el DataTable actual
                    let table = $('#bootstrap-data-table-compromisos').DataTable();
                    table.clear(); // Limpia los datos existentes

                    // Agregar las nuevas filas
                    table.rows.add(data).draw(); // Agrega las nuevas filas y las dibuja
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        }

        function guardarRegistro() {
            if ($("#formEmpresa").valid()) {
                const formEmpresa = document.getElementById('formEmpresa');
                const formData = new FormData(formEmpresa);

                const url = "{{ route('form.guardarEmpresa') }}";

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

        function guardarCompromiso() {
            if ($("#formCompromiso").valid()) {
                const formCompromiso = document.getElementById('formCompromiso');
                const formData = new FormData(formCompromiso);

                const url = "{{ route('form.guardarAsigCompromiso') }}";

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
                            document.getElementById('saveRegistroCompromiso').setAttribute('disabled', 'disabled')
                            document.getElementById('newRegistroCompromiso').style.display = 'initial'
                            document.getElementById('cancelRegistroCompromiso').style.display = 'none'

                            document.getElementById("accRegistroAsig").value = "guardar"
                            recargarDataTableCompromiso();
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
