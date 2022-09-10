var urlDatos='http://localhost/ttd4a22/public/getDatos';
var myChart=document.getElementById('myChart');


new Vue({
	el:"#grafica",
	data:{

	},

	created:function(){
		this.getDatos();
	},

	methods:{
		getDatos:function(){
			this.$http.get(urlDatos).then(function(j){
				console.log(j);

				//Construccion de la grafica
				var grafica = new Chart(myChart,{
					type:'bar',
					data:{
						labels:j.data.labels,
						datasets:[
						//SERIE1
						{
							label:'2021',
							backgroundColor:'red',
							borderColor:'black',
							borderWidth:2,
							data:j.data.serie1
						},
						//SERIE 2
						{
							label:'2022',
							backgroundColor:'blue',
							borderColor:'black',
							borderWidth:2,
							data:j.data.serie2

						}
						]
					}
				});


				//finde la construccion
			});
		}
	}

});
//fin del VUE