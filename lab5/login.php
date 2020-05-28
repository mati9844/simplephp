<?php    /* zaloguj.php  */
session_start();
//session_register('imie');
?>
<?php 
$polaczenie = @new mysqli('localhost', 'root', '', 'lab6');
if (mysqli_connect_errno() != 0){
  echo '<p>Błąd połączenia: '.mysqli_connect_error().'</p>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Simple Login Form</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style type="text/css">
	.login-form {
		width: 340px;
    	margin: 50px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="container">
<div class="login-form">
    <form action="" method="get">
        <h2 class="text-center">Logowanie</h2>       
        <div class="form-group">
            <input type="text" class="form-control" name="kto" placeholder="Username" required="required">
        </div>
        <div class="form-group">
            <button type="submit" name="log" class="btn btn-primary btn-block">Zaloguj</button>
        </div>    
    </form>


<?php
  if(array_key_exists("log",$_GET)) 
  if($_GET['kto'] <>"") 
//imie nie moze byc puste
  {
	if(mysqli_connect_errno() != 0){
		  echo '<p class=\"text-center\">Błąd połączenia: '.mysqli_connect_error().'</p>';
	}
	
	if (mysqli_connect_errno() === 0){
		$id = $_GET['kto'];
	  $wynik = @$polaczenie->query('SELECT * FROM users WHERE login="'.$id.'"');
	if ($wynik === false){
    echo '<p class="text-center">Zapytanie nie zostało wykonane poprawnie!</p>';
		$polaczenie -> close();
	}
	else {
		$i=0;
		while (($user = $wynik -> fetch_assoc()) !== null){
		$_SESSION['imie']=$user['name'];
		$_SESSION['login']=$user['login'];
		$_SESSION['level']=$user['level'];
		$i++;
    }
		}
	} 
    if($i!=0)
    echo "<p class=\"text-center\">Zostales zalogowany jako </br>".$_SESSION['imie']."</p>";
	else "<p class=\"text-center\">Błędny login użytkownika. Spróbuj jeszcze raz</p>";
	    $polaczenie -> close();

  }
  //else echo "Musisz podac imie";
?>
<p class="text-center"><a href="index.php">Powrót</a>
</div>
</div>
</body>
</html>  

