<html>
<head>
  <title>Programacion III Vladimir Bocaranda</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>

<div class="row">
  <div class="col-md-4"></div>

<!-- LO QUE QUIERO HACER ES COMO UN SISTEMA PARA UN CONDOMINIO EL CUAL EL PROPIETARIO PUEDA REGISTRARSE EN UNA BASE DE DATOS Y GUARDAR TODA SU INFORMACION -->


  <div class="col-md-4">

    <center><h1>DATOS DEL PROPIETARIO</h1></center>

    <form method="POST" action="registro.php" >

    <div class="form-group">
      <label for="doc">Documento (C.I)</label>
      <input type="text" name="doc" class="form-control" id="doc">
    </div>

    <div class="form-group">
        <label for="nombre">Nombre </label>
        <input type="text" name="nombre" class="form-control" id="nombre" >
    </div>

    <div class="form-group">
        <label for="dir">Direccion de la Casa (Numero y Calle) </label>
        <input type="text" name="dir" class="form-control" id="dir">
    </div>

    <div class="form-group">
        <label for="tel">Telefono </label>
        <input type="text" name="tel" class="form-control" id="tel">
    </div>
    
    <center>
      <input type="submit" value="Registrar" class="btn btn-success" name="btn_registrar">
      <input type="submit" value="Consultar" class="btn btn-primary" name="btn_consultar">
      <input type="submit" value="Actualizar" class="btn btn-info" name="btn_actualizar">
      <input type="submit" value="Eliminar" class="btn btn-danger" name="btn_eliminar">
    </center>

  </form>

  <?php
    include("abrir_conexion.php");
      //DEFINIMOS VARIABLES
      $doc    ="";
      $nombre ="";
      $dir    ="";
      $tel    ="";

      //PARA REGISTRAR USUARIOS
      if(isset($_POST['btn_registrar']))
      {      
        $doc = $_POST["doc"];
        $nombre = $_POST["nombre"];
        $dir = $_POST["dir"];
        $tel = $_POST["tel"];
       
        if($doc==""  || $nombre==""  || $dir=="")
        {
          echo "Debe llenar los campos obligatorios";
        }
        else {
          mysqli_query($conexion, "INSERT INTO $tabla_db1 
          (doc, nombre, direccion, telefono) 
            values 
          ('$doc','$nombre', '$dir', '$tel')");
          echo "Se registraron los datos correctamente";
      }
      }


      //PARA HACER CONSULTAS DE LOS USUARIOS EN LA BASE DE DATOS
      if(isset($_POST['btn_consultar']))
      {
        $doc = $_POST["doc"];
        $existe=0;
        if($doc=="")
        {
          echo "El documento es un campo obligatorio";
        }
        else {
        //codigo para consultar
        $resultados = mysqli_query($conexion,"SELECT * FROM $tabla_db1 WHERE doc = '$doc'");
        while($consulta = mysqli_fetch_array($resultados))
        {
         echo $consulta['doc']."<br>";
         echo $consulta['nombre']."<br>";
         echo $consulta['direccion']."<br>";
         echo $consulta['telefono']."<br>";
         $existe++;
        }
        if ($existe==0){
          echo "EL Documento no Existe";
        }
      }
      }

      //PARA ACTUALIZAR, SE DEBE COLOCAR EN EL CAMPO DE IDENTIDAD OBLIGATORIAMENTE EL DOCUMENTO DEL USUARIO QUE SE QUIERA ACTUALIZAR O MODIFICAR
      if(isset($_POST['btn_actualizar']))
      {
             
        $doc = $_POST["doc"];
        $nombre = $_POST["nombre"];
        $dir = $_POST["dir"];
        $tel = $_POST["tel"];
       
        if($doc==""  || $nombre==""  || $dir=="")
        {
          echo "Debe llenar los campos obligatorios";
        }
        else {
          //ESTA ES UNA CONSULTA PARA VERIFICAR SI LA DOCUMENTACION EXISTE O NO
          $existe=0;
          $resultados = mysqli_query($conexion,"SELECT * FROM $tabla_db1 WHERE doc = '$doc'");
          while($consulta = mysqli_fetch_array($resultados))
          {
          $existe++;
          }
          if ($existe==0){
            echo "EL Documento no Existe";
          }
          else {
            //CODIGO PARA ACTUALIZAR DATOS
            $_UPDATE_SQL="UPDATE $tabla_db1 Set 
            doc='$doc', 
            nombre='$nombre'
            direccion='$dir'
            telefono='$tel'
            WHERE doc='$doc'"; 
            mysqli_query($conexion,$_UPDATE_SQL); 

            echo "Datos actualizados exitosamente";
          }
      }
      }


      //PARA ELIMINAR USUARIOS DE LA DATABASE, IGUAL, SE DEBERA COLOCAR OBLIGATORIAMENTE ES SOLO LA DOCUMENTACION DEL CAMPO QUE SE QUIERA ELIMINAR DE LA DATABASE
      if(isset($_POST['btn_eliminar']))
      {
        $doc = $_POST["doc"];
        $existe=0;
        if($doc=="")
        {
          echo "El documento es un campo obligatorio";
        }
        else {
        $resultados = mysqli_query($conexion,"SELECT * FROM $tabla_db1 WHERE doc = '$doc'");
        while($consulta = mysqli_fetch_array($resultados))
        {
         $existe++;
        }
        if ($existe==0){
          echo "EL Documento no Existe";
        }
        else {
          $_DELETE_SQL =  "DELETE FROM $tabla_db1 WHERE doc = '$doc'";
          mysqli_query($conexion,$_DELETE_SQL); 
          echo "Se elimino el campo exitosamente";
      }
      }
    }

    include("cerrar_conexion.php");
  ?>

  </div>

  <div class="col-md-4"></div>
</div>



  
  
</body>
</html>