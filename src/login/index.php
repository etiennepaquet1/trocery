<?php
	session_start();

	if (isset($_SESSION['admin'])) {
		if ($_SESSION['admin'] == "yes") {
			header('Location: ../admin/productlist');
		} else {
			header('Location: ../');
		}
	}

	$error = false;

	if (isset($_POST['login'])) {
		$email = $_POST['email'];
		$password = md5($_POST['password']);

		$users = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/users.xml');

		foreach ($users -> children() as $user) {
			if (isset($user -> email)) {

				if (($email == $user -> email) and ($password == $user -> password)) {
					$_SESSION['firstname'] = (string) ($user -> firstname);
					$_SESSION['lastname'] = (string) ($user -> lastname);
					$_SESSION['postalcode'] = (string) ($user -> postalcode);
					$_SESSION['email'] = (string) ($user -> email);
					$_SESSION['admin'] = (string) ($user -> admin);

					$_SESSION['cart'] = json_decode((string) ($user -> cart));

					if ($_SESSION['admin'] == "yes") {
						header('Location: ../admin/productlist');
					} else {
						header('Location: ../');
					}

					die;
				}

			}
		}

		$error = true;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Trocery - Login</title>
		<link href="/css/style.css" rel="stylesheet"/>
	</head>
	<body>
		<header>
			<div class="menu">
				<a href="/">Home</a>
				<div id="aisles">
					<button id="aisles-btn">Aisles
					</button>
					<div id="categories">
						<a href="/aisles/meat">Meat</a>
						<a href="/aisles/vegetables">Fruits & Vegetables</a>
					</div>
				</div>
				<a href="/login">Login</a>
				<a href="/signup">Sign Up</a>
				<a href="/cart">Cart</a>
			</div>
		</header>

		<section class="container" style="text-align:center">
			<form method="post" action="" onsubmit="localStorage.clear()">
				<?php
					if ($error) {
						echo '<p><b>Invalid email/password</b></p>';
					} elseif (isset($_SESSION['firstname'])) {
						echo $_SESSION['firstname'];
					}
				?>
				<p><b>Email</b></p>
				<input type="text" name="email" placeholder="Type Here...">
				<br>
				<p><b>Password</b></p>
				<input type="password" name="password" placeholder="Type Here...">
				<br><br>
				<input type="submit" name="login" value="Login" class="submit"></input>
			</form>
		</section>

		</div><footer>
			<p>Trocery</p>
			<p>Made by Chris El-Kehdy and Étienne Paquet</p>
		</footer>
	</body>
</html>
