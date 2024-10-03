@extends('welcome')
@push('header-js-lista')

   <link href="{{ asset('dataTables') }}/datatables.min.css" rel="stylesheet">
   <script src="{{ asset('dataTables') }}/datatables.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/dropzone/dist/min/dropzone.min.css">
    <!-- Script de Dropzone -->
   <script src="{{ asset('assets') }}/vendor/dropzone/dist/min/dropzone.min.js"></script>
   <style>
    	.dropzoneDragArea {
		    background-color: #fbfdff;
		    border: 1px dashed #c0ccda;
		    border-radius: 6px;
		    padding: 60px;
		    text-align: center;
		    margin-bottom: 15px;
		    cursor: pointer;
		}
    </style>
@endpush
@section('content')

@include('users.partials.headerPaciente') 
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Documentos</h3>
                                </div>
                                @can('administrar_documentos')
                                <div class="col-4 text-right">
                                    <button onClick=abrirModalRegistro() class="btn btn-sm btn-primary">Nuevo Folder</button>
                                </div>
                                @endcan
                            </div>
                        </div>

                        <div class="col-12">
                        </div>

                        <div class="table-responsive px-4">
                            <table id="tablaDocumentos" class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Fecha registro</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $carpetas as $carpeta)
                                    <tr id="tr-{{ $carpeta->id }}">
                                        <td>{{\Carbon\Carbon::parse($carpeta->fecha_creacion)->format('d-m-Y') }}</td>
                                        <td>{{$carpeta->nombre}}</td>
                                        <td>{{$carpeta->descripcion}}</td>
                                        <td class="text-right">
                                        <div>
                                        <a href="{{ route('documentos.listar_archivos',['id' => $paciente->id, 'carpeta_id'=>$carpeta->id]) }}">
                                                <button class="btn btn-icon btn-2 btn-primary" type="button" >
                                                    
                                                    <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                                </button>
                                        </a>
                                        @can('administrar_documentos')
                                        <a onClick="abrirModalEdicion({{$carpeta}})">
                                            <button class="btn btn-icon btn-2 btn-primary" type="button">
                                                <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                                            </button>
                                        </a>
                                        
                                        <a onClick="mostrarModalEliminar({{$carpeta->id}},'{{$carpeta->nombre}}')">
                                            <button class="btn btn-icon btn-2 btn-primary" type="button"
                                                data-toggle="modal" data-target="#modalEliminar">
                                                <span class="btn-inner--icon">
                                                    <i class="fas fa-solid fa-trash"></i>
                                                </span>
                                            </button>
                                        </a>
                                        @endcan
                                    </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <nav class="d-flex justify-content-end" aria-label="...">

                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </div>

<!-- Modal -->
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
</div> 

<div class="modal fade " id="modalRegistrarFolder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
</div> 

@endsection
@push('js')
<script>
    var  myDropzone= null;
  var table = $('#tablaDocumentos').DataTable({
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "(_START_ al _END_) de _TOTAL_ resultados",
        "infoEmpty": "No se encontraron resultados",
        "infoFiltered": "(Filtrado de _MAX_ total resultados)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Resultados",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": ">",
            "previous": "<"
        }
    }
    });
        // Configuración de Dropzone
        
function mostrarModalEliminar(carpeta_id, carpeta_nombre){
    $('#modalEliminar').empty();
    var contenido =`<div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Eliminar folder</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="modalEliminarEnunciado">Realmente desea eliminar el folder '${carpeta_nombre}'?<br> Tome en cuenta que se eliminará todos los archivos que contiene el folder.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button  class="btn btn-primary" onClick="eliminarFolder(${carpeta_id})">Confirmar</button>
                                
                            </div>
                        </div>
                    </div>`;
                    
    $('#modalEliminar').append(contenido);
    $('#modalEliminar').show();
    
}

function eliminarFolder(carpeta_id){

    var token = $('meta[name="csrf-token"]').attr('content');
    // Datos a enviar al servidor (puedes modificarlos según tus necesidades)
    var datos = {
      carpeta_id: carpeta_id ,
      _token: token
    };
    console.log('datos:::',datos);

    $.ajax({
      url: "{{ route('carpeta.delete') }}", 
      method: 'POST',
      data: datos,
      success: function (response) {
        // Manejar la respuesta exitosa del servidor
        console.log('Solicitud exitosa:', response);
        $('#tr-'+carpeta_id).remove();
        $('#modalEliminar').modal('hide');
      },
      error: function (error) {
        // Manejar errores en la solicitud AJAX
        console.error('Error en la solicitud AJAX:', error);
      }
    });
    
}
function obtenerListaDoctores() {
    return new Promise(function(resolve, reject) {
        var token = $('meta[name="csrf-token"]').attr('content');
        var datos = {
            _token: token
        };

        $.ajax({
            url: "{{ route('doctores.list') }}",
            method: 'POST',
            data: datos,
            success: function(response) {
                // Resuelve la promesa con la lista de doctores
                resolve(response.doctores);
            },
            error: function(error) {
                // Rechaza la promesa en caso de error
                reject(error);
            }
        });
    });
}

