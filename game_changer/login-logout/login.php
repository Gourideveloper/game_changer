<!-- Coach Name: "admin"
Password: "123456" -->
<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>LOGIN</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <form action="authentication.php" method="POST">
        <h2>LOGIN</h2>
        <label>Coach Name</label>
        <input type="text" name="name" placeholder="Coach Name"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit">Login</button>
    </form>
    <script src="../assets/dist/js/sweetalert.min.js"></script>
    <?php
        if(isset($_SESSION['status'])) {
    ?>
    <script>
        swal({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            button: "OK"
        });
    </script>
    <?php
            unset($_SESSION['status']);
        }
    ?>
</body>

</html>