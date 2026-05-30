<?php include('inc_header.php');
semaklevel('admin');
if(isset($_GET['idaktiviti'])){
  $idaktiviti = $_GET['idaktiviti'];
}else{
   echo "<script> alert('ID aktiviti diperlukan.');
   window.location.replace('urus_senarai_aktiviti.php'); </script>"; die();
}
if(isset($_GET['action']) && isset($_GET['idhadir'])){
   $idhadir = $_GET['idhadir'];
   $action = $_GET['action'];
   if($action == 'hadir' || $action == 'tidakhadir'){
    $sql = "UPDATE hadir SET status = '$action' WHERE idhadir = $idhadir";
    $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
    echo "<script> alert('Status kehadiran berjaya dikemaskini.'); </script>";
   }elseif($action == 'delete'){
    $sql = "DELETE FROM hadir WHERE idhadir = $idhadir";
    $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
    echo "<script> alert('Pengguna berjaya dinyah-daftar daripada aktiviti.'); </script>";
   }
   echo "<script>window.location.replace('urus_kehadiran.php?idaktiviti=$idaktiviti');</script>";
} ?>
<h1 style="font-size:30px">Rekod Kehadiran Aktiviti</h1>
<?php $sql = "SELECT ak.*, g.* FROM aktiviti ak
  LEFT JOIN guru g on g.idguru = g.idguru WHERE idaktiviti = $idaktiviti LIMIT 1";
$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
if(mysqli_num_rows($result) > 0){
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $jenisaktiviti = $row['jenisaktiviti'];
  $detail = $row['detail'];
  $lokasi = $row['lokasi'];
  $mata = $row['mata'];
  $nama = $row['nama'];
  $masa = date("j M Y, g:i A", strtotime($row['masa']));
  $imej = $row['imej'];
  if(!empty($imej)){
    $img = "<img class='imej' src='imej/$imej' width='80%'>";
  }else{
    $img = "Tiada imej.";
  }
  echo "<table width='100%' align='center' border='0' cellspacing='0'><tr>
    <td width='200'>$img</td>
    <td valign='top'><h2 class='jenisaktiviti'>$jenisaktiviti</h2>Masa: $masa <br>Lokasi: $lokasi <br>Guru: $nama
    <br><br>
    <a class='button' href='urus_kiosk.php?idaktiviti=$idaktiviti' target='_blank'>Self Checkin Kiosk</a>
    <a class='button' href='javascript:void(0);' onclick='printcontent(&quot;printcontent&quot;)'>Cetak</a>
    </td>
    </tr></table>";
    echo "<h2>Senarai Peserta</h2>";
$sql = "SELECT h.*, ah.*, ak.* FROM hadir h
  LEFT JOIN ahli ah on ah.nokadpengenalan = h.nokadpengenalan
  LEFT JOIN aktiviti ak on ak.idaktiviti = h.idaktiviti
  WHERE h.idaktiviti = $idaktiviti ORDER BY idhadir DESC";
$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
$total = mysqli_num_rows($result);
 if($total > 0){
    echo "Jumlah: $total<br><table class='table-data' border='1' cellspacing='0'>
     <tr>
      <th width='20'>No.</th> <th>Nama</th>
      <th width='200'>Masa Mendaftar</th> <th width='100'>Kehadiran</td>
      <th width='200'>Tindakan</td>
    </tr>";
    $counter = 1;
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
     $idhadir = $row['idhadir'];
     $nokadpengenalan = $row['nokadpengenalan'];
     $namaahli = $row['nama'];
     $masa = date("j M Y, g:i A", strtotime($row['masa']));
     $status = $row['status'];
     if ($status == 'hadir') {
        $status_text = 'Hadir';
     } elseif ($status == 'tidakhadir') {
        $status_text = 'Tidak Hadir';
     } else {
        $status_text = 'Belum Disahkan';
     }
     echo "<tr>
      <td>$counter</td> <td>$namaahli ($nokadpengenalan)</td>
      <td>$masa</td> <td>$status_text</td>
      <td align='center'>
       <a href='?idaktiviti=$idaktiviti&idhadir=$idhadir&action=hadir'>Hadir</a> |
       <a href='?idaktiviti=$idaktiviti&idhadir=$idhadir&action=tidakhadir'>Tidak Hadir</a> |
       <a href='javascript:void(0);' onclick='deletethis($idhadir)' >Buang Pendaftaran</a>
      </td> </tr>";
    $counter = $counter + 1;
     }
     echo "</table>";
    }else{
     echo "Belum ada ahli yang mendaftar.";
    }
 }else{
     echo "Aktiviti tidak ditemui.";
 } ?>
 <script>
    function deletethis(val) {
     if (confirm("Anda pasti?") == true) {
      window.location.replace(window.location.href + '&action=delete&idhadir=' + val);
     }
  } 
  </script>
  <?php include('inc_footer.php'); ?>

  cetak