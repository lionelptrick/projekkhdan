<?php include('inc_header.php');
semaklevel('admin');

if(isset($_GET['delete'])){
 $nokadpengenalan = $_GET['delete'];

 $sql = "DELETE FROM ahli WHERE nokadpengenalan = '$nokadpengenalan' ";
 $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
 echo "<script> alert('Akaun ahli berjaya dibuang.');
   window.location.replace('urus_senarai_ahli.php'); </script>"; die();
}

if(isset($_POST['idaktiviti']) && isset($_POST['sertai'])){
 $idaktiviti = $_POST['idaktiviti'];
 foreach ($_POST['sertai'] as $nokadpengenalan) {
  $sql = "INSERT IGNORE INTO hadir (nokadpengenalan, idaktiviti)
  VALUES ('$nokadpengenalan','$idaktiviti')";
  $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
 }
 echo "<script> alert('Ahli yang dipilih telah didaftarkan.');
 window.location.replace('urus_senarai_ahli.php');</script>";
}

$input_a = '';
$q = '';
if(isset($_POST['search'])){
 $input_a = $_POST['input_a'];
 if(!empty($input_a)){
  $q .= "WHERE ah.nokadpengenalan LIKE '%$input_a%' ";
 }
}
?>
<h1 style="font-size:30px">Urus Ahli</h1>
<a class='button' href="urus_borang_ahli.php">Tambah Ahli Baru</a> 
<br><br>
<form method='POST' action=''>
<input type='text' name='input_a' value='<?php echo $input_a; ?>' placeholder='No. Kad Pengenalan'>
<input type='submit' name='search' value='Cari'>
<input type='submit' name='reset' value='Reset'>
</form>
<hr>

<?php 
$sql = "SELECT ah.*, COUNT(h.nokadpengenalan) as jumlahaktiviti FROM ahli ah
  LEFT JOIN hadir h ON ah.nokadpengenalan= h.nokadpengenalan
  $q
  GROUP BY nokadpengenalan ORDER BY ah.nama ASC";

$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
$total = mysqli_num_rows($result);
if($total > 0){
 echo "Jumlah: $total<br>";
?>
<form action='' method='POST'>
<table class='table-data' border='1' cellpadding='4' cellspacing='0'>
  <tr>
  <th align='left' width='50'>Sertai</th> <th align='left'>No. KP Penyertaan</th>
  <th align='left'>Nama Ahli</th> <th align='left'>Penyertaan</th>
  <th align='center' width='150'>Tindakan</th>
 </tr>
<?php
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $nokadpengenalan = $row['nokadpengenalan'];
    $namaahli = $row['nama'];
    $jumlahaktiviti = $row['jumlahaktiviti'];
    echo "<tr><td align='center'><input type='checkbox' name='sertai[]' 
value='$nokadpengenalan'></td>
    <td>$nokadpengenalan</td> <td>$namaahli</td> <td 
align='center'>$jumlahaktiviti</td>
    <td align='right'>
    <a href='profil_ahli.php?nokadpengenalan=$nokadpengenalan'>Profil</a> -
    <a href='javascript:void(0);' onclick='deletethis(\"$nokadpengenalan\")'
>Buang</a>
    </td> </tr>";
} ?>
</table>
<p>
<label>Daftarkan Ahli Ke Aktiviti:</label><br>
<select name='idaktiviti' required>
<option value='' disabled selected>Sila pilih aktiviti</option>
<?php
$sql = "SELECT * FROM aktiviti ORDER BY jenisaktiviti";
$result = mysqli_query($db,$sql);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
 $idaktiviti = $row['idaktiviti'];
 $jenisaktiviti=$row['jenisaktiviti'];
 echo "<option value='$idaktiviti'>$jenisaktiviti</option>";
}
?>
</select>
</p>
<p> <input type="submit" value="Daftar Ahli"></p>
</form>
<?php
}else{
 echo "Belum ada rekod ahli.";
}   ?>
<script>
function deletethis(val){
if (confirm("Anda pasti untuk buang ahli ini?") == true) {
 window.location.replace('urus_senarai_ahli.php?delete='+val);
}
}
</script>
<?php include('inc_footer.php'); ?>
