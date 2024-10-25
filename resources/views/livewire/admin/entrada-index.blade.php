<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Entradas</title>
    <style>
        .autocomplete-suggestions {
            border: 1px solid #d4d4d4;
            border-top: none;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            z-index: 1000;
            background-color: #fff;
            width: 100%;
        }
        .autocomplete-suggestion {
            padding: 8px;
            cursor: pointer;
        }
        .autocomplete-suggestion:hover {
            background-color: #e9e9e9;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<div class="mt-3">
    @if (session('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: "{{ session('success') }}"
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ $errors->first() }}"
            });
        </script>
    @endif
    <!-- formulario -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                Registro de Entradas
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.entrada.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre Articulo*</label>
                            <input type="text" class="form-control to-uppercase" id="articulo-input" placeholder="Buscar artículo..." autocomplete="off" required style="text-transform: uppercase;">
                            <input type="hidden" name="articulo_id" id="articulo-id">
                            <div id="articulo-suggestions" class="autocomplete-suggestions"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_entrada">Fecha de Entrada*</label>
                            <input type="date" class="form-control" name="fecha_entrada" id="fecha_entrada" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cantidad">Cantidad*</label>
                            <input type="number" class="form-control to-uppercase" name="cantidad" id="cantidad" placeholder="Ingrese la cantidad" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Escriba una descripción" autocomplete="off" readonly>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <a href="{{ route('entrada.pdf') }}" class="btn btn-danger" target="_blank">Exportar Todo</a>
                </div>
            </form>
        </div>
    </div>
    {{-- tabla de entradas --}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title text-center">
                <i class="fas fa-table mr-2"></i>
                Tabla de entradas
            </h3>
            <form id="filterForm" action="{{ route('reporteentrada.pdf') }}" method="GET" target="_blank">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="date" class="form-control" name="fecha_salida" id="fecha_salida" placeholder="Ingrese la fecha de salida" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="date" class="form-control" name="fecha_retorno" id="fecha_retorno" placeholder="Ingrese la fecha de retorno" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary" id="btnFiltrar">Filtrar</button>
                        <button type="search" class="btn btn-danger" target="_blank">Exportar PDF</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table id="entrada" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre Artículo</th>
                        <th>Marca</th>
                        <th>Cantidad</th>
                        <th>Fecha Entrada</th>
                        <th>Descripcion</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entradas as $entrada)
                    <tr>
                        <td>{{ $entrada->id }}</td>
                        <td>{{ $entrada->articulo->nombre_articulo }}</td>
                        <td>{{ $entrada->articulo->marca }}</td>
                        <td>{{ $entrada->cantidad }}</td>
                        <td>{{ $entrada->fecha_entrada }}</td>
                        <td>{{ $entrada->articulo->descripcion }}</td>
                        <td width="10px">
                            <form action="{{ route('admin.entrada.destroy', $entrada->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-button"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <!-- Modal de edición -->
                    {{-- <div class="modal fade" id="editModal{{ $entrada->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $entrada->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModal{{ $entrada->id }}Label">Editar Entrada</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.entrada.update', $entrada->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nombre Artículo</label>
                                            <input type="text" class="form-control" autocomplete="off" value="{{ $entrada->articulo->nombre_articulo . ' : ' . $entrada->articulo->marca }}" disabled>
                                            <input type="hidden" name="articulo_id" value="{{ $entrada->articulo->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="cantidad{{ $entrada->id }}">Cantidad</label>
                                            <input type="text" class="form-control" name="cantidad" id="cantidad{{ $entrada->id }}" value="{{ $entrada->cantidad }}" readonly style="cursor: default;" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_entrada{{ $entrada->id }}">Fecha Entrada</label>
                                            <input type="date" class="form-control" name="fecha_entrada" id="fecha_entrada{{ $entrada->id }}" value="{{ $entrada->fecha_entrada }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                                    const suggestionText = ${articulo.nombre_articulo} : ${articulo.marca};
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
                            }
                        });
                    } else {
                        suggestions.empty();
                    }
                }, 100);
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = document.querySelectorAll('input[type="text"], input[type="date"], input[type="number"]');
            function convertirAMayusculas(input) {
                input.value = input.value.toUpperCase();
            }
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    convertirAMayusculas(this);
                });
            });
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = this;
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminarlo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        // Obtener la fecha actual en formato YYYY-MM-DD
        const today = new Date().toISOString().split('T')[0];
        // Asignar la fecha actual al campo de salida
        document.getElementById('fecha_entrada').value = today;
    </script>
</body>
</html>
