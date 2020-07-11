<?php
	// KONFIGURASI KONEKSI DATABASE
	$hostname	= "localhost";
	$db_user	= "michael";
	$db_pass	= "michael";
	$db_name	= "counter";
	
	// KONEKSI DTABASE
	$connection = mysqli_connect($hostname, $db_user, $db_pass, $db_name);
	if(mysqli_connect_errno()) {
		die("Error connection to the Database");
	}

	// MENGECEK PENGUNJUNG DI DATABASE
	$query = "SELECT * FROM counter_table WHERE ip_address='$visitor_ip'";
	$result = mysqli_query($connection, $query);

	// MENAMPILKAN JUMLAH PENGUNJUNG
	$query = "SELECT * FROM counter_table";
	$result = mysqli_query($connection, $query);
	$rec_visitor = mysqli_num_rows($result);
	$total_visitors = $rec_visitor + 1;

	// MENGECEK QUERY BERJALAN DENGAN BAIK ATAU TIDAK
	if (!result){
		die("Retriving Query Error<br>".$query);
	}


	// MEMBACA ALAMAT IP PENGUNJUNG
	$visitor_ip = $_SERVER['REMOTE_ADDR'];

	// MENAMBAH DATA PENGUNJUNG BARU
	if(isset($visitor_ip)) {
		$query = "INSERT INTO counter_table(ip_address) VALUE('$visitor_ip')";
		$result = mysqli_query($connection, $query);
	}

	// MENGHAPUS DATA DALAM TABEL

	if(isset($_GET['hapus'])) {
		$query = "TRUNCATE TABLE counter_table";
		$result = mysqli_query($connection, $query);
		header('location: '.$_SERVER['PHP_SELF']);

	} 


?>

<!DOCTYPE html>
<html>
<head>
	<title>Visitor Counter</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<div class="container d-flex justify-content-center">

		
	</div>

	<div class="container">
		<div class="row m-5">
			<div class="col-5">
				
				<div class="card" style="width: 20rem;">
					<div class="card-header">
						<h1 class="display-5">
							Visitor Counter
						</h1>
					</div>
					<div class="card-body d-flex justify-content-center">
						<h1 class="display-1"><?php echo $total_visitors; ?></h1>
					</div>
					<div class="card-footer">
						<a href="http://localhost/click-counter/counter.php" class="btn btn-primary btn-block"><i class="fa fa-refresh"></i> &nbsp;
KUNJUNGI</a>
						<a href="http://localhost/click-counter/counter.php?hapus=semua" class="btn btn-danger btn-block" onclick="return confirm('Anda yakin ingin mereset data?')" id="resetBtn"><i class="fa fa-eraser"></i> &nbsp;
RESET DATA</a>
					</div>
				</div>

			</div>
			<div class="col-7">
				<table id="example" class="table table-striped table-bordered" style="width:100%">
				  <thead>
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">IP Address</th>
				      <th scope="col">Tanggal</th>
				      <th scope="col">Waktu</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php 
				  		$sql = "SELECT id, ip_address, visit_date FROM counter_table";
				  		// $hasil = $connection->query($sql);
						$hasil = mysqli_query($connection, $sql);


				  		if($hasil->num_rows > 0){
				  		while($row = $hasil->fetch_assoc()){ ?> 
				    <tr>
				      <td><?php echo $row["id"]; ?></td>
				      <td><?php echo $row["ip_address"]; ?></td>
				      <td>
				      	<?php 
				      		$oDate = new DateTime($row["visit_date"]);
							$sDate = $oDate->format("l, F d, Y");

							$hari = $oDate->format("l");
							$tanggal = $oDate->format("d");
							$bulan = $oDate->format("F");
							$tahun = $oDate->format("Y");
							$jam = $oDate->format("H");
							$menit = $oDate->format("i");
							$detik = $oDate->format("s");

				      		echo $hari ." "; 
				      		echo $tanggal ." ";  
				      		echo $bulan ." "; 
				      		echo $tahun ." "; 
				      	?>
				      		
				      </td>
				      <td>
				      	<?php
				      		echo $jam ."-"; 
				      		echo $menit ."-"; 
				      		echo $detik .""; 
				      	?>
				      	
				      </td>

				    </tr>

				    <?php } } else {
				    	echo "0 results";
				    } $connection->close(); ?>


		
				  </tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="container d-flex justify-content-center">
		<div class="page-footer m-5">
			<p>Copyright @ 2020 | <a href="https://github.com/janzenfaidiban" target="_blank">Janzen Faidiban</a></p>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#example').DataTable();
		});
	</script>

</body>
</html>