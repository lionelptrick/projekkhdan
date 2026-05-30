<?php include('inc_header.php');?>
 <h2> Portal KHD-AN: Sistem Rekod Kehadiran Ahli Rukun Negara  </h2> 
<hr> 
<img src='imej/banner logo.png' width='700' > 
<h2>Aktiviti Terkini:</h2>
<div class='row' style='text-align:center;'>
<?php
 # Dapatkan aktiviti terkini untuk dipaparkan
 $sql = "SELECT * FROM aktiviti
  ORDER BY idaktiviti DESC LIMIT 6";

 $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
 
 if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_array($result)){
    $idaktiviti = $row['idaktiviti'];
    $jenisaktiviti = $row['jenisaktiviti'];
    $imej = $row['imej'];
 
    if(!empty($imej)){
      $img = "<img class='imej' src='imej/$imej' height='100%' width='100%'>";
    }else{
      $img = "Tiada gambar.";
    }
                                      
    echo "<table class='column' width='20%' height='100%' border='0' cellspacing='0' cellpadding='4'>
     <tr><td align='center' height='50'><strong>$jenisaktiviti</strong></td></tr>
     <tr><td align='center' height='200'>$img</td></tr>
     <tr><td align='center'><a class='button' href='papar_aktiviti.php?id=$idaktiviti'>Lihat</a></td></tr>
     </table>";
    }
   }else{
    echo "Belum ada aktiviti dimasukkan.";
   }
  ?>
  </div>
  <hr>
  Lihat semua aktiviti <a href='senarai_aktiviti.php'>di sini.</a>
  <?php include('inc_footer.php'); ?>
