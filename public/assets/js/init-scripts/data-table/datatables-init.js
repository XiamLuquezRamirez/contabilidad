(function ($) {
    "use strict";

    let url = "empresa/cargarEmpresas";

    // Función para cargar datos y actualizar las tablas
    function cargarRegistros() {
        return new Promise((resolve, reject) => {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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

    // Inicializar la tabla principal
    $('#bootstrap-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "Todos"]],
        data: [], // Inicialmente vacío
        columns: [
            { title: "Nombre", data: "nombre" },
            { title: "NIT", data: "nit" },
            { title: "Representante", data: "representante" },
            {
                title: "Opciones",
                data: null, // No está relacionado con datos específicos
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-warning btn-sm editar-btn" data-id="${row.id}">Editar</button>
                        <button class="btn btn-danger btn-sm eliminar-btn" data-id="${row.id}">Eliminar</button>
                        <button class="btn btn-primary btn-sm compromiso-btn" data-id="${row.id}">Asignar compromiso</button>
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
        }
    });

    // Inicializar la tabla de exportación
    $('#bootstrap-data-table-export').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        data: [], // Inicialmente vacío
        columns: [
            { title: "Nombre", data: "nombre" },
            { title: "NIT", data: "nit" },
            { title: "Representante", data: "representante" },
            {
                title: "Opciones",
                data: null, // No está relacionado con datos específicos
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-warning btn-sm editar-btn" data-id="${row.id}"><i class='fa fa-edit'></i> Editar</button>
                        <button class="btn btn-danger btn-sm eliminar-btn" data-id="${row.id}"><i class='fa fa-trash'></i> Eliminar</button>
                        <button class="btn btn-primary btn-sm compromiso-btn" data-id="${row.id}">Asignar compromiso</button>
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
        initComplete: function () {
            const buttonHtml = '<button type="button" class="btn btn-primary" id="addCompanyBtnExport" style="margin-left: 10px;">Agregar Empresa</button>';
            $('#bootstrap-data-table-export_filter').append(buttonHtml);

            $('#addCompanyBtnExport').on('click', function () {
                var modal = new bootstrap.Modal(document.getElementById("largeModal"), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
                nuevoRegistro();
            });
        }
    });


    // Agregar eventos para los botones de la columna Opciones
    $('#bootstrap-data-table-export').on('click', '.editar-btn', function () {
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
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ idEmpresa: idEmpresa })
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
                document.getElementById("tipo_ident_representante").value = data.tipo_ident_representante
                document.getElementById("ident_representante").value = data.ident_representante
                document.getElementById("email").value = data.email


            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un problema al cargar los datos para editar.');
            });



    });

    $('#bootstrap-data-table-export').on('click', '.eliminar-btn', function () {
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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
                                console.log('Registros cargados correctamente');
                            }).catch(error => {
                                console.error('Error al inicializar las tablas:', error);
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

    $('#bootstrap-data-table-export').on('click', '.compromiso-btn', function () {
        const id = $(this).data('id');
        alert(`Asignar compromiso al registro con ID: ${id}`);

    });

    // Llamar a la función para cargar datos al inicializar
    cargarRegistros().then(() => {
        console.log('Registros cargados correctamente');
    }).catch(error => {
        console.error('Error al inicializar las tablas:', error);
    });

})(jQuery);
