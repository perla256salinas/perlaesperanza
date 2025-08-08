<?php
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Person Registration System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-section">
            <h3>Person Registration</h3>
            <form action="guardar.php" method="POST">
                <input type="text" name="nombre" placeholder="Name" required>
                <input type="text" name="seccion" placeholder="Section" required>
                <input type="text" name="telefono" placeholder="Phone" required>
                <button type="submit">Register</button>
            </form>
        </div>
        <div class="table-section">
            <h3>Registered Persons</h3>
            <!-- Aquí se incluirá la tabla con los registros -->
        </div>
    </div>
</body>
</html>
