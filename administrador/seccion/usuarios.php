<?php include("template_seccion/cabecera.php");?>
<?php include("../config/bd.php");?>

<?php 
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtContra=(isset($_POST['txtContra']))?$_POST['txtContra']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";


switch($accion){
    case "Agregar":
        $sentenciaSQL= $conexion->prepare("INSERT INTO loginn(nombre,contrasenia) VALUES (:nombre,:contrasenia);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':contrasenia',$txtContra);
        $sentenciaSQL->execute();
        header("Location:usuarios.php");
        break;

    case "Modificar":
        //echo "Presionado boton modificar";

        $sentenciaSQL= $conexion->prepare("UPDATE loginn SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();

        
        $sentenciaSQL= $conexion->prepare("UPDATE loginn SET contrasenia=:contrasenia WHERE id=:id");
        $sentenciaSQL->bindParam(':contrasenia',$txtContra);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        
        header("Location:usuarios.php");
        break;
    
    case "Cancelar":
        
        header("Location:usuarios.php");


        break;
    
    case "Seleccionar":
        //echo "Presionado boton seleccionar";
        $sentenciaSQL= $conexion->prepare("SELECT * FROM loginn WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $usuario=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$usuario['nombre'];
        $txtContra=$usuario['contrasenia'];


        break;

    case "Borrar":
        
        $sentenciaSQL= $conexion->prepare("DELETE FROM loginn WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        header("Location:usuarios.php");
            //echo "Presionado boton borrar";
        break;
}

$sentenciaSQL= $conexion->prepare("SELECT * FROM loginn");
$sentenciaSQL->execute();
$ListaUsuario=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);





?>


    <div class="col-md-5">

        <div class="card">
            <div class="card-header">
                Usuarios
            </div>

            <div class="card-body">
                <form method="POST"> 
                    <div class = "form-group">
                        <label for="txtID">ID:</label>
                        <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID"  placeholder="ID">
                    </div>

                    <div class = "form-group">
                        <label for="txtNombre">Usuario:</label>
                        <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre"  placeholder="Nombre">
                    </div>

                    <div class = "form-group">
                        <label for="txtContra">Contraseña:</label>
                        <input type="password" required class="form-control" value="<?php echo $txtContra; ?>" name="txtContra" id="txtContra"  placeholder="Contra">
                    </div>

                    


                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" <?php echo($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" <?php echo($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                        <button type="submit" name="accion" <?php echo($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>  



    <div class="col-md-7">
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach($ListaUsuario as $usuario) { ?>
                <tr>
                    <td><?php echo $usuario['id'] ?> </td>
                    <td><?php echo $usuario['nombre'] ?></td>
                    <td><?php echo $usuario['contrasenia'] ?></td>
                    <td>
                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $usuario['id'] ?>"/>
                        
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>

                    </form>


                    </td>
                
                </tr>
            <?php  } ?>

            </tbody>
        </table>



    </div>


<?php include("template_seccion/pie.php");?>