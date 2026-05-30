<?php include('inc_header.php');
semaklevel('admin');
# Fungsi Delete aktiviti
if(isset($_GET['delete'])){
 $idaktiviti = $_GET['delete'];
 $sql = "SELECT * FROM aktiviti WHERE idaktiviti = $idaktiviti LIMIT 1";
 $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
 if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
   # Semak jika imej aktiviti ada, delete gambar dulu
   $imej = $row['imej'];
   $file = __DIR__ . '/imej/'.$imej;
   if(!empty($imej) && file_exists($file)){
    unlink($file);
   }
  }
  # Delete aktiviti dari pangkalan data
  $sql = "DELETE FROM aktiviti WHERE idaktiviti = $idaktiviti";
  $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
  echo "<script> alert('Aktiviti berjaya dibuang.');
    window.location.replace('urus_senarai_aktiviti.php'); </script>"; die();
  }
}
$input_a = '';
$q = '';
if(isset($_POST['search'])){
 $input_a = $_POST['input_a'];
 if(!empty($input_a)){
  $q .= "WHERE ak.jenisaktiviti LIKE '%$input_a%' ";
 }
} ?>
<h1 style="font-size:30px">Urus Aktiviti</h1>
<a class='button' href="urus_borang_aktiviti.php">Tambah Aktiviti Baru</a> <br><br>
<form method='POST' action=''>
<input type='text' name='input_a' value='<?php echo $input_a; ?>' placeholder='Jenis Aktiviti'>
<input type='submit' name='search' value='Cari'>
<input type='submit' name='reset' value='Reset'>
</form>
<hr>
<?php
$sql = "SELECT ak.idaktiviti, ak.*, g.nama, COUNT(h.idhadir) as jumlahpeserta FROM 
aktiviti ak
   LEFT JOIN hadir h on h.idaktiviti = ak.idaktiviti
   LEFT JOIN guru g on g.idguru = g.idguru $q
   GROUP BY ak.idaktiviti ORDER BY ak.idaktiviti DESC";
$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
# Dapatkan jumlah bilangan aktiviti
$total = mysqli_num_rows($result);
# Counter untuk nombor bilangan di table
$counter = 1;
if($total > 0){
 echo "Jumlah: $total<br><table class='table-data' align='center' border='1' cellspacing='0'>
    <tr>
     <th width='20'>No.</th><th>Aktiviti</th><th width='200'>Gambar</th><th align='center' width='100'>Tindakan</th>
    </tr>";
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $idaktiviti = $row['idaktiviti'];
    $jenisaktiviti = $row['jenisaktiviti'];
    $imej = $row['imej'];
    $lokasi = $row['lokasi'];
    $nama = $row['nama'];
    $jumlahpeserta = $row['jumlahpeserta'];
    $masa = date("j M Y, g:i A", strtotime($row['masa']));

    if(!semakmasa($masa)){ 
      $masa = $masa." (Tamat)";
    }
    if(!empty($imej)){
      $img = "<img src='imej/$imej' width='100%'>";
    }else{
      $img = "Tiada gambar.";
    }
    echo "<tr>
      <td>$counter</td>
      <td><b>$jenisaktiviti</b> <br><br>
      Masa: $masa <br>
      Lokasi: $lokasi <br>
      Guru: $nama <br><br>
      Penyertaan: $jumlahpeserta ahli
      </td>
      <td>$img</td>
      <td align='center'>
        <a href='urus_kehadiran.php?idaktiviti=$idaktiviti'>Rekod Kehadiran</a> <br><br> 
        <a href='urus_borang_aktiviti.php?idaktiviti=$idaktiviti'>Edit</a> <br>
        <a href='javascript:void(0);' onclick='deletethis($idaktiviti)' >Buang</a>
      </td>
    </tr>";
    $counter = $counter + 1;
   } 
   echo "</table>";
 }else{
   echo "Belum ada data.";
 }
 ?> 
 <script>
 function deletethis(val) {
 if (confirm("Anda pasti?") == true) { 
  window.location.replace('urus_senarai_aktiviti.php?delete='+val);
 }
 }
 </script>
 <?php include('inc_footer.php'); ?>

 