

<section class="content container-fluid">
	<h2>TABLA DE PUNTOS</h2>
                              
	<input type="text" name="nombre" placeholder="Buscar por nombre" class="form-control filtro" id="busquedaTabla" onkeyup="myFunction()">
      
	<div class="box-body table-responsive no-padding table-container">
		<table class="table table-hover" id="tabla">
			<thead>
				<tr>
					<th>Posicion</th>
					<th>Jugador</th>
					<th>Puntos</th>
					<th>Jugados</th>
					<th>Rojas</th>
					<th>Amarillas</th>
				</tr>
			</thead>
			<?php
				//if(!empty($tablaRecords))
				//{	
				    $i = 11;
					foreach($tablaRecords as $record)
					{
						$i = $i - 1; 
						if($record->puntos > 0 or (0 < $i && $i < 11))
						{
							?>
							<tr>
								<td><?php echo $record->puesto ?></td>
								<td><?php echo $record->first_name ." ".$record->last_name ; ?></td>
								<td><?php echo $record->puntos ?></td>
								<td><?php echo $record->partidos ?></td>
								<td><?php echo $record->rojas ?></td>
								<td><?php echo $record->amarillas ?></td>
							</tr>
							<?php
						}
					}
				//}
			?>
		</table>

	</div><!-- /.box-body -->
</section>

<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("busquedaTabla");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabla");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>