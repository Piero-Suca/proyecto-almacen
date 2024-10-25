<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Salidas</title>
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

        .small-icon-text {
            font-size: 0.75rem; /* Ajusta este valor según tus necesidades */
            display: flex;
            align-items: center;
            }
        .small-icon-text i {
            font-size: 0.75rem; /* Ajusta este valor según tus necesidades */
            margin-right: 0.25rem; /* Espacio entre el ícono y el texto */
            }
    </style>
</head>
<body>
    <div class="mt-3">
        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
    
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: "{{ session('success') }}"
            });
        </script>
    @endif
    
    @if($errors->any())
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
                Registro de Salidas
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.salida.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Datos Persona*</label>
                            <input type="text" class="form-control" id="persona-input" placeholder="Escriba para buscar..." autocomplete="off" required>
                            <input type="hidden" name="persona_dni" id="persona-dni">
                            <div id="persona-suggestions" class="autocomplete-suggestions"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre Articulo*</label>
                            <input type="text" class="form-control" id="articulo-input" placeholder="Buscar artículo..." autocomplete="off" required>
                            <input type="hidden" name="articulo_id" id="articulo-id">
                            <div id="articulo-suggestions" class="autocomplete-suggestions"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cantidad">Cantidad*</label>
                            <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="Ingrese la cantidad" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_salida">Fecha de Salida*</label>
                            <input type="date" class="form-control" name="fecha_salida" id="fecha_salida" placeholder="Ingrese la fecha de salida" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="condicion">Estado*</label>
                            <select class="form-control" name="condicion" id="condicion" required>
                                <option value="" disabled selected>Seleccione el estado</option>
                                <option value="BUENAS CONDICIONES">BUENAS CONDICIONES</option>
                                <option value="NUEVO">NUEVO</option>
                                <option value="USADO">USADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="destino">Destino*</label>
                                <input type="text" class="form-control" name="destino" id="destino" placeholder="Ingrese el lugar de destino" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-2">Registrar</button>
                    <a href="{{ route('salida.pdf') }}" class="btn btn-danger" target="_blank">Exportar Todo</a>
                </div>
            </form>
        </div>
    </div>
    {{-- tabla de cursos--}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title text-center">
                <i class="fas fa-table mr-2"></i>
                Tabla de salidas
            </h3>
            <form id="filterForm" action="{{ route('reporte.pdf') }}" method="GET" target="_blank">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="date" class="form-control" name="fecha_salida" id="fecha_salida" placeholder="Ingrese la fecha de salida" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="date" class="form-control" name="fecha_retorno" id="fecha_retorno" placeholder="Ingrese la fecha de retorno">
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <button type="button" class="btn btn-primary mr-2" id="btnFiltrar">Filtrar</button>
                        <button type="search" class="btn btn-danger mr-2" target="_blank">Exportar PDF</button>
                        <button type="button" class="btn btn-secondary ml-auto" id="btnRefrescar">Refrescar</button>
                    </div>
                </div>
            </form> 
        </div>
        <div class="card-body">
            <table id="salida" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Datos Persona</th>
                        <th>Datos Artículo</th>
                        <th>Cantidad</th>
                        <th>Fecha salida</th>
                        <th>Destino</th>
                        <th>Estado</th>
                        <th>Fecha Retorno</th>
                        <th>Editar</th>
                        <th>Devolver</th>
                        {{-- <th>Eliminar</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salidas as $salida)
                    <tr>
                        <td>{{ $salida->id }}</td>
                        <td>{{ $salida->persona->dni . ":" . $salida->persona->nombres . " " . $salida->persona->apellidos}}</td>
                        <td>{{ $salida->articulo->nombre_articulo . " : " . $salida->articulo->marca }}</td>
                        <td>{{ $salida->cantidad }}</td>
                        <td>{{ $salida->fecha_salida }}</td>
                        <td>{{ $salida->destino }}</td>
                        <td>{{$salida->condicion}}</td>
                        <td>{{ $salida->fecha_retorno }}</td>
                        <td width="10px">
                            <a href="" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $salida->id }}"><i class="fas fa-edit"></i></a>
                        </td>
                        <td>
                            <form class="devolucion-form" action="{{ route('admin.salida.devoluciones', ['id' => $salida->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $salida->devuelto ? 'btn-success' : 'btn-danger' }}">
                                    <i class="fas {{ $salida->devuelto ? 'fa-check' : 'fa-times' }}"></i>
                                </button>
                            </form>
                        </td>
                        {{-- <td width="10px">
                            <form action="{{ route('admin.salida.destroy', $salida->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $salida->id }})"><i class="fas fa-trash"></i></button>
                            </form>
                        </td> --}}
                    </tr>
                    <!-- Modal de edición -->
                    <div class="modal fade" id="editModal{{ $salida->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $salida->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModal{{ $salida->id }}Label">Editar Salida</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.salida.update', $salida->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Datos Persona</label>
                                            <input type="text" class="form-control" value="{{ $salida->persona->dni . " : " . $salida->persona->nombres . " " . $salida->persona->apellidos }}" disabled>
                                            <input type="hidden" name="persona_dni" value="{{ $salida->persona->dni }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre Artículo</label>
                                            <input type="text" class="form-control" autocomplete="off"  value="{{ $salida->articulo->nombre_articulo . " : " . $salida->articulo->marca }}" disabled>
                                            <input type="hidden" name="articulo_id" value="{{ $salida->articulo->id }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="cantidad{{ $salida->id }}">Cantidad</label>
                                            <input type="number" class="form-control" name="cantidad" id="cantidad{{ $salida->id }}" value="{{$salida->cantidad}}" readonly style="cursor: default;" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="condicion{{ $salida->id }}">Estado</label>
                                            <input type="text" class="form-control to-uppercase" autocomplete="off" name="condicion" id="condicion{{ $salida->id }}" value="{{$salida->condicion}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_salida{{ $salida->id }}">Fecha Salida</label>
                                            <input type="date" class="form-control to-uppercase" name="fecha_salida" id="fecha_salida{{ $salida->id }}" value="{{ $salida->fecha_salida }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_retorno{{ $salida->id }}">Fecha Retorno</label>
                                            <input type="date" class="form-control to-uppercase" name="fecha_retorno" id="fecha_retorno{{ $salida->id }}" value="{{ $salida->fecha_retorno }}" readonly style="cursor: default;" required>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="destino{{ $salida->id }}">Destino</label>
                                            <input type="text" class="form-control to-uppercase" name="destino" id="destino{{ $salida->id }}" autocomplete="off" value="{{ $salida->destino }}" required>
                                        </div>
                                        
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>   
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Lista de personas y artículos en formato JSON
            const personas = @json($personas);
            const articulos = @json($articulos);        
            $(document).ready(function() {
                // Autocompletar personas
                $('#persona-input').on('input', function() {
                    const query = $(this).val().toLowerCase();
                    const suggestions = $('#persona-suggestions');
                    suggestions.empty();        
                    if (query.length > 0) {
                        const filteredPersonas = personas.filter(persona => 
                            persona.dni.toLowerCase().includes(query) ||
                            persona.nombres.toLowerCase().includes(query) ||
                            persona.apellidos.toLowerCase().includes(query)
                        );        
                        filteredPersonas.forEach(persona => {
                            const suggestion = $('<div class="autocomplete-suggestion"></div>');
                            suggestion.text(`${persona.dni} : ${persona.nombres} ${persona.apellidos}`);
                            suggestion.data('dni', persona.dni);       
                            suggestion.on('click', function() {
                                $('#persona-input').val($(this).text());
                                $('#persona-dni').val($(this).data('dni'));
                                suggestions.empty();
                            });
                            suggestions.append(suggestion);
                        });
                    }
                });
            });
        </script>
        <script>
            // Obtener la fecha actual en formato YYYY-MM-DD
            const today = new Date().toISOString().split('T')[0];
            // Asignar la fecha actual al campo de salida
            document.getElementById('fecha_salida').value = today;
        </script>
        <script>
            $(document).ready(function() {
                let debounceTimer; // Añadir un temporizador para debounce
            $('#articulo-input').on('input', function() {
                clearTimeout(debounceTimer); // Limpiar el temporizador anterior
                debounceTimer = setTimeout(() => {
                    const query = $(this).val().toLowerCase();
                    const suggestions = $('#articulo-suggestions');
                    if (query.length > 0) {
                        $.ajax({
                            url: '{{ route("admin.articulos.search") }}', // Cambia a tu ruta de búsqueda
                            method: 'GET',
                            data: { search: query },
                            success: function(data) {
                                console.log('Articulos:', data); // Verifica los datos recibidos
                                suggestions.empty(); // Asegurar que las sugerencias se borren antes de añadir nuevas
                                // Utilizar un conjunto para rastrear sugerencias únicas
                                const seen = new Set();
                                data.forEach(articulo => {
                                    const suggestionText = `${articulo.nombre_articulo} : ${articulo.marca}`;
                                    if (!seen.has(suggestionText)) {
                                        seen.add(suggestionText);
                                        // Crear un elemento de sugerencia
                                        const suggestion = $('<div class="autocomplete-suggestion"></div>');
                                        suggestion.text(suggestionText);
                                        suggestion.data('id', articulo.id);
                                        // Manejar el clic en la sugerencia
                                        suggestion.on('click', function() {
                                            $('#articulo-input').val($(this).text());
                                            $('#articulo-id').val($(this).data('id'));
                                            suggestions.empty(); // Vaciar las sugerencias después de la selección
                                        });
                                        // Añadir la sugerencia al contenedor
                                        suggestions.append(suggestion);
                                    }
                                });
                            },
                            error: function() {
                                suggestions.empty(); // Vaciar en caso de error
                            }
                        });
                    } else {
                        suggestions.empty(); // Vaciar si la consulta está vacía
                    }
                }, 50); // Ajustar el tiempo de debounce según sea necesario
            });
        });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                function convertToUppercase(element) {
                    element.addEventListener('input', function () {
                        element.value = element.value.toUpperCase();
                    });
                }
                // Selecciona todos los campos de entrada que quieres convertir a mayúsculas
                const inputsToUppercase = [
                    document.getElementById('persona-input'),
                    document.getElementById('articulo-input'),
                    document.getElementById('cantidad'),
                    document.getElementById('destino'),
                    document.querySelector('input[name="fecha_salida"]')
                ];
                // Aplica la función convertToUppercase a cada campo de entrada
                inputsToUppercase.forEach(convertToUppercase);
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toUpperCaseFields = document.querySelectorAll('.to-uppercase');
                
                    toUpperCaseFields.forEach(field => {
                        field.addEventListener('input', function() {
                            this.value = this.value.toUpperCase();
                        });
                    
                        field.addEventListener('change', function() {
                            this.value = this.value.toUpperCase();
                        });
                    });
            });
        </script>
        <script> 
            $(document).ready(function() {
                function updateButtonText(button) {
                    if (button.hasClass('btn-success')) {
                        button.html('<i class="fas fa-fw fa-check"></i>');
                        button.prop('disabled', true); // Deshabilitar el botón
                    } else {
                        button.html('<i class="fas fa-fw fa-times"></i>');
                    }
                }
        
                $('.devolucion-form').on('submit', function(e) {
                    e.preventDefault(); // Evitar el envío normal del formulario
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
                                    text: response.success
                                }).then(() => {
                                    location.reload(); // Recargar la página después de cerrar el SweetAlert
                                });
                                var button = form.find('button');
                                button.removeClass('btn-danger').addClass('btn-success');
                                updateButtonText(button);
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
        
                $('#filter-form').on('submit', function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var url = form.attr('action');
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: form.serialize(),
                        success: function(response) {
                            if (response.message) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Información',
                                    text: response.message
                                });
                            } else {
                                var tbody = $('#salidas-table-body');
                                tbody.empty();
                                $.each(response, function(index, salida) {
                                    var row = '<tr>' +
                                        '<td>' + salida.id + '</td>' +
                                        '<td>' + salida.articulo.nombre + '</td>' +
                                        '<td>' + salida.persona.nombres + '</td>' +
                                        '<td>' +
                                        '<form class="devolucion-form" action="/ruta-a-tu-controlador-devoluciones/' + salida.id + '" method="POST">' +
                                        '@csrf' +
                                        '<button type="submit" class="btn ' + (salida.devuelto ? 'btn-success' : 'btn-danger') + '">' +
                                        (salida.devuelto ? '<i class="fas fa-fw fa-check"></i>' : '<i class="fas fa-fw fa-times"></i>') +
                                        '</button>' +
                                        '</form>' +
                                        '</td>' +
                                        '</tr>';
                                    tbody.append(row);
                                });
        
                                // Rebind the submit event to the new form elements
                                $('.devolucion-form').on('submit', function(e) {
                                    e.preventDefault(); // Evitar el envío normal del formulario
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
                                                    text: response.success
                                                }).then(() => {
                                                    location.reload(); // Recargar la página después de cerrar el SweetAlert
                                                });
                                                var button = form.find('button');
                                                button.removeClass('btn-danger').addClass('btn-success');
                                                updateButtonText(button);
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
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al filtrar los artículos.'
                            });
                        }
                    });
                });
        
                // Inicializa el texto de los botones al cargar la página
                $('.devolucion-form button').each(function() {
                    updateButtonText($(this));
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Event listener para el botón de refrescar
                $('#btnRefrescar').on('click', function() {
                    location.reload(); // Refrescar la página
                });
            });
        </script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, bórralo!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Realiza una solicitud AJAX para eliminar el registro
                $.ajax({
                    url: '/admin/salida/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // Token de CSRF para seguridad
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "¡Eliminado!",
                            text: "Tu registro ha sido eliminado.",
                            icon: "success"
                        }).then(() => {
                            location.reload(); // Recarga la página para reflejar los cambios
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // Imprime la respuesta del servidor en la consola
                        Swal.fire({
                            title: "Error",
                            text: "Hubo un problema al eliminar el registro.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    }
</script>

    </body>
</html>
