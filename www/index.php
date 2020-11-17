<?php
// Rozpoczęcie sesji użytkownika.
session_start();

// Połączenie z bazą danych.
// WSTAW WŁASNE USTAWIENIA!!!
$dbuser = '';
$dbpass = '';
$dbname = '';
$mysqli = new mysqli('localhost', $dbuser, $dbpass, $dbname) or die(mysql_error());

// UIstawienie kodowania UTF-8.
$mysqli->query("SET NAMES utf8");

// Zmienna przechowująca typ akcji.
$action = '';

// Wykonanie akcji.
if ($_GET['action'] == 'login') {
	$action = 'login';
	$id = $mysqli->real_escape_string($_GET['id']);

	$result = $mysqli->query("SELECT name,photo FROM users WHERE id=$id") or die ($mysqli->error());
	$num = $result->num_rows;
	
	if ($num > 0) { 
		list($name, $photo) = $result->fetch_row();
	
		// Ustawienie zmiennych dla sesji.
		$_SESSION['user_id'] = $id;
		$_SESSION['user_name'] = $name;
		$_SESSION['user_photo'] = $photo;
		
		// Ustawienie ciasteczka (60 dni).
		if (isset($_GET['remember'])) {
			setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*60, "/");
			setcookie("user_name", $_SESSION['user_name'], time()+60*60*24*60, "/");
			setcookie("user_photo", $_SESSION['user_photo'], time()+60*60*24*60, "/");
		}
		
		// Wyszukaj wypożyczone książki.
		$result = $mysqli->query("SELECT title FROM books WHERE loan=$id") or die ($mysqli->error());
		$num = $result->num_rows;

		$_SESSION['user_books'] = "";

		while ($num > 0) {
			list($title) = $result->fetch_row();
			$_SESSION['user_books'] .= "<li>" . $title . "</li>";
			$num -= 1;
		}
	} else {
		$msg = urlencode("Niepoprawny identyfikator. Proszę spróbować ponownie.");
		header("Location: index.php?msg=$msg");
	}	
} else if ($_GET['action'] == 'book') {
	$action = 'book';
	$id = $mysqli->real_escape_string($_GET['id']);

	$result = $mysqli->query("SELECT title,loan FROM books WHERE id=$id") or die ($mysqli->error());
	$num = $result->num_rows;
	
	if ($num > 0) { 
		list($name, $loan) = $result->fetch_row();
	
		// Ustawienie zmiennych dla bieżącej sesji.
		$_SESSION['book_id'] = $id;
		$_SESSION['book_title'] = $name;
		$_SESSION['book_loan'] = $loan;
		
		// Sprawdzenie kto wypożyczył książkę.
		if ($loan > 0) {
			$result = $mysqli->query("SELECT name FROM users WHERE id=$loan") or die ($mysqli->error());
			$num = $result->num_rows;
			
			if ($num > 0) {
				list($name) = $result->fetch_row();
				$_SESSION['book_loan_name'] = $name;
			}
		}
	} else {
		$msg = urlencode("Niepoprawny identyfikator. Proszę spróbować ponownie.");
		header("Location: index.php?msg=$msg");
	}	
} else if ($_GET['action'] == 'loan') {
	$action = 'loan';
	
	$user_id = $_SESSION['user_id'];
	$book_id = $_SESSION['book_id'];
	
	$result = $mysqli->query("UPDATE books SET loan=$user_id WHERE id=$book_id") or die ($mysqli->error());
	
	header("Location: index.php?action=login&id=$user_id");
} else if ($_GET['action'] == 'return') {
	$action = 'return';
	
	$user_id = $_SESSION['user_id'];
	$book_id = $_SESSION['book_id'];
	
	$result = $mysqli->query("UPDATE books SET loan=NULL WHERE id=$book_id") or die ($mysqli->error());
	
	header("Location: index.php?action=login&id=$user_id");
}
?>

<html>
<head>
<title>qrcode</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="qrcodes.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="main">

<div id="contents">
	<?php if ($action == 'login') { ?>
	<h1 class="name"><img src="data:image/png;base64, <?php echo $_SESSION['user_photo']?>"/>
		<?php echo $_SESSION['user_name']?></h1>
	<div>Książki: <ol>
		<?php echo $_SESSION['user_books']?>
	</ol></div>
	<?php } else if ($action == 'book') { ?>
	<h1 class="name"><?php echo $_SESSION['book_title']?></h1>
		<?php if ($_SESSION['book_loan']) { ?>
			<div>Wypożyczona przez: <?php echo $_SESSION['book_loan_name']?></div>
			<div class="button"><a href="index.php?action=return">Zwróć książkę</a></div>
		<?php } else { ?>
			<div class="button"><a href="index.php?action=loan">Wypożycz książkę</a></div>
		<?php } ?>
	<?php } ?>

<p>
<?php
// Wyświetlanie wiadomości.
if (isset($_GET['msg'])) {
	$msg = urldecode($_GET['msg']);
	echo "<div class=\"msg\">$msg</div>";
}
?>
</p>
</div>

<div id="footer">
	<p class="copy">&copy; Wydział Mechaniczno-Technologiczny<br>Politechniki Rzeszowskiej<br>
	ul. Kwiatkowskiego 4, 37-450 Stalowa Wola</p>
</div>

</div>

</body>
</html>
