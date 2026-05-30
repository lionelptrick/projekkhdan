<?php include('inc_settings.php');
semaklevel('admin');

$refresh = "";
if(isset($_GET['idaktiviti'])){
    $idaktiviti = $_GET['idaktiviti'];
}else{
    echo "<script> alert('ID aktiviti diperlukan.');
        window.location.replace('urus_senarai_aktiviti.php'); </script>"; die();
}
if(isset($_POST['nokadpengenalan'])){
    $nokadpengenalan = $_POST['nokadpengenalan'];
    $mesej = "";
    $sql = "SELECT * FROM hadir WHERE idaktiviti = $idaktiviti AND nokadpengenalan = '$nokadpengenalan' LIMIT 1";
    $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));

    if(mysqli_num_rows($result) > 0){   
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $idhadir = $row['idhadir'];

    if($row['status'] == 'hadir'){
        $mesej ="Kehadiran anda telah disahkan.";
    }else{
        $sql = "UPDATE hadir SET status = 'hadir' WHERE idhadir = $idhadir";
        $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
        $mesej ="Selamat Datang. Kehadiran anda berjaya disahkan.";
    }
}else{
    $mesej ="Rekod pendaftaran anda tidak ditemui.";
}
 $refresh = '<meta http-equiv="refresh" content="3">';
}
$sql = "SELECT * FROM aktiviti WHERE idaktiviti = $idaktiviti LIMIT 1";
$result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $tajuk = $row['tajuk'];
    $masa = date("j M Y, g:i A", strtotime($row['masa']));
    $imej = $row['imej'];
    if(!empty($imej)){
        $img = "<img class='imej' src='imej/$imej' height='200'>";
    }else{
        $img = "";
    }
}else{
    echo "<script> alert('Aktiviti tidak ditemui.');
        window.location.replace('urus_senarai_aktiviti.php'); </script>"; die();
} ?>
<html>
<head>
<title>Portal KDH-AN: Self Check-In Kiosk</title>
 <link rel='stylesheet' href='style.css'> <?php echo $refresh; ?>
</head>
<body background="imej/bg_kiosk.jpg" style="background-repeat: no-repeat; background-size: 100% 100%;">
<div align='center'>
    <h1 style='font-size:50px; color: #000'>Self Check-In Kiosk</h1>
<hr>
<?php echo $img; ?>
<p> 
<b class='fancy' style='font-size:50px; color: #000'><?php echo $tajuk; ?></b><br>
Masa Mula: <?php echo $masa; ?>
</p>
<hr>
<p>Isikan ID anda untuk Check In</p>
    <form method='POST' action=''>
    <input type='text' name='nokadpengenalan' value='' placeholder='No. Kad Pengenalan Ahli'  autofocus autocomplete="off"> <br><br>
    <input type='submit' name='submit' value='Check In'>
</form>

<?php if(!empty($mesej)){
    echo "<h1 style='font-size:20px; color: green'>$mesej</h1>";
} ?>
</div>
</body>
</html> 