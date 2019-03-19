<?php
require('process/conf.php');
$stmt = $conn_sql->prepare('SELECT * FROM users');
$stmt->execute();
$datos = $stmt->fetchAll();
?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <title>Usuarios</title>
    <style>
    	/* Sticky footer styles
			-------------------------------------------------- */
			html {
			  position: relative;
			  min-height: 100%;
			}
		
			.footer {
			  position: absolute;
			  bottom: 0;
			  width: 100%;
			  /* Set the fixed height of the footer here */
			  height: 60px;
			  line-height: 60px; /* Vertically center the text there */
			  /*background-color: #f5f5f5;*/
			}


			/* Custom page CSS
			-------------------------------------------------- */
			/* Not required for template or sticky footer method. */

			body > .container {
			  padding: 60px 15px 0;
			}

			.footer > .container {
			  padding-right: 15px;
			  padding-left: 15px;
			}

			code {
			  font-size: 80%;
			}
			#entrar{
				padding: 1% 13%;
				text-transform: uppercase;
			}
      .to-show, .to-show-2{
        display:none;
      }
    </style>
  </head>
  <body>  
    <div class="container">
      <div class="py-2 text-center">
        <h2>Informe de registros</h2>
      </div>
      <table id="table" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>Identificacion</th>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Edad</th>
            <th>Fecha Registro</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($datos as $dato): ?>
            <tr>
              <td><?php echo $dato['identification'] ?></td>
              <td><?php echo $dato['name'] ?></td>
              <td><?php echo $dato['phone'] ?></td>
              <td><?php echo $dato['email'] ?></td>
              <td><?php echo $dato['birthday'] ?></td>
              <td><?php echo $dato['created'] ?></td>
            </tr>
          <?php endforeach?>
        </tbody>
      </table>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
    $(document).ready( function () {
      $('#table').DataTable({
        lengthMenu: [
          [ 5, 25, 50, -1 ],
          [ '5', '25', '50', 'Todos' ]
        ],
        "columnDefs":[{
          "orderable":false,
        }],
        "aaSorting": [],
        dom: 'Blfrtip',
        buttons: [
            'excelHtml5',
            'csvHtml5'
        ],
        "language": {
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
              "sFirst":    "Primero",
              "sLast":     "Último",
              "sNext":     "Siguiente",
              "sPrevious": "Anterior"
          },
          "oAria": {
              "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
        }
      });
    });
    </script>
  </body>
</html>