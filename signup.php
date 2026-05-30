<?php include('inc_header.php');
# Pembolehubah untuk menyimpan input pengguna
$nokadpengenalan = $nama = $password = $idkelas = '';
# String untuk simpan mesej ralat
$error = '';

if(isset($_POST['nokadpengenalan'])){

 $nokadpengenalan = trim($_POST['nokadpengenalan']);
 $password = trim($_POST['password']);
 $nama = trim($_POST['nama']);
 $idkelas = $_POST['idkelas'];

 # Semak supaya semua maklumat sudah diisi (tidak empty)
 if(empty($nama) || empty($nokadpengenalan) || empty($password)){
  $error .= "Sila isi semua ruang di borang pendaftaran. ";
 }
 # Dapatkan bilangan aksara nokadpengenalan
 $id_lenght = strlen($nokadpengenalan);
 # Had atas untuk panjang nokadpengenalan
 if($id_lenght > 14){
  $error .= "No.KP terlalu panjang. Maksima 14 aksara. ";
 }
 # Had bawah untuk panjang nokadpengenalan
 if($id_lenght < 14){
  $error .= "No.KP terlalu pendek. Minima 14 aksara. ";
 }
 # Had bawah untuk password
 $password_lenght = strlen($password);
 if($password_lenght < 6){
  $error .= "Katalaluan terlalu pendek. Minima 6 aksara. ";
 }
 # Semak jika ID sudah wujud dalam database
 $sql = "SELECT * FROM ahli WHERE nokadpengenalan='$nokadpengenalan' LIMIT 1";
 $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));

 if(mysqli_num_rows($result) > 0){
  $error .= "No. KP ($nokadpengenalan) sudah digunakan, sila pilih No. KP 
berbeza.";
 }
 # Jika tiada error, teruskan pendaftaran
 if(empty($error)){
  $sql = "INSERT INTO ahli (nokadpengenalan, password, nama,idkelas)
  VALUES ('$nokadpengenalan', '$password', '$nama', $idkelas)";
  $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
  echo "<script>
  alert('Pendaftaran berjaya. Sila Log Masuk menggunakan No.KP ($nokadpengenalan).');
      window.location.replace('login.php'); </script>";
   die();
 }else{
  echo "<script>alert('$error');</script>";
 }
}
?>
<table width='400' height='100%' align='center'>
<tr>
<td align='center'>
 <h2>Daftar Akaun</h2>
 <p>Jika anda sudah mempunyai akaun, klik <a href='login.php'>Log Masuk</a></p>
 <form method='POST' action=''>
  <label> No. Kad Pengenalan</label><br>
  <input type="text" name="nokadpengenalan" value='<?php echo 
$nokadpengenalan; ?>' required><br><br>
  <label>Katalaluan</label><br>
  <input type="password" name="password" value='<?php echo $password; ?>'required><br><br>
  <label>Nama</label><br>
  <input type="text" name="nama" value='<?php echo $nama;?>'required><br>
  <p>
  <label><?php echo $label_kelas; ?></label><br>
  <select name='idkelas' required>
  <option value='' disabled selected>Sila pilih</option>
  <?php
   # Dapatkan senarai kumpulan untuk dijadikan dropdown
  $sql = "SELECT * FROM kelas ORDER BY namakelas";
  $result = mysqli_query($db,$sql);

  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

   $rowkelas=$row['idkelas'];
   $namakelas=$row['namakelas'];

   if($idkelas == $rowkelas){
    $selected = "selected";
   }else{
    $selected = "";
   }
   echo "<option $selected value='$rowkelas'>$namakelas</option>";
  }
  ?>
  </select>
  </p>
  <input type="submit" name='signup' value="Daftar">
 </form>
</td>
</tr>
</table>

<?php include('inc_footer.php'); ?>