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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- formulario -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                Registrar Persona
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dni">DNI*</label>
                            <input type="text" class="form-control" name="dni" id="dni" placeholder="Ingrese el DNI" maxlength="8" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombres">Nombres*</label>
                            <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ingrese los nombres" autocomplete="off" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apellidos">Apellidos*</label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ingrese los apellidos" autocomplete="off" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nro_celular">Número de Celular</label>
                            <input type="text" class="form-control" name="nro_celular"  id="nro_celular" placeholder="Ingrese el número de celular" autocomplete="off" maxlength="9">
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tipo_persona">Tipo Persona*</label>
                            <select class="form-control" name="tipo_persona" required>
                                <option value=""  selected>Seleccione el tipo de persona</option>
                                <option value="ESTUDIANTE">ESTUDIANTE</option>
                                <option value="DOCENTE">DOCENTE</option>
                                <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                                <option value="OTRO">OTRO</option>
                            </select>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tipo_persona">Tipo Persona*</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_persona" id="estudiante" value="ESTUDIANTE" required>
                                <label class="form-check-label" for="estudiante">
                                    ESTUDIANTE
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_persona" id="docente" value="DOCENTE" required>
                                <label class="form-check-label" for="docente">
                                    DOCENTE
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_persona" id="administrativo" value="ADMINISTRATIVO" required>
                                <label class="form-check-label" for="administrativo">
                                    ADMINISTRATIVO
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_persona" id="otro" value="OTRO" required>
                                <label class="form-check-label" for="otro">
                                    OTRO
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success mr-2" onclick="document.getElementById('importFile').click();">Importar Personas</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- tabla de personas-->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title text-center">
                <i class="fas fa-table mr-2"></i>
                Personas
            </h3>
            
            <form action="{{ route('personas.import') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                @csrf
                <input type="file" name="file" id="importFile" onchange="this.form.submit();" required>
            </form>
        </div>
        <div class="card-body">
            <table id="persona" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Nro. Celular</th>
                        <th>Tipo Persona</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($persona as $personas)
                    <tr>
                        <td>{{ $personas->dni }}</td>
                        <td>{{ $personas->nombres }}</td>
                        <td>{{ $personas->apellidos }}</td>
                        <td>{{ $personas->nro_celular }}</td>
                        <td>{{ $personas->tipo_persona }}</td>
                        <td width="10px">
                            <a href="" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $personas->dni }}"><i class="fas fa-edit"></i></a>
                        </td>
                        <td width="10px">
                            <form action="{{ route('admin.persona.destroy', $personas->dni) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger delete-button"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <!-- Modal de edición -->
                    <div class="modal fade" id="editModal{{ $personas->dni }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $personas->dni }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModal{{ $personas->dni }}Label">Editar persona</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.persona.update', $personas->dni) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <!-- Campos del formulario de edición -->
                                        <div class="form-group">
                                            <label for="dni{{ $personas->dni }}">DNI</label>
                                            <input type="text" class="form-control" name="dni" id="dni{{ $personas->dni }}" value="{{ $personas->dni }}" maxlength="8" readonly style="cursor: default;">
                                        </div>
                                        <div class="form-group">
                                            <label for="nombres{{ $personas->dni }}">Nombres</label>
                                            <input type="text" class="form-control to-uppercase" name="nombres" id="nombres{{ $personas->dni }}" autocomplete="off" value="{{ $personas->nombres }}" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="apellidos{{ $personas->dni }}">Apellidos</label>
                                            <input type="text" class="form-control to-uppercase" name="apellidos" id="apellidos{{ $personas->dni }}" autocomplete="off" value="{{ $personas->apellidos }}" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nro_celular{{ $personas->dni }}">Nro. Celular</label>
                                            <input type="text" class="form-control" name="nro_celular" id="nro_celular{{ $personas->dni }}" value="{{ $personas->nro_celular }}" maxlength="9">
                                        </div>
                                        <div class="form-group">
                                            <label for="tipo_persona{{ $personas->dni }}">Tipo Persona</label>
                                            <select class="form-control" name="tipo_persona" id="tipo_persona{{ $personas->dni }}" required>
                                                <option value="" disabled>Seleccione el tipo de persona</option>
                                                <option value="ESTUDIANTE" {{ $personas->tipo_persona == 'ESTUDIANTE' ? 'selected' : '' }}>ESTUDIANTE</option>
                                                <option value="DOCENTE" {{ $personas->tipo_persona == 'DOCENTE' ? 'selected' : '' }}>DOCENTE</option>
                                                <option value="ADMINISTRATIVO" {{ $personas->tipo_persona == 'ADMINISTRATIVO' ? 'selected' : '' }}>ADMINISTRATIVO</option>
                                            </select>
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
    document.addEventListener("DOMContentLoaded", function() {
        // Función para remover caracteres no numéricos
        function validarNumeros(input) {
            input.value = input.value.replace(/[^\d]/g, '');
        }

        // Función para convertir a mayúsculas
        function convertirAMayusculas(input) {
            input.value = input.value.toUpperCase();
        }

        // Función para aplicar validación y formato a un campo
        function aplicarValidacionYFormato(input, soloNumeros) {
            input.addEventListener('input', function() {
                if (soloNumeros) {
                    validarNumeros(this);
                }
                convertirAMayusculas(this);
            });
            input.addEventListener('blur', function() {
                if (soloNumeros) {
                    validarNumeros(this);
                }
                convertirAMayusculas(this);
            });
        }

        // Obtener los elementos por su ID y aplicar validación y formato
        var dniInput = document.getElementById('dni');
        var nombresInput = document.getElementById('nombres');
        var apellidosInput = document.getElementById('apellidos');
        var nroCelularInput = document.getElementById('nro_celular');
        var nroCelularModalInput = document.getElementById('nro_celular_modal'); // Asumiendo que existe un campo con este ID en el modal

        // Aplicar validación y formato a los campos
        if (dniInput) {
            aplicarValidacionYFormato(dniInput, true);
        }
        if (nombresInput) {
            aplicarValidacionYFormato(nombresInput, false);
        }
        if (apellidosInput) {
            aplicarValidacionYFormato(apellidosInput, false);
        }
        if (nroCelularInput) {
            aplicarValidacionYFormato(nroCelularInput, true);
        }
        if (nroCelularModalInput) {
            aplicarValidacionYFormato(nroCelularModalInput, true);
        }
    });

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
<script>
    document.getElementById('nombres').addEventListener('input', function (event) {
        this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s+]/g, '');
    });

    document.getElementById('apellidos').addEventListener('input', function (event) {
        this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s+]/g, '');
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.to-uppercase').forEach(function (element) {
            element.addEventListener('input', function (event) {
                this.value = this.value.replace(/[^A-Za-z\s]/g, '');
            });
        });
    });
</script>  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
