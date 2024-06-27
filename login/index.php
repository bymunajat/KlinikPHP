<?php
session_start();
include "../koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Poli Klinik | Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper mt-5">
					<div class="card fat mt-5">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<form method="POST" class="my-login-validation" novalidate="">
								<div class="form-group">
									<label for="username">Username</label>
									<input id="username" type="username" class="form-control" name="username" value="" required autofocus>
									<div class="invalid-feedback">
										Username is invalid
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
									<div class="invalid-feedback">
										Password is required
									</div>
								</div>

								<div class="form-group m-0">
									<input type="Submit" value="Login" name="submit" class="btn btn-primary btn-block">
								</div>
								<br><center><p>Repost by <a href='https://stokcoding.com/' title='StokCoding.com' target='_blank'>StokCoding.com</a></p></center>

							</form>
							<?php
							if (isset($_POST['submit'])) {
								$user = $_POST['username'];
								$pass = $_POST['password'];

								$query = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username='$user' AND password='$pass'");
								$masuk = mysqli_num_rows($query);
								if ($masuk == 0) {
									echo "<script>
        								alert('Username atau password anda salah ')
          							</script>";
								} else {
									$masuk1 = mysqli_fetch_assoc($query);
									if ($masuk1["jabatan"] == 'admin') {
										$_SESSION["jabatan"] = 'admin';
										$_SESSION["user"] = $user;
										echo "<script>
          									alert('Anda berhasil Login!')
          										document.location='../index.php'
          								</script>";
									} else if ($masuk1["jabatan"] == 'pembayaran') {
										$_SESSION["jabatan"] = 'pembayaran';
										echo "<script>
											alert('Anda berhasil Login!')
												document.location='../index.php'
										</script>";
									} else if ($masuk1["jabatan"] == 'pendaftaran') {
										$_SESSION["jabatan"] = 'pendaftaran';
										echo "<script>
											alert('Anda berhasil Login!')
												document.location='../index.php'
										</script>";
									} else if ($masuk1["jabatan"] == 'pemeriksaan') {
										$_SESSION["jabatan"] = 'pemeriksaan';
										echo "<script>
											alert('Anda berhasil Login!')
												document.location='../index.php'
										</script>";
									}
								}
							}
							?>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; Poli Klinik 2021
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>

</html>