<?php
$link = mysqli_connect("localhost","USERNAME","PASSWORD")  or die("failed to connect to server !!");
mysqli_select_db($link,"DATABASE");
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Wunschliste</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
  
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
</head>

<body>
<div class="navbar navbar-inverse">
	<center>
		<h1 style="color: lightgrey;">
			Wunschliste
		</h1>
	</center>
</div>

<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<table class="table table-striped table-condensed table-hover">
			<?php
				if(isset($_POST['done'])){
					$sqlt = "UPDATE artikel SET STATUS='1' WHERE ID=".$_POST['done']."";
					$result = mysqli_query($link,$sqlt)or die(mysqli_error());
				}
				if(isset($_POST['delete'])){
					$sqlt = "UPDATE artikel SET STATUS='2' WHERE ID=".$_POST['delete']."";
					$result = mysqli_query($link,$sqlt)or die(mysqli_error());
				}
				
				$sqlt = "SELECT * FROM artikel WHERE STATUS=0";
				$result = mysqli_query($link,$sqlt)or die(mysqli_error());
				
				echo "<thead><tr><th>Name</th><th>Link</th><th>Wert</th><th>Aktionen</th></tr></thead><tbody>";

				while($row = mysqli_fetch_array($result)) {
					$id = $row['ID'];
					$name = $row['NAME'];
					$url = $row['URL'];
					$wert = $row['WERT'];
					$status = $row['STATUS'];
					echo "<tr>
							<td>".$name."</td>
							<td><a href='".$url."' target='_blank'>".$url."</a></td>
							<td>".$wert." €</td>
							<form action='' method='POST'>
							<td>
							
							<button type='submit' value='".$id."' name='done' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button>
							
							<button type='submit' value='".$id."' name='delete' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>
							
							</td>
							</form>
						</tr>";
				} 
				echo "</tbody>";
				mysqli_close($con);
			?>				
			</table>	
		</div>
	</div>
	<div class="row clearfix">
	
		<div class="col-md-12 column">

		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#new" aria-controls="new" role="tab" data-toggle="tab">Neuer Eintrag</a></li>
			<li role="presentation"><a href="#gekauft" aria-controls="gekauft" role="tab" data-toggle="tab">Gekauft</a></li>
			<li role="presentation"><a href="#deleted" aria-controls="deleted" role="tab" data-toggle="tab">Gelöscht</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="new">
				<form role="form" action="" method="POST">
					<div class="form-group">
						 <label for="name">Name</label><input type="text" class="form-control" id="name" name="name">
					</div>
					<div class="form-group">
						 <label for="url">Link</label><input type="text" class="form-control" id="url" name="url">
					</div>
					<div class="form-group">
						<label class="sr-only" for="wert">Wert</label>
						<div class="input-group">
						  <div class="input-group-addon">€</div>
						  <input type="text" class="form-control" id="wert" name="wert" placeholder="Wert">
						</div>
					</div>
					<button type="submit" class="btn btn-default" name="submit" id="submit">Eintragen</button>
				</form>
				<?php
					if(isset($_POST['submit']))
					{
						$NAME = $_POST[name];
						$URL= $_POST[url];
						$WERT= $_POST[wert];

						$insert = "INSERT INTO artikel(NAME, URL, WERT, STATUS) VALUES ('$NAME', '$URL', '$WERT', '0')";
						mysqli_query($link,$insert) or die(mysqli_error($link));
					}
				?>
			</div>
			
			<div role="tabpanel" class="tab-pane" id="gekauft">
				<table class="table table-striped table-condensed table-hover">
				<?php
					$sqlt = "SELECT * FROM artikel WHERE STATUS=1";
					$result = mysqli_query($link,$sqlt)or die(mysqli_error());
					
					echo "<thead><tr><th>Name</th><th>Link</th><th>Wert</th></tr></thead><tbody>";

					while($row = mysqli_fetch_array($result)) {
						$id = $row['ID'];
						$name = $row['NAME'];
						$url = $row['URL'];
						$wert = $row['WERT'];
						$status = $row['STATUS'];
						echo "<tr class='success'>
								<td>".$name."</td>
								<td><a href='".$url."' target='_blank'>".$url."</a></td>
								<td>".$wert." €</td>
							</tr>";
					} 
					echo "</tbody>";
					mysqli_close($con);
				?>				
				</table>
			</div>

			<div role="tabpanel" class="tab-pane" id="deleted">
				<table class="table table-striped table-condensed table-hover">
				<?php
					$sqlt = "SELECT * FROM artikel WHERE STATUS=2";
					$result = mysqli_query($link,$sqlt)or die(mysqli_error());
					
					echo "<thead><tr><th>Name</th><th>Link</th><th>Wert</th></tr></thead><tbody>";

					while($row = mysqli_fetch_array($result)) {
						$id = $row['ID'];
						$name = $row['NAME'];
						$url = $row['URL'];
						$wert = $row['WERT'];
						$status = $row['STATUS'];
						echo "<tr class='danger'>
								<td>".$name."</td>
								<td><a href='".$url."' target='_blank'>".$url."</a></td>
								<td>".$wert." €</td>
							</tr>";
					} 
					echo "</tbody>";
					mysqli_close($con);
				?>				
				</table>
			</div>
		  </div>

		</div>
	</div>
</div>
</body>
</html>
