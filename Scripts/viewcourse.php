<?php 

session_start();

// // Connect to the Database
// $db = mysql_connect("localhost","nosotros","oeaeavaluo2013");

// // Choose the database 'Avaluo'
// if ($db) {
//   mysql_select_db("Avaluo");
// } else {
//   echo "no salio";
//   exit();
// }

$name = $_GET['nombre_act'];
$id = $_GET['act_id'];


$table="<center> <h1>".$name." ".$id."</h1>
							<table id='rubrica'><tr>
				<td><button type='button' onclick='change_number_rows()'>Edit</button></td>
				<td>1-2</td>
				<td>3-4</td>
				<td>5-6</td>
				<td>7-8</td>
			  </tr>";
for ($i=0; $i < 5; $i++) { 
		$table=$table."<tr>
				<td><p>Nombre</p>
				</td>
				<td>Descripcion</td>
				<td>Descripcion</td>
				<td>Descripcion</td>
				<td>Descripcion</td>
			  </tr>";
}
echo $table."</table>
						</center> 	";

 ?>