async function abrirModalRegistro() {
    try {
        $('#modalRegistrarFolder').empty();
        // Espera a que la promesa se resuelva y obtén la lista de doctores
        var doctores = await obtenerListaDoctores();
        console.log("Lista de doctores:", doctores);

        var selectorDoctores = "";
        doctores.forEach(function(doctor) {
            selectorDoctores += `<option value="${doctor.id}">${doctor.nombres} ${doctor.apellidos}</option>`;
        });

        var contenido = `<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Nuevo Folder</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form  name="demoform" id="demoform" method="POST" class="dropzone" enctype="multipart/form-data">
                                @csrf     
                                <input id="input-paciente_id" name="folderpacienteid" value="{{$paciente->id}}" type="hidden">
                                    <div   class="col-lg-12 form-group">
                                        <label class="form-control-label" for="input-nombre">{{ __('Nombre') }}</label>
                                        <input type="text" name="foldernombre" id="input-nombre" class="form-control form-control-alternative" placeholder="Nombre">
                                    </div>
                                    <div   class="col-lg-12 form-group">
                                        <label class="form-control-label" for="input-descripcion">{{ __('Descripcion') }}</label>
                                        <input type="text" name="folderdescripcion" id="input-descripcion" class="form-control form-control-alternative" placeholder="Descripcion">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                            <span>Upload file</span>
                                        </div>
                                        <div class="dropzone-previews"></div>
                                    </div>
                                    <div id="errorFaltaArchivo">
                                    </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button  type="submit" class="btn btn-primary" >Aceptar</button>
                                </div>
                            </form>
                        </div>
                    </div>`;

        $('#modalRegistrarFolder').append(contenido);
        $('#modalRegistrarFolder').modal('show');

        Dropzone.autoDiscover = false;
        // Dropzone.options.demoform = false;	
        let token = $('meta[name="csrf-token"]').attr('content');
        $(function() {
            myDropzone = new Dropzone("div#dropzoneDragArea", { 
            paramName: "file",
            url: "{{ route('documentos.store') }}",
            previewsContainer: 'div.dropzone-previews',
            addRemoveLinks: true,
            autoProcessQueue: false,
            maxFilesize: 16,
            uploadMultiple: true,
            parallelUploads: 20,
            maxFiles: 20,
            params: {
                _token: token
            },
            

            init: function() {
	    var myDropzone = this;
	    //form submission code goes here
	    $("form[name='demoform']").submit(function(event) {
	    	//Make sure that the form isn't actully being sent.
            enviarDatos();
	    	event.preventDefault();
			event.stopPropagation();

			myDropzone.processQueue();
			
	    });

	    //Gets triggered when we submit the image.
	    this.on('sending', function(file, xhr, formData){
	    //fetch the user id from hidden input field and send that userid with our image
	     // let userid = document.getElementById('userid').value;
		 //  formData.append('userid', userid);

		   //let nombre = document.getElementById('name').value;
		  // formData.append('nombre', name);
		  console.log('entro a sending');
		});
		
	    this.on("success", function (file, response) {
  
        });

        this.on("queuecomplete", function () {
		
        });
		
        // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
	    // of the sending event because uploadMultiple is set to true.
	    this.on("sendingmultiple", function(file, xhr, formData) {
	      // Gets triggered when the form is actually being sent.
	      // Hide the success button or the complete form.
            formData.append('paciente_id', $('#input-paciente_id').val());
            formData.append('nombre', $('#input-nombre').val());
            formData.append('descripcion', $('#input-descripcion').val());
                    
            
		  console.log('entro a sendingmultiple');
	    });
		
	    this.on("successmultiple", function(files, response) {
	      // Gets triggered when the files have successfully been sent.
	      // Redirect user or notify of success.
          window.location.href = '{{ route("documentos.index",["id"=>$paciente->id]) }}';
          
	    });
		
	    this.on("errormultiple", function(files, response) {
	      // Gets triggered when there was an error sending the files.
	      // Maybe show form again, and notify user of error
	    });
	}

            });
        });
    }catch (error) {
        console.error('Error al obtener la lista de doctores:', error);
    }
}

