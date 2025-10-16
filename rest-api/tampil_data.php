<?php
require_once("config/koneksi.php");
 
//mencari data ID tertentu
if(isset($_GET['id'])) {
    $id=$_GET['id'];
    $query="SELECT * FROM tb_pengurus WHERE id='$id'";
    $result=mysqli_query($con,$query);
    $row=mysqli_fetch_assoc($result);
 
    $data=array(
        'id'=>$row['id'],
        'nama'=>$row['nama'],
        'alamat'=>$row['alamat'],
        'gender'=>$row['gender'],
        'gaji'=>$row['gaji']
    );
 
    $hasil[]=$data;
 
    echo json_encode($hasil);
 
} else {
 
    //menampilkan semua data
    $query="SELECT * FROM tb_pengurus";
    $result=mysqli_query($con,$query);
    $row=mysqli_fetch_assoc($result);
 
    do {
        $hasil[]=$row;
    } while($row=mysqli_fetch_assoc($result));
 
    echo json_encode($hasil);   
}
 
?>