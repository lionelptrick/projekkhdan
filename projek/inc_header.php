<?php include('inc_settings.php'); ?>
<html>
<head>
 <title>Portal KHD-AN: Sistem Rekod Kehadiran</title>
 <link rel='stylesheet' href='style.css'>
 <!-- style khas untuk kawal saiz teks pilihan ahli -->
 <style> * { font-size: <?php echo $fontsize; ?>%; } </style>
</head>
<body background="imej/bg kl night.jpg">
<table width='900' align='center' style='height: 100%; border: 1px dotted black; box-shadow: 0 0 55px 15px #121c2d;'
cellpadding='10' cellspacing='0' border='0' bgcolor="#121c2d">
<tr background='imej/Kelab.png'>
 <td align='right' valign='middle' colspan='2' style='height: 200px;'>
  <h1 style='font-size:40px; color: #000'
</tr
><tr>
<td align='center' valign='top' colspan='2' style="height:40px">
<div class="hmenu"> <ul>
  <li><a class='mainmenu' href='index.php'>Laman Utama</a></li>
  <li><a class='mainmenu' href='senarai_aktiviti.php'>Semua Aktiviti</a></li>
<?php
if($level == 'user'){
  echo "<li><a class='mainmenu' href='profil_ahli.php'>Profil Saya</a></li>";
}
if($level == 'admin'){
  echo "<li><a class='mainmenu' href='#'>Menu Admin</a><ul>
  <li><a class='mainmenu' href='urus_senarai_aktiviti.php'>Urus Aktiviti</a></li>
  <li><a class='mainmenu' href='urus_senarai_kelas.php'>Urus 
$label_kelas</a></li>
  <li><a class='mainmenu' href='urus_senarai_ahli.php'>Urus Ahli</a></li>
  <li><a class='mainmenu' href='urus_import.php'>Import Data</a></li>
  </ul></li>";
}
if($level == 'visitor'){
  echo "
  <li><a class='mainmenu' href='login.php' style='background: #ab8340;'>Log Masuk</a></li>
  <li><a class='mainmenu' href='signup.php' style='background: #ab8340;'>Daftar</a></li>";
}else{
 echo "
 <li><a class='mainmenu' href='logout.php' style='background: #ab8340;'>Log Keluar</a></li>";
 }
 ?>
 </ul></div></td></tr><tr>
 <td valign='top' align='center' colspan='2' style="height:40px">
 <?php
  if($level != 'visitor'){
  $nama = $_SESSION['nama'];
  echo "<p style='font-size:16px;'>Hi, $nama ($level)<p>";
  } 
?>
</td></tr><tr>
<td colspan='2' valign='top' id='printcontent'>