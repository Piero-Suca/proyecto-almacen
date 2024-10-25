@extends('adminlte::page')

@section('title', 'Entrada')

@section('content_header')
    <h1>Entrada</h1>
@stop

@section('content_header')
@stop

@section('content')
    @livewire('admin.entrada-index')
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
            var table = $('#entrada').DataTable({
                responsive: true,
                autoWidth: false,
                "language": {
                    "lengthMenu": " Mostrar _MENU_ registro por página",
                    "zeroRecords": "No se encontró el registro",
                    "info": "Mostrando la pagina _PAGE_ de _PAGES_",
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
                var fecha_retorno= $('#fecha_retorno').val();

                if (fecha_salida && fecha_retorno) {
                    $.ajax({
                        url: '{{ route('entradas.filter') }}',
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
                                data.forEach(function(entrada) {
                                    table.row.add([
                                        entrada.id,
                                        // salida.persona.dni + ": " + salida
                                        // .persona.nombres + " " + salida.persona
                                        // .apellidos,
                                        entrada.articulo.nombre_articulo,
                                        entrada.articulo.marca,
                                        entrada.cantidad,
                                        entrada.fecha_entrada,
                                        entrada.descripcion,
                                        // salida.destino,
                                        // salida.fecha_retorno,
                                        // '<a href="" class="btn btn-warning" data-toggle="modal" data-target="#editModal' +
                                        // salida.id +
                                        // '"><i class="fas fa-edit"></i></a>',
                                        '<form action="{{ route('admin.entrada.destroy', ':id') }}" method="POST">@csrf @method('DELETE')<button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button></form>'
                                    ]).draw(false).node();
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
<script>
    $(document).ready(function() {
    let debounceTimer;
    $('#articulo-input').on('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const query = $(this).val().toLowerCase();
            const suggestions = $('#articulo-suggestions');
            if (query.length > 0) {
                $.ajax({
                    url: '{{ route("admin.articulos.search") }}',
                    method: 'GET',
                    data: { search: query },
                    success: function(data) {
                        suggestions.empty();
                        const seen = new Set();
                        data.forEach(articulo => {
                            const suggestionText = `${articulo.nombre_articulo} : ${articulo.marca}`;
                            if (!seen.has(suggestionText)) {
                                seen.add(suggestionText);
                                const suggestion = $('<div class="autocomplete-suggestion"></div>');
                                suggestion.text(suggestionText);
                                suggestion.data('id', articulo.id);
                                suggestion.data('descripcion', articulo.descripcion); // Almacena la descripción del artículo
                                suggestion.on('click', function() {
                                    $('#articulo-input').val($(this).text());
                                    $('#articulo-id').val($(this).data('id'));
                                    $('#descripcion').val($(this).data('descripcion')); // Llena el campo de descripción
                                    suggestions.empty();
                                });
                                suggestions.append(suggestion);
                            }
                        });
                    },
                    error: function() {
                        suggestions.empty();
                        // Opcionalmente, muestra un mensaje de error al usuario
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudieron cargar los resultados. Intenta de nuevo.'
                        });
                    }
                });
            } else {
                suggestions.empty();
            }
        }, 100);
    });
});
</script>

@stop
