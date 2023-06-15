<?php

$categoria  = $_POST['categoria'];
$id  = intval($_POST['id']);

require '../model/conexion.php';
$conexion = new Conexion();
$conexion->conectar();

$sql = "SELECT nombre
FROM categorias
WHERE LOWER(nombre) = LOWER('$categoria');";
$resultado1 = $conexion->query($sql); // Para comprobar si hay categorias con el msimo nombre

$sql2 = "SELECT nombre
FROM categorias
WHERE id_categoria_pk = '$id';";
$resultado2 = $conexion->query($sql2);
while ($row = $resultado2->fetch_assoc()) {
  $categoriadb = $row['nombre']; // para verificar si no se han realizado cambios
}

if (empty($categoria)) {
  echo 'error_1'; // Campos obligatorios
} else {
  if ($categoriadb == $categoria) {
    echo 'error_2'; // no se han realizado cambios
  } else {
    if ($resultado1->num_rows > 0) {
      echo 'error_3'; // existe una categoría con el mismo nombre
    } else {
      $sql2 = "UPDATE categorias SET nombre='$categoria' WHERE id_categoria_pk=$id";
      $resultado2 = $conexion->query($sql2);

      if ($resultado2) {
        echo 'success'; // actualización exitosa
      } else {
        echo 'error_4'; // error en la actualización
      }
    }
  }
}

