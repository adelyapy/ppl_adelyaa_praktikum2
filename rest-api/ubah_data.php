<?php
require_once("config/koneksi.php");
 
$id=$_POST['id'];
$nama=$_POST['nama'];
$alamat=$_POST['alamat'];
$gender=$_POST['gender'];
$gaji=$_POST['gaji'];
 
$query="UPDATE tb_pengurus SET nama='$nama', alamat='$alamat', gender='$gender', gaji='$gaji' WHERE id = '$id'";
$result=mysqli_query($con,$query);
 
$respon=array( //digunakan untuk pesan
        'response' => 200,
        'pesan' => 'Data berhasil Diubah'
);
 
echo json_encode($respon);
?>