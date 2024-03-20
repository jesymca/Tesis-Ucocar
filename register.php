<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<?php
include('config.php');
session_start();
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cedula = $_POST['cedula'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo '<p class="error">El correo o la cedula ya esta registrado!</p>';
    }
    $query = $connection->prepare("SELECT * FROM users WHERE cedula=:cedula");
    $query->bindParam("cedula", $cedula, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo '<p class="error">la cedula ya esta registrado!</p>';
    }
    if ($query->rowCount() == 0) {
        $query = $connection->prepare("INSERT INTO users(username,password,email,cedula) VALUES (:username,:password_hash,:email,:cedula)");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("cedula", $cedula, PDO::PARAM_STR);
        $result = $query->execute();
        if ($result) {
            echo '<p class="success">Registro completo!</p>';
        } else {
            echo '<p class="error">Dato invalido!</p>';
        }
    }
}
?>

<body>
    <div class="Registro">
            <h1> Formulario de registro </h1>

            <form method="post" action="" name="signup-form">
                <div class="form-element">
                    <label>username</label>
                    <input type="text" name="username" pattern="[a-zA-Z0-9]+" require />
                </div>
                <div class="form-element">
                    <label>Email</label>
                    <input type="email" name="email" require />         
                </div>
                <div class="form-element">
                    <label>Cedula</label>
                    <input type="cedula" name="cedula" require />         
                </div>  
                <div class="form-element">
                    <label>Password</label>
                    <input type="password" name="password" require />         
                </div>
                <button type="submit" name="register" value="register">Registrar</button>
                <a href="login.php"> Ya estoy registrado </a>
            </form> 
    </div>        
</body>    