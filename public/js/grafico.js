var myChart = document.getElementById('myChart');
 
var labels = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO'];

var data = {
	labels:labels,
	//Grupos de datos
	datasets:[
	 {
	 	label:'SERIE 1',
	 	backgroundColor:'red',
	 	borderColor:'black',
	 	data:[1000, 1500, 500, 2000, 600, 1200]
	 },

	 {
	 	label:'SERIE 2',
	 	backgroundColor:'blue',
	 	borderColor:'black',
	 	data:[1200, 1000, 800, 1800, 3000, 2500]
	 }
	],

}

var config={
	type:'line',
	data:data,
	options:{}
};

var myChart= new Chart(myChart,config);