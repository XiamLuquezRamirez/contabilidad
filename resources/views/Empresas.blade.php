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
                                        <div class="col-md-2">
                                            <label for="fechaPresentacion">F. presentación:</label><br />
                                            <input type="date" id="fechaPresentacion" name="fechaPresentacion">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="diasNotificacionPres" class="form-label">Notificación para
                                                presentación:</label>
                                            <input type="number" class="form-control" id="diasNotificacionPres"
                                                name="diasNotificacionPres" min="1"
                                                placeholder="Ingrese la cantidad de días" required>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="estado">Estado:</label><br/>
                                            <select class="form-select" id="estadoPres" name="estadoPres" required>
                                                <option value="pendiente" selected>Pendiente</option>
                                                <option value="presentado">Presentado</option>
                                                <option value="pagado">Pagado</option>
                                                <option value="vencido">Vencido</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="fechaVencimiento">F.vencimiento:</label><br />
                                            <input type="date" id="fechaVencimiento" name="fechaVencimiento">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="diasNotificacionVenc" class="form-label">Notificación para
                                                vencimiento:</label>
                                            <input type="number" class="form-control" id="diasNotificacionVenc"
                                                name="diasNotificacionVenc" min="1"
                                                placeholder="Ingrese la cantidad de días" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="estado">Estado:</label><br/>
                                            <select class="form-select" id="estadoVenc" name="estadoVenc" required>
                                                <option value="pendiente" selected>Pendiente</option>
                                                <option value="presentado">Presentado</option>
                                                <option value="pagado">Pagado</option>
                                                <option value="vencido">Vencido</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="observacion">Observación:</label><br />
                                            <textarea id="observacion" class="form-control" name="observacion" rows="4"
                                                placeholder="Ingrese una observacion del compromiso"></textarea>
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
                                                <th>F. presentación</th>
                                                <th>Estado</th>
                                                <th>F. vencimiento</th>
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

    <div class="modal fade" id="largeModalAsigConcepto" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 65%;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="largeModalLabel">Gestionar asignación de concepto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 id="titEmpresaConcepto">Asignar compromiso </h4>
                            </div>
                            <div class="card-body">

                                <form id="formConcepto" style="display: none;">
                                    <input type="hidden" name="idRegistroConcepto" id="idRegistroConcepto" />
                                    <input type="hidden" name="accRegistroAsigConcepto" id="accRegistroAsigConcepto" />
                                    <input type="hidden" name="idEmpresaConcepto" id="idEmpresaConcepto" />
                                    <input type="hidden" name="conceptoOriginal" id="conceptoOriginal" />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="concepto">Concepto:</label>
                                                <select id="concepto" name="concepto"
                                                    data-placeholder="seleccionar el concepto..." class="standardSelect">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="fechaInicio">Fecha de inicial de pago:</label><br />
                                            <input type="date" id="fechaInicio" name="fechaInicio">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="frecuencia">Frecuencia:</label>
                                            <select id="frecuencia" name="frecuencia" class="form-control">
                                                <option value="">Seleccione la frecuencia de pago</option>
                                                <option value="Mensual">Mensual</option>
                                                <option value="Bimestral">Bimestral</option>
                                                <option value="Trimestral">Trimestral</option>
                                                <option value="Cuatrimestral">Cuatrimestral</option>
                                                <option value="Semestral">Semestral</option>
                                                <option value="Anual">Anual</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="diasNotificacion" class="form-label">Días de anticipación para
                                                notificación</label>
                                            <input type="number" class="form-control" id="diasNotificacion"
                                                name="diasNotificacion" min="1"
                                                placeholder="Ingrese la cantidad de días" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="observacionConcepto">Observación:</label><br />
                                            <textarea id="observacionConcepto" class="form-control" name="observacionConcepto" rows="4"
                                                placeholder="Ingrese una observacion del concepto"></textarea>
                                        </div>

                                    </div>
                                    <div class="card-footer" style="align-items:flex-end">
                                        <button type="button" id="newRegistroConcepto" onclick="nuevoConcepto(0)"
                                            style="display: none;" class="btn btn-secondary"><i class="fa fa-plus"></i>
                                            Nuevo</button>
                                        <button type="button" id="cancelRegistroConcepto" onclick="cancelConcepto()"
                                            class="btn btn-secondary"><i class="fa fa-times"></i> Cancelar</button>
                                        <button type="button" id="saveRegistroConcepto" onclick="guardarConcepto()"
                                            class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                                </form>
                                <div id="listadoConceptos">
                                    <table id="bootstrap-data-table-conceptos" style="width: 100%"
                                        class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Concepto</th>
                                                <th>Fecha de inicio</th>
                                                <th>Frecuencia</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="listadoPagosConceptos" style="display: none;">
                                    <table style="width: 100%" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Mes(es)</th>
                                                <th>Fecha de pago</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="trPagos">
                                        </tbody>
                                    </table>
                                    <div class="card-footer" style="align-items:flex-end">
                                        <button type="button" id="newRegistroConcepto" onclick="backConcepto()"
                                            class="btn btn-secondary"><i class="fa fa-mail-reply-all"></i>
                                            Atras</button>


                                    </div>
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

            
            let urlVer = "{{ route('empresa.verificar-nit') }}"; 
            $("#formEmpresa").validate({
                rules: {
                    nit: {
                        required: true,
                        remote: {
                            url: urlVer, // URL para verificar
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

            let urlVerConcepto = "{{ route('empresa.verificarConceptoEmpresa') }}"; 
            $("#formConcepto").validate({
                rules: {
                    concepto: {
                        required: true,
                        remote: {
                            url: urlVerConcepto, // URL para verificar
                            type: "post",
                            data: {
                                concepto: function() {
                                    return $("#concepto").val();
                                },
                                conceptoOriginal: function() {
                                    return $("#conceptoOriginal").val();
                                },
                                idEmpresaConcepto: function() {
                                    return $("#idEmpresaConcepto").val() ||
                                        null; // Enviar id si es edición
                                },
                                _token: function() {
                                    return "{{ csrf_token() }}"; // Token CSRF para seguridad
                                }
                            }
                        },
                    },
                    fechaInicio: {
                        required: true
                    },
                    frecuencia: {
                        required: true
                    },
                },
                messages: {

                    concepto: {
                        required: "Por favor, seleccione el concepto.",
                        remote: "Este concepto ya está registrado para esta empresa.",
                    },
                    fechaInicio: {
                        required: "Por favor, seleccione la fecha de de pago"
                    },
                    frecuencia: {
                        required: "Por favor, seleccione la frencuencia de pagos."
                    }
                },
                submitHandler: function(form) {
                    guardarConcepto();
                }
            });

            let url = "{{ route('empresa.cargarEmpresas') }}"; 
           
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
                        <button class="btn btn-success btn-sm concepto-btn" data-id="${row.id}"><i class='fa fa-calendar-o'></i> Asignar conceptos</button>

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
                        '<button type="button" class="btn btn-primary" id="addCompanyBtnExport" style="margin-left: 10px;"><li class="fa fa-plus"></li> Agregar empresa</button>';
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
                        data: 'estado_pres'
                    },
                    {
                        data: 'fecha_vencimiento'
                    },
                    {
                        data: 'estado_venc'
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
                        '<button type="button" class="btn btn-primary" id="addCompromiso" style="margin-left: 10px;"><li class="fa fa-plus"></li> Agregar compromiso</button>';
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

                document.getElementById('newRegistroCompromiso').style.display = 'none'
                document.getElementById('saveRegistroCompromiso').removeAttribute('disabled')

                let url = "{{ route('compromiso.infoAsigCompromiso') }}"; 

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
                        document.getElementById("diasNotificacionPres").value = data
                            .dias_anticipacion_pre
                        document.getElementById("fechaVencimiento").value = data.fecha_vencimiento
                        document.getElementById("diasNotificacionVenc").value = data
                            .dias_anticipacion_ven
                        document.getElementById("observacion").value = data.observacion
                        document.getElementById("estadoPres").value = data.estado_pres
                        document.getElementById("estadoVenc").value = data.estado_venc
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un problema al cargar los datos para editar.');
                    });

            });

            $('#bootstrap-data-table-compromisos').on('click', '.eliminarComp-btn', function() {
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
                        let url = "{{ route('compromiso.eliminarAsignacionCompromiso') }}"; 
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
                                    recargarDataTableCompromiso()
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


            // Inicializar tabla conceptos
            $('#bootstrap-data-table-conceptos').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],

                data: [], // Inicialmente vacío               
                columns: [{
                        data: 'concepto'
                    },
                    {
                        data: 'fecha_inicio'
                    },
                    {
                        data: 'frecuencia_pago'
                    },

                    {
                        data: null, // No está relacionado con datos específicos
                        orderable: false,
                        render: function(data, type, row) {
                            return `<div style="display: flex;">
                        <button class="btn btn-success btn-sm pagosConceptos-btn mr-1" data-id="${row.id}"><i class='fa fa-usd'></i> Pagos</button>
                        <button class="btn btn-warning btn-sm editarConcepto-btn mr-1" data-id="${row.id}"><i class='fa fa-edit'></i> Editar</button>
                        <button class="btn btn-danger btn-sm eliminarConcepto-btn" data-id="${row.id}"><i class='fa fa-trash'></i> Eliminar</button>
                    </div>`;
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
                        '<button type="button" class="btn btn-primary" id="addConcepto" style="margin-left: 10px;"><li class="fa fa-plus"></li> Agregar concepto</button>';
                    $('#bootstrap-data-table-conceptos_filter').append(buttonHtml);

                    $('#addConcepto').on('click', function() {
                        document.getElementById('formConcepto').style.display = 'initial'
                        document.getElementById('listadoConceptos').style.display = 'none'
                        let titulo = document.getElementById("nomEmpresa").value
                        document.getElementById("titEmpresaConcepto").innerHTML =
                            `Asignar conceptos para ${titulo}`

                        document.getElementById('saveRegistroConcepto').removeAttribute(
                            'disabled')
                        document.getElementById('newRegistroConcepto').style.display =
                            'none'
                        document.getElementById('cancelRegistroConcepto').style.display =
                            'initial'

                    });
                }
            });

            $('#bootstrap-data-table-conceptos').on('click', '.editarConcepto-btn', function() {
                const idConcepto = $(this).data('id');
                document.getElementById('formConcepto').style.display = 'initial'
                document.getElementById('listadoConceptos').style.display = 'none'
                document.getElementById('accRegistroAsigConcepto').value = 'editar'

                document.getElementById('newRegistroConcepto').style.display = 'none'
                document.getElementById('saveRegistroConcepto').removeAttribute('disabled')

                let url = "{{ route('conceptos.infoAsigConceptos') }}"; 

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            idConcepto: idConcepto
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al obtener los datos del registro')
                        }
                        return response.json();
                    })
                    .then(data => {

                        document.getElementById("idEmpresaConcepto").value = data.id_empresa
                        document.getElementById("idRegistroConcepto").value = data.id
                        document.getElementById("concepto").value = data.id_concepto_pago
                        document.getElementById("conceptoOriginal").value = data.id_concepto_pago
                        document.getElementById("fechaInicio").value = data.fecha_inicio
                        document.getElementById("frecuencia").value = data.frecuencia_pago
                        document.getElementById("diasNotificacion").value = data.dias_anticipacion
                        document.getElementById("observacionConcepto").value = data.observacion

                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un problema al cargar los datos para editar.');
                    });

            });

            $('#bootstrap-data-table-conceptos').on('click', '.eliminarConcepto-btn', function() {
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
                        let url = "{{ route('conceptos.eliminarAsignacionConcepto') }}"; 
                       
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
                                    recargarDataTableConcepto()
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


            $('#bootstrap-data-table-conceptos').on('click', '.pagosConceptos-btn', function() {
                const idConcepto = $(this).data('id');

                let titulo = document.getElementById("nomEmpresa").value
                document.getElementById("titEmpresaConcepto").innerHTML =
                    `Pagos de conceptos asignado para ${titulo}`

                document.getElementById('listadoConceptos').style.display = 'none'
                document.getElementById('listadoPagosConceptos').style.display = 'initial'

                let url = "{{ route('conceptos.pagosConceptos') }}"; 
                
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            idConcepto: idConcepto
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al obtener los datos del registro');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const tbody = document.getElementById('trPagos');
                        tbody.innerHTML = ''; // Limpiar contenido previo

                        data.forEach(item => {
                            const [year, month, day] = item.fecha_pago.split('-');
                            const fechaPago = new Date(year, month - 1,
                                day); // Crear fecha sin zona horaria

                            // Calcular los meses según la frecuencia
                            const periodo = calcularPeriodo(fechaPago, item
                                .frecuencia_pago);

                            const row = document.createElement('tr');
                            row.innerHTML = `
                            <td>${periodo}</td>
                            <td>${item.fecha_pago}</td>
                            <td>
                                <select class="estado-select" data-id="${item.id}">
                                    <option value="pendiente" ${item.estado === 'pendiente' ? 'selected' : ''}>Pendiente</option>
                                    <option value="pagado" ${item.estado === 'pagado' ? 'selected' : ''}>Pagado</option>
                                    <option value="N/A" ${item.estado === 'N/A' ? 'selected' : ''}>N/A</option>
                                </select>
                               ${
                                item.estado === 'pagado' 
                                ? '<i class="estado-icon fa fa-check icono-verde"></i>' 
                                : item.estado === 'N/A' 
                                    ? '<i class="estado-icon fa fa-times icono-rojo"></i>' 
                                    : ''
                            }
                            </td>`;
                            tbody.appendChild(row);
                        });

                        // Agregar evento para actualizar estado
                        document.querySelectorAll('.estado-select').forEach(select => {
                            select.addEventListener('change', function() {
                                const idPago = this.dataset.id;
                                const nuevoEstado = this.value;

                                // Actualizar el estado visualmente
                                const icono = this.nextElementSibling;
                                if (nuevoEstado === 'pagado') {
                                    icono.className =
                                        'estado-icon fa fa-check icono-verde';
                                } else if (nuevoEstado === 'N/A') {
                                    icono.className =
                                        'estado-icon fa fa-times icono-rojo';
                                } else {
                                    icono.className = ''; // Ocultar ícono
                                }

                                // Actualizar el estado en la base de datos
                                actualizarEstado(idPago, nuevoEstado);
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un problema al cargar los datos para editar.');
                    });
            });

            // Función para calcular los meses según la frecuencia
            function calcularPeriodo(fechaPago, frecuencia) {
                const nombreMeses = [
                    'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                    'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
                ];
                const mesInicio = fechaPago.getMonth();
                let periodo = '';

                switch (frecuencia) {
                    case 'Mensual':
                        periodo = nombreMeses[mesInicio];
                        break;
                    case 'Bimestral':
                        periodo = `${nombreMeses[mesInicio]}-${nombreMeses[(mesInicio + 1) % 12]}`;
                        break;
                    case 'Trimestral':
                        periodo = `${nombreMeses[mesInicio]}-${nombreMeses[(mesInicio + 2) % 12]}`;
                        break;
                    case 'Semestral':
                        periodo = `${nombreMeses[mesInicio]}-${nombreMeses[(mesInicio + 5) % 12]}`;
                        break;
                    case 'Anual':
                        periodo = `${nombreMeses[mesInicio]}-${nombreMeses[(mesInicio + 11) % 12]}`;
                        break;
                    default:
                        periodo = nombreMeses[mesInicio]; // Por defecto, tratar como mensual
                }

                return periodo.charAt(0).toUpperCase() + periodo.slice(1); // Capitalizar primera letra
            }

            // Función para actualizar estado en la base de datos
            function actualizarEstado(idPago, nuevoEstado) {
                let url = "{{ route('conceptos.actualizarEstado') }}";               
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            idPago: idPago,
                            estado: nuevoEstado
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al actualizar el estado');
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire(
                            '¡Actualizado!',
                            'El estado fue cambiado exitosamento.',
                            'success'
                        )
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un problema al actualizar el estado.');
                    });
            }
            // Agregar eventos para los botones de la columna Opciones
            $('#bootstrap-data-table-export').on('click', '.editar-btn', function() {
                const idEmpresa = $(this).data('id');

                var modal = new bootstrap.Modal(document.getElementById("largeModal"), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
                document.getElementById("accRegistro").value = "editar";

                let url = "{{ route('empresa.infoEmpresa') }}";  

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
                        let url = "{{ route('empresa.eliminar') }}";  
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
                recargarDataTableCompromiso()
            });

            $('#bootstrap-data-table-export').on('click', '.concepto-btn', function() {
                const idEmpresa = $(this).data('id');
                document.getElementById("idEmpresaConcepto").value = idEmpresa

                const row = $(this).closest('tr');

                // Obtener el texto de la primera celda
                const descripcion = row.find('td:first').text();
                document.getElementById("nomEmpresa").value = descripcion
                document.getElementById("titEmpresaConcepto").innerHTML =
                    `Conceptos asignados para ${descripcion}`

                var modal = new bootstrap.Modal(document.getElementById("largeModalAsigConcepto"), {
                    backdrop: 'static',
                    keyboard: false
                })
                modal.show()
                nuevoConcepto(1)
                cargarConcepto()
                recargarDataTableConcepto()
            });

        });


        function cancelCompromiso() {
            const formCompromiso = document.getElementById('formCompromiso');
            formCompromiso.reset();
            document.getElementById('formCompromiso').style.display = 'none'
            document.getElementById('listadoCompromisos').style.display = 'initial'

        }

        function cancelConcepto() {
            const formConcepto = document.getElementById('formConcepto');
            formCompromiso.reset();
            document.getElementById('formConcepto').style.display = 'none'
            document.getElementById('listadoConceptos').style.display = 'initial'

        }

        function backConcepto() {
            document.getElementById('listadoPagosConceptos').style.display = 'none'
            document.getElementById('listadoConceptos').style.display = 'initial'
        }

        function nuevoConcepto(op) {
            const formConcepto = document.getElementById('formConcepto');
            formConcepto.reset();
            document.getElementById('accRegistroAsigConcepto').value = 'guardar'

            if (op == 1) {
                document.getElementById('formConcepto').style.display = 'none'
                document.getElementById('listadoConceptos').style.display = 'initial'
            }

            document.getElementById('saveRegistroConcepto').removeAttribute('disabled')
            document.getElementById('newRegistroConcepto').style.display = 'none'
            document.getElementById('cancelRegistroConcepto').style.display = 'initial'

            let titulo = document.getElementById("nomEmpresa").value
            document.getElementById("titEmpresaConcepto").innerHTML = `Asignar concepto para ${titulo}`

        }

        function nuevoCompromiso(op) {
            const formCompromiso = document.getElementById('formCompromiso');
            formCompromiso.reset();
            document.getElementById('accRegistroAsig').value = 'guardar'

            if (op == 1) {
                document.getElementById('formCompromiso').style.display = 'none'
                document.getElementById('listadoCompromisos').style.display = 'initial'

            }

            document.getElementById('saveRegistroCompromiso').removeAttribute('disabled')
            document.getElementById('newRegistroCompromiso').style.display = 'none'
            document.getElementById('cancelRegistroCompromiso').style.display = 'initial'

            let titulo = document.getElementById("nomEmpresa").value
            document.getElementById("titEmpresaAsignar").innerHTML = `Asignar compromisos para ${titulo}`

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

        function cargarConcepto() {
            return new Promise((resolve, reject) => {
                let select = document.getElementById("concepto")
                select.style.width = '100%'
                select.innerHTML = ''
                let url = "{{ route('conceptos.listConcepto') }}"

                let defaultOption = document.createElement("option")
                defaultOption.value = "" // Valor en blanco
                defaultOption.text = "Selecciona una opción" // Texto que se mostrará
                defaultOption.disabled = true // Deshabilitar para que no pueda ser seleccionada
                defaultOption.selected = true // Que aparezca seleccionada por defecto
                select.appendChild(defaultOption)

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(concepto => {

                            let option = document.createElement("option");
                            option.value = concepto.id;
                            option.text = concepto.nombre_concepto;

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

            let url = "{{ route('empresa.cargarEmpresas') }}";  

            fetch(url, {
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
            let url = "{{ route('compromiso.cargarAsigCompromiso') }}";  
            fetch(url, {
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

        function recargarDataTableConcepto() {

            let idEmpresa = document.getElementById("idEmpresaConcepto").value
            let url = "{{ route('conceptos.cargarAsigConcepto') }}"; 
            fetch(url, {
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
                    let table = $('#bootstrap-data-table-conceptos').DataTable();
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
                            //document.getElementById('cancelRegistroCompromiso').style.display = 'none'

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

        function guardarConcepto() {
            if ($("#formConcepto ").valid()) {
                const formConcepto = document.getElementById('formConcepto');
                const formData = new FormData(formConcepto);

                const url = "{{ route('form.guardarAsigConcepto') }}";

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
                            document.getElementById('saveRegistroConcepto').setAttribute('disabled', 'disabled')
                            document.getElementById('newRegistroConcepto').style.display = 'initial'
                            // document.getElementById('cancelRegistroConcepto').style.display = 'none'

                            document.getElementById("accRegistroAsigConcepto").value = "guardar"
                            recargarDataTableConcepto();
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
