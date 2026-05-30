<?php
# Maklumat pangkalan data
$dbname = 'projekkhdan_db';
$dbuser = 'root';
$dbpass = '';
$dbhost = 'localhost';
# Buka sambungan ke pengkalan data
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)
 OR die(mysqli_connect_error());

# Label kelas, contoh : 3 Gigih, 4 Amanah, 4 Bakti, 5 Hawking
$label_kelas = 'Kelas';

# Label untuk Reward kehadiran, contoh : Point, Mata, Star, Coin
$label_mata = 'Mata';

# Session dimulakan
session_start();
# Session untuk simpan dan baca saiz teks
if(isset($_SESSION['fontsize'])){
  $fontsize = $_SESSION['fontsize'];
}else{
  $fontsize = 100;
}
if(isset($_GET['font'])){
  if($_GET['font'] == 'plus'){
   $fontsize += 1;
  }elseif($_GET['font'] == 'minus'){
   $fontsize -= 1;
  }else{
   $fontsize = 100;
  }
   $_SESSION['fontsize'] = $fontsize;
}
# Session tahap ahli, untuk tentukan akses halaman
if(!isset($_SESSION['nokadpengenalan'])){
  $_SESSION['level'] = 'visitor';
}
$level = $_SESSION['level'];

# FUNCTION : Semak jika masa sudah lepas
function semakmasa($masa){
 if(strtotime('now') < strtotime($masa)){
   return true;
 }else{
  return false;
 }
}

# FUNCTION : Semak tahap ahli dan tahap kebenaran akses
function semaklevel($akses){
 $level = $_SESSION['level'];
 $error = '';

 if($level == 'visitor'){
    $error = 'Anda perlu log masuk untuk akses halaman ini.';
 }elseif($level == 'user' && $akses == 'admin'){
    $error = 'Hanya akaun Guru boleh mengakses halaman ini.';
 }elseif($level == 'admin' && $akses == 'user'){
    $error = 'Hanya akaun Ahli biasa boleh mengakses halaman ini.';
 }


if(!empty($error)){
  echo "<script> alert('$error');
   window.location.replace('index.php'); </script>";
  die();
 }
}
?> 