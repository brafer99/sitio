<?php include("./config/bd.php");?>
<?php

session_start();

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtContra=(isset($_POST['txtContra']))?$_POST['txtContra']:"";

if($_POST){

    //se usa esta forma, lo ideal seria hacer consulta a la base de datos
    
    //una vez validada la informacion le damos estos valores para que pueda usarse en otras plantilla
        $sentenciaSQL= $conexion->prepare("SELECT * FROM loginn WHERE nombre=:nombre AND contrasenia=:contrasenia");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':contrasenia',$txtContra);
        $sentenciaSQL->execute();
        $usuario=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if(isset($usuario['nombre'])){
        
        $_SESSION['usuario']="ok";
        $_SESSION['nombreUsuario']=$txtNombre;

        header('Location:inicio.php');
    }else{
        $mensaje="Error: El usuario ó contraseña son incorrectos";
    }

    }

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Administrador</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
      <div class="container">
          <div class="row">

          <div class="col-md-4">
          </div>

              <div class="col-md-4"> 
                  <br/><br/><br/>        
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <?php if(isset($mensaje)){ ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
                        <?php } ?>
                        <form method="POST">

                        <div class = "form-group">
                            <label>Usuario</label>
                            <input type="email" class="form-control" name="txtNombre" id="txtNombre" placeholder="Escribe tu usuario">
                        </div>
                        
                        <div class="form-group">
                            <label>Contraseña:</label>
                            <input type="password" class="form-control" name="txtContra" id="txtContra" placeholder="Escribe tu contraseña">
                        </div>

                        <button type="submit" class="btn btn-primary">Entrar al Adiministrador</button>
                        </form>
                        
                        


                        
                    </div>
                </div>
              </div>  
          </div>
      </div>
  </body>
</html>