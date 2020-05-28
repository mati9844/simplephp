<?php 
$polaczenie = @new mysqli('localhost', 'root', '', 'lab6');
if (mysqli_connect_errno() != 0){
  echo '<p>Błąd połączenia: '.mysqli_connect_error().'</p>';
}
?>
<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">

    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Brand</a>
    </div>
    <ul class="nav navbar-nav">
	  <?php
if (mysqli_connect_errno() != 0){
  echo '<p>Błąd połączenia: '.mysqli_connect_error().'</p>';
}
else {
  $wynik = @$polaczenie->query("SELECT id, title, level FROM pages");
  if ($wynik === false){
    echo '<p>Zapytanie nie zostało wykonane poprawnie!</p>';
    $polaczenie -> close();
  }
  else {
    while (($menu = $wynik -> fetch_assoc()) !== null){
	if(isset($_SESSION['level']))
	  if($_SESSION['level']== $menu['level'])
	  echo '<li><a href="index.php?page='. $menu['id'].'">'.$menu['title'].'</a></li>';
    }
    $wynik -> close(); // zwolnienie pamięci

  }
}
?>
    </ul>
	<ul class="nav navbar-nav navbar-right">
	<?php
	if(isset($_SESSION['imie'])){
		echo '<li><a>Jestes zalogowany jako '.$_SESSION['imie'].'</a></li>';
		echo '<li><a href="wyloguj.php"> Wyloguj</a></li>';

	}else{
		echo '<li><a href="login.php"> Zaloguj</a></li>';
	}
	?>
    </ul>
  </div>
</nav>
  
<div class="container">
<?php
if (isset($_GET['page'])) {
$id = (int)$_GET['page'];
if (mysqli_connect_errno() === 0){
	
	  $wynik = @$polaczenie->query('SELECT * FROM pages WHERE id="'.$id.'"');
  if ($wynik === false){
    echo '<p>Zapytanie nie zostało wykonane poprawnie!</p>';
    $polaczenie -> close();
  }
  else {
    while (($content = $wynik -> fetch_assoc()) !== null){
		if(isset($_SESSION['level']))
		if($_SESSION['level']!= $content['level']){
			echo '<p>Nie masz wystarczających uprawnień</p>';
		}else
			echo ''.$content['content'];
    }
	}
} 
}else{
	echo '<h1>Strona główna</h1><p>Przejdź do podstron, aby zapoznać się z zasobami witryny</p>';
}
?>
  </div>

</body>
</html>
