<!DOCTYPE html>
<html dir="rtl">
<?php
ob_start();
error_reporting(0);

include('../includes/config.php');
session_start();
if ($_SESSION['alogin'] != '') {
	$_SESSION['alogin'] = '';
}
if (isset($_POST['login'])) {
	$uname = $_POST['username'];
	$password = $_POST['password'];
	$sql = "SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
	$query = $dbh->prepare($sql);
	$query->bindParam(':uname', $uname, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	if ($query->rowCount() > 0) {
		$_SESSION['alogin'] = $_POST['username'];
		echo "<script type='text/javascript'> document.location = '../dashboard.php'; </script>";
	} else {

		echo "<script>alert('Invalid Details');</script>";
	}
}
ob_end_flush();
?>

<head>
	<title>المشرفين</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<script>
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		input {
			background: rgba(245, 166, 35, 0.05);
			box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
			backdrop-filter: blur(20px);
			-webkit-backdrop-filter: blur(20px);
			border-radius: 10px;
			border: 1px solid rgba(255, 255, 255, 0.18);
		}
	</style>
</head>

<body>

	<section class="main" style="background-color: rgb(249, 115, 22);background-image: radial-gradient(at 20.41% 85.67%, rgb(156, 163, 175) 0, transparent 44%), radial-gradient(at 87.00% 25.83%, rgb(253, 186, 116) 0, transparent 71%), radial-gradient(at 9.02% 6.67%, rgb(248, 113, 113) 0, transparent 28%), radial-gradient(at 21.40% 34.33%, rgb(180, 83, 9) 0, transparent 38%), radial-gradient(at 45.74% 31.17%, rgb(236, 72, 153) 0, transparent 89%), radial-gradient(at 86.56% 69.33%, rgb(239, 68, 68) 0, transparent 75%);">
		<div class="flex justify-center items-center h-screen flex-col gap-10">
			<div class="text-center icon">
				<img width="300px" src="../images/login.jpg" class="rounded-lg shadow-lg"></p>
			</div>
			<div class="p-5">
				<form action="" method="POST">
					<input name="username" id="text1" type="text" class="py-3 px-10 placeholder:text-white w-full focus:outline-none focus:ring-4 ring-amber-400 text-white font-bold"
						placeholder="اسم المستخدم" required>
					<input name="password" id="myInput" type="Password" class="py-3 px-10 placeholder:text-white my-5 w-full focus:outline-none focus:ring-4 ring-amber-400 text-white font-bold"
						placeholder="كلمة السر" required>
					<button type="submit" name="login" class="w-full bg-amber-500 hover:bg-amber-600 duration-300 text-white font-bold py-4 rounded-lg shadow-lg">تسجيل الدخول</button>
				</form>
			</div>
			<div align="center" class="copyright">
				<a class="bg-rose-500 text-white py-2 px-3 font-extrabold text-xl rounded-full" target="_blankk" href="../about/">
					© SEADAWY
				</a>
			</div>
		</div>
	</section>

</body>

</html>