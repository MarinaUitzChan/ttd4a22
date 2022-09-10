@extends('layouts.master')
@section('titulo','Interface de ventas')
@section('contenido')
	
<div id="apiVenta">
		<div class="container"><!--INICIO DE CONTAINER-->
		<div class="row">
			<div class="col-md-4">

				<div class="input-group mb-3">
	  					<input type="text" class="form-control" placeholder="Escriba el codigo del producto" aria-label="Recipient's username" aria-describedby="basic-addon2" v-model="sku"
	  					v-on:keyup.enter="buscarProducto()">

	  				<div class="input-group-append">
	   					 <button class="btn btn-primary" type="button" @click="buscarProducto()">Buscar</button>
	  				</div>

	  				<div class="input-group-append">
	  					<button class="btn btn-success" @click="mostrarCobro">Cobrar</button>
	  				</div>
	  				<div class="input-group-append">
	   					 <button class="btn btn-secondary" type="button" @click="mostrarProducto()">Producto</button>
	  				</div>
				</div>

			
				<!-- <h1>@{{prueba}}</h1> -->

			</div>
	</div>
	

	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">

					 <!--p v-bind:algin-->
					<p :align=alineacion><h3>FOLIO: @{{folio}}</h3></p> <!--Es una interpolacion-->
<!--inicio tabla-->
					<table class="table table-bordered">
						<thead>
							<th style="background: #ffff66">SKU</th>
							<th style="background: #ffff66">PRODUCTO</th>
							<th style="background: #ffff66">OPER.</th>
							<th style="background: #ffff66">PRECIO</th>
							<th style="background: #ffff66">CANTIDAD</th>
							<th style="background: #ffff66">TOTAL</th>
						</thead>

						<tbody>
							<tr v-for="(venta,index) in ventas">
								<td>@{{venta.sku}}</td>
								<td>@{{venta.nombre}}

									<img v-bind:src=venta.foto width="50" height="60"></td>
								<td>
									<button class="btn btn-default btn-sm" >
										<i class="fas fa-trash" @click="eliminarProducto(index)"></i>
									</button>
								</td>
								<td>@{{venta.precio}}</td>
								<td><input type="number" v-model.number="cantidades[index]" min="1"></td>
								<td>@{{totalProducto(index)}}</td>
						</tbody>
					</table><!--fin tabla-->
					@{{cantidades}}
					<hr>
					@{{ventas}}
				</div>

			</div>
			<!--  FIN DEL ROW  -->
	</div> 
	<!-- FIN DEL CARD BODY -->
</div>
<!-- FIN DEL CARD -->



<div class="row">
	<div class="col-md-8"></div>
	

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				
					<table class="table table-bordered table-condensed">
					 	<tr>
					 		<th style="background: #ffff66">Subtotal</th>
					 		<td>$ @{{subTotal}}</td>
					 	</tr>

					 	<tr>
					 		<th style="background: #ffff66">IVA</th>
					 		<td> $ @{{iva}}</td>
					 	</tr>

					 	<tr>
					 		<th style="background: #ffff66">TOTAL</th>
					 		<td><b>$ @{{granTotal}}</b></td>
					 	</tr>
						
						<tr>
							<th style="background: #ffff66">Articulos :</th>
							<td>@{{noArticulos}}</td>
						</tr>
					</table>
				
			</div>
			<!-- FIN DEL CARD BODY -->
		</div> 
		<!-- FIN DEL CARD -->
		</div>
			<!-- FIN DEL COL-MD-4 -->
	</div>
</div><!--FIN DE CONTAINER-->

<!-- Modal para el formulario del registro de los moovimientos -->
<div class="modal fade" id="modalCobro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asistente de cobro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form>
        	<div class="form-row">
	        	<div class="col-md-2">
	        		<label>A PAGAR :</label>	
	        	</div> 
	        	<div class="col-md-6">
	        		<input type="number" class="form-control" disabled :value="granTotal">
	        	</div>
        	</div><br>

        	<div class="form-wor">
        		<div class="col-md-2">
        			<label>PAGA CON:</label>
        		</div>

        		<div class="col-md-6">
        			<input type="number" class="form-control" v-model="pagara_con">
        		</div><br>

        		<div class="form-row">
        			<div class="col-md-2">
        				<label>SU CAMBIO ES: </label>		
        			</div>
        			<div class="col-md-6">
        				<input type="number" class="form-control" disabled :value="cambio"> 
        			</div>	
        		</div>
        		
        	</div> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" @click="vender()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- aqui termina el modal-->




<!-- Modal para el formulario del registro de los moovimientos -->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buscar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form>
        	<div class="input-group mb-3">
	  					<input type="text" class="form-control" placeholder="Escriba el codigo del producto" aria-label="Recipient's username" aria-describedby="basic-addon2" v-model="sku"
	  					v-on:keyup.enter="buscarProducto()">

	  				<div class="input-group-append">
	   					 <button class="btn btn-primary" type="button" @click="buscarProducto()">Buscar</button>
	  				</div>
				</div>
        	<table class="table table-bordered"><!--inicio tabla 1-->
						<thead>
							<th style="background: #ffff66">SKU</th>
							<th style="background: #ffff66">PRODUCTO</th>
							<th style="background: #ffff66">OPER.</th>
							<th style="background: #ffff66">PRECIO</th>
							<th style="background: #ffff66">CANTIDAD</th>
							<th style="background: #ffff66">TOTAL</th>
						</thead>

						<tbody>
							<tr v-for="(venta,index) in ventas">
								<td>@{{venta.sku}}</td>
								<td>@{{venta.nombre}}

									<img v-bind:src=venta.foto width="50" height="60"></td>
								<td>
									<button class="btn btn-default btn-sm" >
										<i class="fas fa-trash" @click="eliminarProducto(index)"></i>
									</button>
								</td>
								<td>@{{venta.precio}}</td>
								<td><input type="number" v-model.number="cantidades[index]" min="1"></td>
								<td>@{{totalProducto(index)}}</td>
						</tbody>
					</table><!--fin tabla 1-->
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button class="btn btn-success" @click="mostrarCobro" data-dismiss="modal">Cobrar</button>
					</div>

        	<div><!--tabla2-->
        	<div class="col-md-6">
						<input type="text" placeholder="Escriba el nombre del producto" class="form-control" v-model="buscar">
						</div>
        	<!--inicio tabla-->
					<table class="table table-bordered">
						<thead>
							<th style="background: #ffff66">SKU</th>
							<th style="background: #ffff66">PRODUCTO</th>
							<th style="background: #ffff66">PRECIO</th>
							<th style="background: #ffff66">CANTIDAD</th>
							
						</thead>

						<tbody>
						<tr v-for="producto in filtroProducto">
							<td>@{{producto.sku}}</td>
							<td>@{{producto.nombre}}</td>
							<td>@{{producto.precio}}</td>
							<td>@{{producto.cantidad}}</td>
						</tr>
					</tbody>
					</table><!--fin tabla-->
        		</div><!--fin tabla2-->
        </form>
      </div>
    </div>
  </div>
</div>
<!-- aqui termina el modal-->




</div><!--Fin de vue-->

	
@endsection

@push('scripts')
	<script type="text/javascript" src="js/vue-resource.js"></script>
	<script type="text/javascript" src="js/apis/apiVenta.js"></script>
	<script type="text/javascript" src="js/moment-with-locales.min.js"></script>
	<script type="text/javascript" src="js/apis/apiProducto.js"></script>
@endpush


<input type="hidden" name="route" value="{{url('/')}}">