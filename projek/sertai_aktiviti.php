<?php include('inc_header.php');
semaklevel('user');

if(isset($_GET['id']) && isset($_GET['action'])){

   $idaktiviti = $_GET['id'];
   $action = $_GET['action'];
   $nokadpengenalan = $_SESSION['nokadpengenalan'];

   if($action == 'add'){

    $sql = "INSERT IGNORE INTO hadir (nokadpengenalan, idaktiviti) VALUES ('$nokadpengenalan', '$idaktiviti')";

    $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
    echo "<script> alert('Anda berjaya mendaftar untuk aktiviti ini.'); </script>";

   }elseif($action == 'remove'){

     $sql = "DELETE FROM hadir WHERE nokadpengenalan = $nokadpengenalan AND idaktiviti = $idaktiviti";
     $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
     echo "<script> alert('Aktiviti telah dikeluarkan daripada rekod.'); </script>";
   }
}else{
 echo "<script> alert('Parameter GET tidak lengkap.'); </script>";
}
echo "<script>window.location.replace('profil_ahli.php');</script>";

include('inc_footer.php'); ?>