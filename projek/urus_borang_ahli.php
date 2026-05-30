<?php include('inc_header.php');
semaklevel('admin');
# Nilai awal pembolehubah untuk 'value' dalam borang.
$nokadpengenalan = $password = $nama = $idkelas = "";
# Semak nilai POST daripada borang 
if(isset($_POST['nokadpengenalan'])){
 $nokadpengenalan = trim($_POST['nokadpengenalan']);
 $password = trim($_POST['password']);
 $nama = trim($_POST['nama']);
 $idkelas=$_POST['idkelas'];

 $sql = "INSERT IGNORE INTO ahli (nokadpengenalan, password, nama, idkelas)
     VALUES ('$nokadpengenalan', '$password', '$nama', $idkelas)";
 $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));    
 echo "<script> alert('Berjaya disimpan.');
   window.location.replace('urus_senarai_ahli.php'); </script>";
} ?>
<h1 style="font-size:30px">Borang Maklumat Ahli</h1>
<form method="POST" action="">
<p><label>No. Kad Pengenalan</label><br>
 <input type='text' name='nokadpengenalan' value='<?php echo $nokadpengenalan; ?>' required><br>
</p>
<p><label>Katalaluan</label><br>
<input type='password' name='password' value='<?php echo $nokadpengenalan; ?>' required><br>
</p>
<p><label>Nama</label><br>
<input type='text' name='nama' value='<?php echo $nama;?>' required><br>
</p>
<p><label><?php echo $label_kelas; ?></label><br>
<select name='idkelas' required>
<option value='' disabled selected>Sila pilih</option>
<?php
$sql = "SELECT * FROM kelas ORDER BY namakelas";
$result = mysqli_query($db,$sql);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
 $rowkelas = $row['idkelas'];
 $namakelas = $row['namakelas'];
 if($idkelas == $rowkelas){
  $selected = "selected";
 }else{
  $selected = "";
 }
 echo "<option $selected value='$rowkelas'>$namakelas</option>";
}   ?>
</select>
</p>
<p> <input type="submit" value="Simpan"></p>
</form>
<?php include('inc_footer.php'); ?>