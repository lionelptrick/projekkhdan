<?php include('inc_header.php');
semaklevel('admin');

# Mode borang, 0 Tambah, 1 Edit.
$edit_data = 0;
# Nilai awal pembolehubah untuk 'value' borang.
$name = "";
# Semak jika ada parameter 'id' di URL.
if(isset($_GET['id'])){

 $id = (int)$_GET['id'];
 $sql = "SELECT * FROM kelas WHERE idkelas = $id LIMIT 1";
 $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));

# Jika kelas ada dalam pangkalan data, set nilai $edit_data
 if(mysqli_num_rows($result) > 0){
# Nilai $edit_data bukan lagi 0, bermakna mode borang akan digunakan untuk edit
  $edit_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $name = $edit_data['namakelas'];
 }else{
  echo "<script>alert('ID tidak ditemui.');</script>";
 }
}
# Semak nilai POST daripada borang
if(isset($_POST['name']) && !empty($_POST['name'])){

 $name = mysqli_real_escape_string($db, $_POST['name']);
 if($edit_data){
  # Jika mode edit, laksana UPDATE rekod sedia ada
  $sql = "UPDATE IGNORE kelas SET namakelas ='$name' WHERE 
idkelas =$id";
 }else{
# Jika bukan mode edit, laksana INSERT rekod baru
  $sql = "INSERT IGNORE INTO kelas (namakelas) VALUES ('$name')";
 }

 $result = mysqli_query($db, $sql) OR die("<pre>$sql</pre>" . mysqli_error($db));
 echo "<script> alert('Berjaya disimpan.');
  window.location.replace('urus_senarai_kelas.php'); 
</script>";
}
?>
<form method="POST" action="">
<p>
 <label for='name'>Nama <?php echo $label_kelas; ?></label><br>
 <input type='text' name='name' id='name' value='<?php echo $name; ?>'><br>
</p>
<p> <input type="submit" value="Simpan"></p>
</form>
<hr>
<?php include('inc_footer.php'); ?>