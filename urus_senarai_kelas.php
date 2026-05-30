<?php include('inc_header.php');
semaklevel('admin');
# Semak jika ada parameter 'delete' di URL.
if(isset($_GET['delete'])){
 $idkelas = $_GET['delete'];
 $sql = "DELETE FROM kelas WHERE idkelas = $idkelas ";
 $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
 echo "<script> alert('Kelas berjaya dibuang.');
   window.location.replace('urus_senarai_kelas.php'); </script>"; die();
}  ?>
<h1 style="font-size:30px">Urus <?php echo $label_kelas; ?></h1>
<a class='button' href="urus_borang_kelas.php">Tambah <?php echo 
$label_kelas; ?> Baru</a> <br><br>
<?php
$sql = "SELECT k.*, COUNT(ah.nokadpengenalan) as jumlahahli FROM kelas k
   LEFT JOIN ahli ah ON ah.idkelas = k.idkelas
   GROUP BY k.idkelas ORDER BY namakelas";
$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
$total = mysqli_num_rows($result);

if($total > 0){
 echo "Jumlah: $total<br>";
 echo "<table class='table-data' border='1' cellpadding='4' cellspacing='0'>
  <tr><th align='left'>Nama $label_kelas</td>
   <th align='center' width='150'>Tindakan</td></tr>";

 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $id = $row['idkelas'];
  $name = $row['namakelas'];
  $jumlahahli = $row['jumlahahli'];
  echo "<tr>
    <td>$name ($jumlahahli ahli)</td>
    <td align='right'>
     <a href='urus_borang_kelas.php?id=$id'>Edit</a> -
     <a href='javascript:void(0);' onclick='deletethis($id)' >Buang</a>
    </td>
   </tr>";
 }
 echo "</table>";
}else{
 echo "Belum ada rekod $label_kelas.";
} ?>
<script>
function deletethis(val){
if (confirm("Anda pasti untuk buang?") == true) {
 window.location.replace('urus_senarai_kelas.php?delete='+val);
}
}
</script>
<?php include('inc_footer.php'); ?>