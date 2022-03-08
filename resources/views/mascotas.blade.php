@extends('layouts.master')
@section('titulo','CRUD MASCOTAS')
@section('contenido')
	
	<!-- INICIA VUE -->
	<div id="mascota">

	

 <div class="row">
 	<div class="col-md-8">
 		
 	</div>
 </div>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-warning"> 
					<div class="card-header">
						<h3>CRUD MASCOTAS 
						<span class="btn btn-sm btn-primary" @click="mostrarModal()">
							<i class="fas fa-plus"></i>
						</span>
						</h3> 

						<div class="col-md-6">
						<input type="text" placeholder="Escriba el nombre o especie de la mascota" class="form-control" v-model="buscar">
						</div>
					</div>

					<div class="card-body">
						
							<!-- INICIO DE LA TABLA -->
				<table class="table table-bordered table-striped">
					<thead>
						<th hidden="">ID MASCOTA</th>
						<th>NOMBRE</th>
						<th>EDAD</th>
						<th>GENERO</th>
						<th>ESPECIE</th>
						<th>ACCIONES</th>

					</thead>

					<tbody>
						<tr v-for="mascota in filtroMascotas">
							<td hidden="">@{{mascota.id_mascota}}</td>
							<td>@{{mascota.nombre}}</td>
							<td>@{{mascota.edad}}</td>
							<td>@{{mascota.genero}}</td>
							<td>@{{mascota.especie.especie}}</td>
							<td>
								<button class="btn btn-sm" @click="editandoMascota(mascota.id_mascota)">
									<i class="fas fa-pen"></i>
								</button>

								<button class="btn btn-sm" @click="eliminarMascota(mascota.id_mascota)">
									<i class="fas fa-trash"></i>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- FIN DE LA TABLA -->

					</div>
				
					
				</div>
			</div>  
			<!-- FIN DE COL-MD-12 -->
		</div>

	</div>
	<!-- TERMINA VUE -->

	
@endsection

@push('scripts')
	<script type="text/javascript" src="js/vue-resource.js"></script>
	<script type="text/javascript" src="js/apis/apiMascota.js"></script>
@endpush

<input type="hidden" name="route" value="{{url('/')}}">