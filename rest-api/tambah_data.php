<?php
require_once("config/koneksi.php");
 
$id=$_POST['id'];
$nama=$_POST['nama'];
$alamat=$_POST['alamat'];
$gender=$_POST['gender'];
$gaji=$_POST['gaji'];
 
$query="INSERT INTO tb_pengurus VALUES ('$id','$nama','$alamat','$gender','$gaji')";
$result=mysqli_query($con,$query);
 
$respon=array( //digunakan untuk pesan
        'response' => 200,
        'pesan' => 'Data berhasil Masuk'
);
 
echo json_encode($respon);
?>