async function abrirModalEdicion(carpeta_editable) {

    console.log(carpeta_editable);
    try {
        $('#modalRegistrarFolder').empty();
        // Espera a que la promesa se resuelva y obtén la lista de doctores
        var doctores = await obtenerListaDoctores();
        console.log("Lista de doctores:", doctores);

        var selectorDoctores = "";
        doctores.forEach(function(doctor) {
            selectorDoctores += `<option value="${doctor.id}">${doctor.nombres} ${doctor.apellidos}</option>`;
        });

        var contenido = `<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Folder</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form  name="demoform" id="demoform" method="POST" class="dropzone" enctype="multipart/form-data">
                                @csrf     
                                <input id="input-paciente_id" name="folderpacienteid" value="{{$paciente->id}}" type="hidden">
                                    <div   class="col-lg-12 form-group">
                                        <label class="form-control-label" for="input-nombre">{{ __('Nombre') }}</label>
                                        <input type="text" name="foldernombre" id="input-nombre" class="form-control form-control-alternative" placeholder="Nombre" value="${carpeta_editable.nombre}">
                                    </div>
                                    <div   class="col-lg-12 form-group">
                                        <label class="form-control-label" for="input-descripcion">{{ __('Descripcion') }}</label>
                                        <input type="text" name="folderdescripcion" id="input-descripcion" class="form-control form-control-alternative" placeholder="Descripcion" value="${carpeta_editable.descripcion}">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                            <span>Upload file</span>
                                        </div>
                                        <div class="dropzone-previews"></div>
                                    </div>
                                    <div id="errorFaltaArchivo"></div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button  type="submit" class="btn btn-primary">Aceptar</button>
                                </div>
                            </form>
                        </div>
                    </div>`;

        $('#modalRegistrarFolder').append(contenido);
        $('#modalRegistrarFolder').modal('show');

        Dropzone.autoDiscover = false;
        // Dropzone.options.demoform = false;	
        let token = $('meta[name="csrf-token"]').attr('content');
        $(function() {
         myDropzone = new Dropzone("div#dropzoneDragArea", { 
            paramName: "file",
            url: "{{ route('documentos.update') }}",
            previewsContainer: 'div.dropzone-previews',
            addRemoveLinks: true,
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 20,
            maxFiles: 20,
            dictRemoveFile: "Eliminar" ,
            params: {
                _token: token
            },
            
            

            init: function() {

                var myDropzone = this;
                //form submission code goes here
                
                $("form[name='demoform']").submit(function(event) {
                    //Make sure that the form isn't actully being sent.
                    enviarDatos();
                    event.preventDefault();
                    event.stopPropagation();

                    myDropzone.processQueue();
                    
                });
                

                this.on("addedfile", function (file) {
                    // Asegúrate de que estás añadiendo la miniatura aquí
                    if (file.dataURL) {
                        //file.previewElement.classList.add("dz-success");
                        //file.previewElement.querySelector("img").src = file.dataURL;
                    }

                    var nombreArchivo = document.createElement("div");
                    nombreArchivo.className = "dz-file-name";
                    nombreArchivo.innerHTML = file.name;
                    file.previewElement.appendChild(nombreArchivo);
                });

                //Gets triggered when we submit the image.
                this.on('sending', function(file, xhr, formData){
                //fetch the user id from hidden input field and send that userid with our image
                // let userid = document.getElementById('userid').value;
                //  formData.append('userid', userid);

                //let nombre = document.getElementById('name').value;
                // formData.append('nombre', name);
                console.log('entro a sending');
                });
                
                this.on("success", function (file, response) {
        
                });

                this.on("queuecomplete", function () {
                
                });
                
                // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                // of the sending event because uploadMultiple is set to true.
                this.on("sendingmultiple", function(file, xhr, formData) {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
                    formData.append('paciente_id', $('#input-paciente_id').val());
                    formData.append('nombre', $('#input-nombre').val());
                    formData.append('descripcion', $('#input-descripcion').val());
                    formData.append('carpeta_id', carpeta_editable.id);
                            
                    
                console.log('entro a sendingmultiple');
                });
                
                this.on("successmultiple", function(files, response) {
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
                window.location.href = '{{ route("documentos.index",["id"=>$paciente->id]) }}';
                
                });
                
                this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
                });
            }

            });
            
            $.ajax({
                url: "{{ route('cargarArchivosCarpeta') }}",
                method: 'POST',
                data: { carpeta_id: carpeta_editable.id,  _token: token },
                success: function(response) {
                    response.archivos.forEach(function (archivo) {
                        
                        var decodedString = atob(archivo.archivo);
                        const nuevoArchivo = new File([decodedString], archivo.nombre);
                        myDropzone.addFile(nuevoArchivo);
                    });
                
                },
                error: function(error) {
                    // Rechaza la promesa en caso de error
                    console(error);
                }

            });

        });
    }catch (error) {
        console.error('Error al obtener la lista de doctores:', error);
    }
    
}

function enviarDatos(){
    if (myDropzone.files.length === 0) {
        $('#errorFaltaArchivo').empty();
        $('#errorFaltaArchivo').append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Debe agregar al menos un archivo
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`);
        
    } 
    
    
}

</script>
@endpush