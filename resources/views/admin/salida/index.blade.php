@extends('adminlte::page')

@section('title', 'Salida')

@section('content_header')
    <h1>Salida</h1>
@stop

@section('content_header')
@stop

@section('content')
    @livewire('admin.salida-index')
@stop

{{-- @section('footer')
    <div class="footer text-center py-3">
        © 2024 Todos los derechos reservados.
    </div>
@stop --}}

@section('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
@stop


@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#salida').DataTable({
                responsive: true,
                autoWidth: false,
                "language": {
                    "lengthMenu": " Mostrar _MENU_ registro por página",
                    "zeroRecords": "No se encontró el registro",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                    "search": "Buscar",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
    
            $('#btnFiltrar').on('click', function() {
                var fecha_salida = $('#fecha_salida').val();
                var fecha_retorno = $('#fecha_retorno').val();
    
                if (fecha_salida && fecha_retorno) {
                    $.ajax({
                        url: '{{ route('salidas.filter') }}',
                        method: 'GET',
                        data: {
                            fecha_salida: fecha_salida,
                            fecha_retorno: fecha_retorno
                        },
                        success: function(data) {
                            // Limpiar la tabla antes de actualizar
                            table.clear().draw();
    
                            if (data.message) {
                                alert(data.message);
                            } else {
                                // Agregar las filas actualizadas
                                data.forEach(function(salida) {
                                    var devolucionBtnClass = salida.devuelto ? 'btn-success' : 'btn-danger';
                                    var devolucionIcon = salida.devuelto ? 'fa-check' : 'fa-times';
                                    var disabledAttribute = salida.devuelto ? 'disabled' : '';
    
                                    var rowNode = table.row.add([
                                        salida.id,
                                        salida.persona.dni + ": " + salida.persona.nombres + " " + salida.persona.apellidos,
                                        salida.articulo.nombre_articulo + " : " + salida.articulo.marca,
                                        salida.cantidad,
                                        salida.fecha_salida,
                                        salida.destino,
                                        salida.condicion,
                                        salida.fecha_retorno ? new Date(salida.fecha_retorno).toLocaleDateString() : '', // Mostrar fecha_retorno si existe
                                        '<a href="" class="btn btn-warning" data-toggle="modal" data-target="#editModal' + salida.id + '"><i class="fas fa-edit"></i></a>',                                    
                                        '<form class="devolucion-form" action="{{ route('admin.salida.devoluciones', ':id') }}'.replace(':id', salida.id) + '" method="POST">@csrf<button type="submit" class="btn ' + devolucionBtnClass + '" ' + disabledAttribute + '><i class="fas ' + devolucionIcon + '"></i></button></form>',
                                        '<form action="{{ route('admin.salida.destroy', ':id') }}" method="POST">@csrf @method('DELETE')<button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button></form>'
                                    ]).draw(false).node();
                                });
    
                                // Rebind the submit event to the new form elements
                                $('.devolucion-form').on('submit', function(e) {
                                    e.preventDefault();
    
                                    var form = $(this);
                                    var url = form.attr('action');
    
                                    $.ajax({
                                        type: 'POST',
                                        url: url,
                                        data: form.serialize(),
                                        success: function(response) {
                                            if (response.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: '¡Éxito!',
                                                    text: response.success,
                                                    allowOutsideClick: false // Evitar que el usuario cierre el cuadro de diálogo
                                                }).then(function() {
                                                    var button = form.find('button');
                                                    button.removeClass('btn-danger').addClass('btn-success');
                                                    button.html('<i class="fas fa-check"></i>');
                                                    button.prop('disabled', true); // Deshabilitar el botón
                                                    
                                                    // Actualizar la fecha de retorno en la tabla
                                                    var rowIndex = table.row(form.closest('tr')).index();
                                                    var cellIndex = table.cell(rowIndex, 6).node();
                                                    $(cellIndex).html(new Date().toLocaleDateString()); // Actualizar la fecha de retorno con la fecha actual
                                                });
                                            }
                                        },
                                        error: function(response) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'Error al devolver el artículo.'
                                            });
                                        }
                                    });
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    alert('Seleccione fechas válidas para filtrar.');
                }
            });
        });
    </script>
    


@stop
