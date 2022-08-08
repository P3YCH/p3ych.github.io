<?php
   if (isset($_POST['akses']))
   {
     $pass = $_POST['pass'];
     if ($pass == "k3513003")
     {
        echo "ini adalah contoh halaman php yang akan di password";
     }
     else {
            echo "<script>alert('Password Salah'); window.history.back()</script>";
          }
   }
   else {
   	?>
           <form method="POST" action="">
              Masukkan Password <br/><input type="password" name="pass"><br/>
              <input type="submit" name="akses" value="Ijinkan"> 
            </form>
    <?php
        }
?>