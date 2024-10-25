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
                Registrar Articulo
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_articulo">Nombre de Artículo*</label>
                            <input type="text" class="form-control to-uppercase" name="nombre_articulo" id="nombre_articulo" placeholder="Ingrese el Nombre del artículo" autocomplete="off" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s\"']+" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <input type="text" autocomplete="off" class="form-control to-uppercase" name="marca" id="marca" placeholder="Ingrese la marca del artículo" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s\"']+">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="stock">Stock*</label>
                            <input type="number" class="form-control" name="stock" placeholder="Ingrese la cantidad" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estado">Estado*</label>
                            <select class="form-control to-uppercase" name="estado" id="estado" required>
                                <option value="BUENAS CONDICIONES" disabled selected>Seleccione el estado</option>
                                <option value="BUENAS CONDICIONES">BUENAS CONDICIONES</option>
                                <option value="NUEVO">MALAS CONDICIONES</option>
                                <option value="USADO">NECESITA REPARACION</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_creacion">Fecha Creación*</label>
                            <input type="date" class="form-control" name="fecha_creacion" id="fecha_creacion" placeholder="Ingrese la fecha de creación" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descripcion">Descripción*</label>
                            <input type="text" class="form-control to-uppercase" name="descripcion" id="descripcion" placeholder="Ingrese una breve descripción" autocomplete="off" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s\"']+" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-2">Registrar</button>
                    <a href="{{ route('articulo.pdf') }}" class="btn btn-danger" target="_blank">Exportar Todo</a>
                </div>
            </form>
        </div>
    </div>

    {{-- tabla de articulos --}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title text-center">
                <i class="fas fa-table mr-2"></i>
                Inventario
            </h3>
            <form id="filterForm" action="{{ route('reportearticulo.pdf') }}" method="GET" target="_blank">
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
            <table id="articulo" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre_Articulo</th>
                        <th>Marca</th>
                        <th>Descripción</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Fecha Creación</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulo as $articulos)
                        <tr>
                            <td>{{ $articulos->id }}</td>
                            <td>{{ $articulos->nombre_articulo }}</td>
                            <td>{{ $articulos->marca }}</td>
                            <td>{{ $articulos->descripcion }}</td>
                            <td>{{ $articulos->stock }}</td>
                            <td>{{ $articulos->estado }}</td>
                            <td>{{ $articulos->fecha_creacion }}</td>
                            <td width="10px">
                                <a href="" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $articulos->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td width="10px">
                                <form action="{{ route('admin.articulo.destroy', $articulos->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-button">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal de edición -->
                        <div class="modal fade" id="editModal{{ $articulos->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $articulos->id }}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModal{{ $articulos->id }}Label">Editar articulo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.articulo.update', $articulos->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <!-- Campos del formulario de edición -->
                                            <div class="form-group">
                                                <label for="nombre_articulo{{ $articulos->id }}">Nombre_Articulo</label>
                                                <input type="text" class="form-control to-uppercase" name="nombre_articulo" id="nombre_articulo{{ $articulos->id }}" autocomplete="off" value="{{ $articulos->nombre_articulo }}" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s\"']+">
                                            </div>
                                            <div class="form-group">
                                                <label for="marca{{ $articulos->id }}">Marca</label>
                                                <input type="text" class="form-control to-uppercase" name="marca" id="marca{{ $articulos->id }}" autocomplete="off" value="{{ $articulos->marca }}" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s\"']+">
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion{{ $articulos->id }}">Descripción</label>
                                                <input type="text" class="form-control to-uppercase" name="descripcion" id="descripcion{{ $articulos->id }}" autocomplete="off" value="{{ $articulos->descripcion }}" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s\"']+">
                                            </div>
                                            <div class="form-group">
                                                <label for="stock{{ $articulos->id }}">Stock</label>
                                                <input type="text" class="form-control" name="stock" id="stock{{ $articulos->id }}" value="{{ $articulos->stock }}" readonly style="cursor: default;">
                                            </div>
                                            <div class="form-group">
                                                <label for="estado{{ $articulos->id }}">Estado</label>
                                                <input type="text" class="form-control to-uppercase" name="estado" id="estado{{ $articulos->id }}" autocomplete="off" value="{{ $articulos->estado }}" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s\"']+">
                                            </div>
                                            <div class="form-group">
                                                <label for="fecha_creacion{{ $articulos->id }}">Fecha Creación</label>
                                                <input type="date" class="form-control" name="fecha_creacion" id="fecha_creacion{{ $articulos->id }}" value="{{ $articulos->fecha_creacion }}">
                                            </div>
                                            <!-- Otros campos del formulario -->
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
    </div>
</div>

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
    // Obtener la fecha actual en formato YYYY-MM-DD
    const today = new Date().toISOString().split('T')[0];
    // Asignar la fecha actual al campo de salida
    document.getElementById('fecha_creacion').value = today;
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // En lugar de seleccionar todos los botones de eliminación, adjunta el evento al contenedor principal
    const container = document.querySelector('body'); // Puedes cambiar 'body' por un contenedor específico

    container.addEventListener('click', function (event) {
        if (event.target.classList.contains('delete-button')) {
            event.preventDefault(); // Evitar que el botón envíe el formulario inmediatamente

            const button = event.target;
            const form = button.closest('.delete-form');

            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Sí, bórralo!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Enviar el formulario si se confirma la acción
                }
            });
        }
    });
});
</script>

