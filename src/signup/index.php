<?php
	session_start();

	if (isset($_SESSION['admin'])) {
		if ($_SESSION['admin'] == "yes") {
			header('Location: ../admin/productlist');
		} else {
			header('Location: ../');
		}
	}

	$errors = array();

	if (isset($_POST['signup'])) {
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$postalcode = str_replace(' ', '', $_POST['postalcode']);
		$email = $_POST['email'];
		$confirmemail = $_POST['confirmemail'];
		$password = $_POST['password'];
		$confirmpassword = $_POST['confirmpassword'];
		$admin = "no";

		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/users/' . $email . ".xml")) {
			$errors[] = "Email already registered";
		}

		if ($firstname == "" || $lastname == "" || $postalcode == "" || $email == "" || $password == "") {
			$errors[] = "Missing data";
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $errors[] = "Invalid email";
		}

		if ($email != $confirmemail) {
			$errors[] = "Emails do not match";
		}

		if ($password != $confirmpassword) {
			$errors[] = "Passwords do not match";
		}

		if (count($errors) == 0) {

			$users = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/users.xml');
			$user = $users -> addChild("user");

			$user -> addChild("firstname", $firstname);
			$user -> addChild("lastname", $lastname);
			$user -> addChild("postalcode", $postalcode);
			$user -> addChild("email", $email);
			$user -> addChild("password", md5($password));
			$user -> addChild("admin", $admin);
			$user -> addChild("cart", "[]");

			$users -> asXML($_SERVER['DOCUMENT_ROOT'] . '/databases/users.xml');

			header('Location: ../login');
			die;
		}

	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Trocery - Sign Up</title>
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
			<?php
				if (count($errors) > 0) {
					echo '<ul>';

					foreach($errors as $e) {
						echo '<li>' . $e . '</li>';
					}

					echo '</ul>';
				}
			?>
			<form method="post" action="">
				<p><b>First Name</b></p>
				<input type="text" name="firstname" placeholder="Type Here...">
				<br>
				<p><b>Last Name</b></p>
				<input type="text" name="lastname" placeholder="Type Here...">
				<br>
				<p><b>Postal Code</b></p>
				<input type="text" name="postalcode" placeholder="Type Here...">
				<br>
				<p><b>Email</b></p>
				<input type="text" name="email" placeholder="Type Here...">
				<br>
				<p><b>Confirm Email</b></p>
				<input type="text" name="confirmemail" placeholder="Type Here...">
				<br>
				<p><b>Password</b></p>
				<input type="password" name="password" placeholder="Type Here...">
				<br>
				<p><b>ConfirmPassword</b></p>
				<input type="password" name="confirmpassword" placeholder="Type Here...">
				<br><br>
				<input class="submit" name="signup" type="submit" value="Signup"></input>
			</form>
		</section>

		</div><footer>
			<p>Trocery</p>
			<p>Made by Chris El-Kehdy and Étienne Paquet</p>
		</footer>
	</body>
</html>
