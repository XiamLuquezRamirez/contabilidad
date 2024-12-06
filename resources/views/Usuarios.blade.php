@extends('Plantilla.principal')
@section('title', 'Gestionar usuarios')
@section('Contenido')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Gestionar usuarios</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="{{ url('/') }}">Inicio</a></li>
                        <li class="active">Gestionar usuarios</li>
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
                            <strong class="card-title">Listado de usuariosago</strong>
                        </div>
                        <div class="card-body">
                            <table id="bootstrap-data-table-usuarios" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
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
                    <h5 class="modal-title" id="largeModalLabel">Gestionar usuarios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 id="titUsuario">Agregar usuario</h4>
                            </div>
                            <div class="card-body">
                                <form id="formUsuario">

                                    <input type="hidden" name="idRegistro" id="idRegistro" />
                                    <input type="hidden" name="accRegistro" id="accRegistro" />
                                    <input type="hidden" name="passwOriginal" id="passwOriginal" />
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            placeholder="Ingrese el nombre">
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Usuario:</label>
                                        <input type="text" class="form-control" id="usuario" name="usuario"
                                            placeholder="Ingrese el nombre del usuario">
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Contraseña:</label>
                                        <input type="password" class="form-control" id="pasw" name="pasw">
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Confirmar contraseña:</label>
                                        <input type="password" class="form-control" id="confPasw" name="confPasw">
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
            let menuP = document.getElementById("usuario");
            menuP.classList.add("active");

            $("#formUsuario").validate({
                rules: {
                    nombre: {
                        required: true
                    }
                },
                messages: {

                    concepto: {
                        required: "Por favor, ingrese el concepto."
                    }
                },
                submitHandler: function(form) {
                    guardarRegistro();
                }
            });

            function cargarRegistros() {
                let url = "{{ route('usuario.cargarUsuarios') }}"; 
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
                            const table = $('#bootstrap-data-table-concepto').DataTable();
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

           

            $('#bootstrap-data-table-usuarios').DataTable({
                lengthMenu: [
                    [10, 20, 50, -1],
                    [10, 20, 50, "Todos"]
                ],
                data: [], // Inicialmente vacío
                columns: [{
                        title: "Nombre",
                        data: "nombre_usuario",
                    },
                    {
                        title: "Usuario",
                        data: "login_usuario",
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
                        '<button type="button" class="btn btn-primary" id="addCompanyBtnExport" style="margin-left: 10px;"><li class="fa fa-plus"></li> Agregar concepto</button>';
                    $('#bootstrap-data-table-concepto_filter').append(buttonHtml);

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

            $('#bootstrap-data-table-concepto').on('click', '.editar-btn', function() {
                const idConcepto = $(this).data('id');

                var modal = new bootstrap.Modal(document.getElementById("largeModal"), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
                document.getElementById("accRegistro").value = "editar";

                let url = "{{ route('conceptos.infoConceptos') }}"; 

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

                        document.getElementById("concepto").value = data.nombre_concepto
                        document.getElementById("observacion").value = data.observacion
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

            $('#bootstrap-data-table-concepto').on('click', '.eliminar-btn', function() {
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
                        let url = "{{ route('conceptos.eliminar') }}"; 
                       
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
            const formCompromiso = document.getElementById('formConcepto');
            formConcepto.reset();
            document.getElementById('titConcepto').innerText = 'Agregar Concepto';
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
            let url = "{{ route('conceptos.cargarConceptos') }}"; 
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
                    let table = $('#bootstrap-data-table-concepto').DataTable();
                    table.clear(); // Limpia los datos existentes

                    // Agregar las nuevas filas
                    table.rows.add(data).draw(); // Agrega las nuevas filas y las dibuja
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        }

        function guardarRegistro() {
            if ($("#formConcepto").valid()) {
                const formConcepto = document.getElementById('formConcepto');
                const formData = new FormData(formConcepto);
                
                const url = "{{ route('form.guardarConcepto') }}";

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
