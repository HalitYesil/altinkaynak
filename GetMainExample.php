<?php
use Altinkaynak\Altinkaynak;


require_once 'src/Autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$Altinkaynak = new Altinkaynak();

?>
<!doctype html>
<html lang="tr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Altınkaynak GetMain Example</title>
  </head>
  <body>
  <div class="container">

	  <h1>GetMain Example</h1>
	  <h2>Instantly selected exchange rate, gold rate and parity information</h2>
	  <table class="table">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">Code</th>
	      <th scope="col">Desc</th>
	      <th scope="col">Buying</th>
	      <th scope="col">Selling</th>
	      <th scope="col">Update Time</th>
	    </tr>
	  </thead>
	  <tbody>
	<?php
	foreach ($Altinkaynak->GetMain() as $i => $Currency){
		?>
		<tr>
	      <th scope="row"><?= $i+1 ?></th>
	      <td><?= $Currency->code; ?></td>
	      <td><?= $Currency->desc; ?></td>
	      <td><?= $Currency->buying; ?></td>
	      <td><?= $Currency->selling; ?></td>
	      <td><?= $Currency->update_time; ?></td>
	    </tr>
		<?php 
	}
	?>
	</tbody>
	</table>
	</div>
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>