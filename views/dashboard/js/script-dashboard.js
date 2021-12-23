$(function () {  

   
    function validarPeriodo() {
        $.post('compras/validarPeriodo', function (e) {            
            $('#txtperiodo').val(e.codigo); 
            listarCantVentas();
            listarCantCompras();      
        },'JSON');
    }
        
    function listarCantProveedor(){
        $.post('dashboard/cantidadProveedor',function (e) {
//            console.log(e.cant)
            $('#txtcantproveedor').text(e.cantidad);
        }, 'JSON');
    }

    function listarCantCliente(){
        $.post('dashboard/cantidadCliente',function (e) {          
            $('#txtcantcliente').text(e.cantidad);
        }, 'JSON');
    }

    function pruebacebo(){
      $.post('dashboard/pruebacebo',function (e) {          
        console.log(e);
      }, 'JSON');
    }

    function pruebapadre(){
      $.post('dashboard/pruebapadre',function (e) {          
        console.log(e);
      }, 'JSON');
    }
       
    function listarCantVentas(){
        let idperiodo = $('#txtperiodo').val();
        console.log(idperiodo)
        $.post('dashboard/cantidadVentas',{'idperiodo':idperiodo},function (e) {
            console.log(e)
            $('#txtcantventa').text(e.cantidad);
        }, 'JSON');
    }

    function listarCantCompras(){
        let idperiodo = $('#txtperiodo').val();        
        $.post('dashboard/cantidadCompras',{'idperiodo':idperiodo},function (e) {
            console.log(e)
            $('#txtcantcompra').text(e.cantidad);
        }, 'JSON');
    }
    
    listarCantCliente();
    validarPeriodo(); 
    listarCantProveedor(); 
    pruebacebo();  
    pruebapadre();

   

  

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  

  var pieChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
  var pieData = {
    labels: [
      'Instore Sales',
      'Download Sales',
      'Mail-Order Sales'
    ],
    datasets: [
      {
        data: [30, 12, 20],
        backgroundColor: ['#f56954', '#00a65a', '#f39c12']
      }
    ]
  }
  var pieOptions = {
    legend: {
      display: false
    },
    maintainAspectRatio: false,
    responsive: true
  }
});

