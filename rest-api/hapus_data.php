<?php
require_once("config/koneksi.php");
 
$id=$_GET['id'];
$query="DELETE FROM tb_pengurus WHERE id='$id'";
$result=mysqli_query($con,$query);
 
$respon=array( //digunakan untuk pesan
        'response' => 200,
        'pesan' => 'Data berhasil Dihapus'
);
 
echo json_encode($respon);
?>