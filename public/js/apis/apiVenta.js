function init() {

var apiProducto= 'http://localhost/ttd4a22/public/apiProducto'; //se crea para tener un acceso global. 

new Vue({
	//Asignamos el token
	http: {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
            }
        },

	//Especificar la zona de actuación de Vue
	el:"#apiVenta",

	//Esta sección de VUE sirve para declarar Variables
	//Y constantes. g
	data:{
		//mensaje: 'HOLA MUNDO DESDE LA UTC',
		sku:'',
		ventas:[],
		producto:[],
		cantidades:[],
		cant:1,
		auxSubTotal:0,
		frase:'HOLA MUNDO DESDE LA UTC',
		alineacion:'center',
		pagara_con:0,
		
	},

	//INICIO DE METHODS
	methods:{
		
		buscarProducto:function(){
			var encontrado=0;

			if(this.sku)
			{//INICIO DE IF(THIS.SKU)
	
			var producto = {};

			//Rutina de busqueda

			for (var i = 0; i < this.ventas.length; i++) {

			 	if (this.sku===this.ventas[i].sku){

			 		encontrado=1;
			 		this.ventas[i].cantidad++;
			 		this.cantidades[i]++;
			 		this.sku='';
			 		break;
			 	}
			 		 //this.ventas[1];

			}//fin de rutina de busqueda

			//Inicio GET de ARRAY
			//var producto = {}
			if (encontrado===0) 
			this.$http.get(apiProducto + '/' + this.sku).then(function(j){
				console.log(j.data);

				producto = {
					sku:j.data.sku,
					nombre:j.data.nombre,
					precio:j.data.precio,
					cantidad:1, 
					total:j.data.precio,
					foto:'prods/' + j.data.foto,
				};

	
					this.ventas.push(producto);
					this.cantidades.push(1);
				this.sku='';
			});

		}//FIN DE IF(THIS.SKU)

		},

		eliminarProducto:function(id){
			this.ventas.splice(id,1); //Splice es eliminar la mascota
		},

		mostrarCobro:function(){
			$('#modalCobro').modal('show');
		}



},
//FIN DE METHODS

//SECCION PARA CALCULAR UN VALOR
computed:{
	totalProducto(){
		return (id)=>{
			var total = 0;
				total=this.ventas[id].precio*this.cantidades[id];

			//ACTUALIZO EL TOTAL DEL PRODUCTIO EN EL ARRAY VENTAS
			this.ventas[id].total=total;

			//ACTUALIZO LA CANTIDAD EN EL ARRAY VENTAS
			this.ventas[id].cantidad=this.cantidades[id];

			return total.toFixed(1);//Regresa ek total con un decimal

		}
	},//FIN DE TOTALPRODUCTO

	subTotal(){
		var total=0;

		//Se recorre del ultimo hacia abajo
		for (var i = this.ventas.length - 1; i >= 0; i--) {
			total=total+this.ventas[i].total;
		}

		//Mando una copia del subtotal a la seccion del data 
		//Para el uso de otros calculos
		this.auxSubTotal=total.toFixed(1);
		return total.toFixed(1);
	},//FIN DEL SUBTOTAL

	iva(){
		var auxIva=0;

		auxIva = this.auxSubTotal*0.16;
		return auxIva.toFixed(1);
	},

	granTotal(){
		var auxTotal=0;

		auxTotal=this.auxSubTotal*1.16;
		return auxTotal.toFixed(1);
	},

	noArticulos(){
		var acum=0;
		for (var i = this.ventas.length - 1; i >= 0; i--) {
			acum=acum+this.ventas[i].cantidad;
		}
		return acum;
	},

	cambio(){
		var camb=0;
		camb=this.pagara_con + - this.granTotal;
		camb=camb.toFixed(1);

		return camb;

	}
	
},


}) 
} window.onload = init;