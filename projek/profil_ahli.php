<?php include('inc_header.php');
semaklevel('user-admin');

# Dapatkan id user daripada session
if($level == 'user'){
    $nokadpengenalan = $_SESSION['nokadpengenalan'];

}elseif(isset($_GET['nokadpengenalan'])){
 $nokadpengenalan = $_GET['nokadpengenalan'];

}else{
  echo "<script>alert('Parameter tidak lengkap untuk $level.');
  window.location.replace('urus_senarai_ahli.php');</script>";
}

$sql = "SELECT * FROM ahli
        LEFT JOIN kelas on kelas.idkelas=ahli .idkelas
    WHERE nokadpengenalan='$nokadpengenalan' LIMIT 1";

$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
# Jika aktiviti ditemui, paparkan maklumat aktiviti
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $nokadpengenalan = $row['nokadpengenalan'];
    $namaahli = $row['nama'];
    $group = $row['namakelas'];

    echo "<div style='float:right; width:170px; height:170px;'>
    <b>Check In QR Code</b>
    <img src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$nokadpengenalan'
    class='imej' alt='QR Code' width='160'> </div>
    <h1 style='font-size:30px'>Profil Ahli</h1>
    <p>Nama: $namaahli <br> $label_kelas: $group</p> <p> No. Kad Pengenalan: $nokadpengenalan <br> ";

}else{
 echo "Maklumat ahli tidak ditemui."; die();
}
echo "<h2>Senarai Aktiviti Yang Disertai:</h2>";

# Dapatkan senarai penyertaan ahli
$sql = "SELECT * FROM hadir h LEFT JOIN aktiviti a on a.idaktiviti = h.idaktiviti
WHERE h.nokadpengenalan = '$nokadpengenalan' ";

$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));

# Jika aktiviti ditemui, paparkan maklumat aktiviti
$total = mysqli_num_rows($result);
if($total > 0){
 echo "Jumlah Penyertaan: $total<br>";
 echo "* $label_mata hanya dikira untuk kehadiran yang disahkan.<br><br>";
 echo "<table class='table-data' border='1' cellspacing='0'>
   <tr>
    <th width='20'>No.</th>
    <th>Aktiviti</th>
    <th width='200'>Masa</th>
    <th width='60'>$label_mata</th>
   </tr>";

 $counter = 1;
 $jumlahmata = 0;
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $idaktiviti = $row['idaktiviti'];
  $jenisaktiviti = $row['jenisaktiviti'];
  $status = $row['status'];
  $masa = date("j M Y, g:i A", strtotime($row['masa']));

  if($status == 'hadir'){
   $mata = $row['mata'];
   $jumlahmata = $jumlahmata + $mata;
  }else{
   $mata = '-';
  }
  echo "<tr>
    <td>$counter</td>
    <td><a href='papar_aktiviti.php?id=$idaktiviti'>$jenisaktiviti</a></td>
    <td>$masa</td>
    <td align='center'>$mata</td>
   </tr>";
  $counter = $counter + 1;
 }
 echo "<tr>
    <td colspan='3' align='right'>
    <b>Jumlah $label_mata</b>: </td>
    <td align='center'>$jumlahmata</td>
   </tr>
 </table>";
}else{
  echo "Belum ada aktiviti yang disertai.";
}
?>
<script>
// kod skrip fungsi tanya pengesahan
function deletethis(val) {
if (confirm("Anda pasti?") == true) {
 window.location.replace('urus_senarai_aktiviti.php?delete='+val);
}
} 
</script>
<?php include('inc_footer.php'); ?>

