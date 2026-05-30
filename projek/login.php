<?php include('inc_header.php');

if(isset($_POST['nokadpengenalan']) && isset($_POST['password'])){

  $nokadpengenalan = trim(strtolower($_POST['nokadpengenalan']));
  $password = trim($_POST['password']);
  $level = $_POST['level'];

  if($level == 'user'){
    $dbname = 'ahli';
    $medan_id = 'nokadpengenalan';
  }else{
    $dbname = 'guru';
    $medan_id = 'idguru';
    $level = 'admin';
  }


  $sql = "SELECT * FROM $dbname WHERE $medan_id='$nokadpengenalan' AND password='$password' LIMIT 1";
  $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));

  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){


     $_SESSION['nokadpengenalan'] = $row[$medan_id];
     $_SESSION['nama'] = $row['nama'];
     $_SESSION['level'] = $level;

     echo "<script> alert('Log Masuk berjaya.');
     window.location.replace('index.php'); </script>";
     die();
    }
  }else{
   echo "<script>alert('Log masuk tidak berjaya. Kesalahan Nombor Kad Pengenalan/katalaluan.'); </script>";
  }
 }
 ?>
 <table width='400' height='100%' align='center'>
 <tr><td align='center'>
   <h2>Log Masuk.</h2>
   <p>Jika anda belum mempunyai akaun ahli, klik <a href='signup.php'>Daftar</a>.</p>
   <form method="POST" action=''>

   <label>No. KP / ID Guru</label><br>
   <input type="text" name="nokadpengenalan" required><br><br>
   <label>Katalaluan</label><br>
   <input type="password" name="password" required><br><br>

   <label>Tahap Akses</label><br>
   <select name="level">
    <option value="user" selected>Ahli</option>
    <option value="admin">Guru</option>
   </select>
   <br><br>
   <input type="submit" name="" value="Log Masuk">
  </form>
 </td></tr>
</table>
<?php
include('inc_footer.php');
?>