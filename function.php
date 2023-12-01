<?php
require __DIR__ . '/vendor/autoload.php';
session_start();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


//Membuat koneksi ke data base
$conn = mysqli_connect("localhost","root","","db_stockbarang");


//Menambah barang baru
if (isset($_POST['addnewbarang'])) {
    $nama_barang = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $total_harga = $stock * $harga;

    $addtotable = mysqli_query($conn, "INSERT INTO stock (nama_barang, deskripsi, stock, harga, total_harga) VALUES ('$nama_barang', '$deskripsi', '$stock', '$harga', '$total_harga')");
    if ($addtotable) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}


// Menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE id_barang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtotable = mysqli_query($conn, "INSERT INTO masuk (id_barang, keterangan, qty) VALUES ('$barangnya','$penerima','$qty')");
    
    // Update stock and total_harga in the stock table
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity', total_harga = stock * harga WHERE id_barang='$barangnya'");

    if($addtotable && $updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}


// Menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE id_barang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

    $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (id_barang, penerima, qty) VALUES ('$barangnya','$penerima','$qty')");
    
    // Update stock and total_harga in the stock table
    $updatestockkeluar = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity', total_harga = stock * harga WHERE id_barang='$barangnya'");

    if($addtokeluar && $updatestockkeluar){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}



//Update info barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $nama_barang = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];
    $total_harga = $stock * $harga;

    $update= mysqli_query($conn,"update stock set nama_barang='$nama_barang', deskripsi='$deskripsi',stock='$stock', harga='$harga', total_harga='$total_harga' where id_barang ='$idb'");
    if($update){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header ('location:index.php');
    }
}


//Menghapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stock where id_barang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};



// Mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock where id_barang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "select * from masuk where id_masuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if($qty > $qtyskrng){
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockskrng + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin', total_harga = stock * harga WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where id_masuk='$idm'");
        if($kurangistocknya && $updatenya){
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin', total_harga = stock * harga WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where id_masuk='$idm'");
        if($kurangistocknya && $updatenya){
            header('location:masuk.php');
        } else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    }
}




// Menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from stock where id_barang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok - $qty;

    // Perbarui total harga di tabel stock saat menghapus barang masuk
    $update = mysqli_query($conn,"update stock set stock='$selisih', total_harga = stock * harga WHERE id_barang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where id_masuk='$idm'");

    if($update && $hapusdata){
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}



// Mengubah data barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima']; // Perbarui variabel ke 'penerima'
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock where id_barang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "select * from keluar where id_keluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if($qty > $qtyskrng){
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockskrng - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin', total_harga = stock * harga WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where id_keluar='$idk'");
        if($kurangistocknya && $updatenya){
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockskrng + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin', total_harga = stock * harga WHERE id_barang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where id_keluar='$idk'");
        if($kurangistocknya && $updatenya){
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    }
}







// Menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"select * from stock where id_barang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok + $qty;

    // Perbarui total harga di tabel stock saat menghapus barang masuk
    $update = mysqli_query($conn,"update stock set stock='$selisih', total_harga = stock * harga WHERE id_barang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where id_masuk='$idm'");

    if($update && $hapusdata){
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}

function fetchDataFromDatabase()
{
    global $conn; // Use the global connection variable

    $result = mysqli_query($conn, "SELECT * FROM stock");
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}


function exportToExcel()
{
    global $conn;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $data = fetchDataFromDatabase();

    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama Barang');
    $sheet->setCellValue('C1', 'Deskripsi');
    $sheet->setCellValue('D1', 'Stock');
    $sheet->setCellValue('E1', 'Harga');
    $sheet->setCellValue('F1', 'Total Harga');

    $row = 2;
    $no = 1;

    foreach ($data as $item) {
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $item['nama_barang']);
        $sheet->setCellValue('C' . $row, $item['deskripsi']);
        $sheet->setCellValue('D' . $row, $item['stock']);
        $sheet->setCellValue('E' . $row, $item['harga']);
        $sheet->setCellValue('F' . $row, $item['total_harga']);

        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'export_data.xlsx';

    // Save the file to a temporary location
    $tempFile = tempnam(sys_get_temp_dir(), 'excel');
    $writer->save($tempFile);

    // Set appropriate headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Read the file and send it to the browser
    readfile($tempFile);
    unlink($tempFile); // Remove the temporary file

    exit;
}

function exportToPDF()
{
    global $conn;

    require_once __DIR__ . '/vendor/autoload.php';

    $data = fetchDataFromDatabase();

    $html = '<table border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Deskripsi</th>
                        <th>Stock</th>
                        <th>Harga</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>';

    $no = 1;
    foreach ($data as $item) {
        $html .= '<tr>
                    <td>' . $no++ . '</td>
                    <td>' . $item['nama_barang'] . '</td>
                    <td>' . $item['deskripsi'] . '</td>
                    <td>' . $item['stock'] . '</td>
                    <td>' . $item['harga'] . '</td>
                    <td>' . $item['total_harga'] . '</td>
                </tr>';
    }

    $html .= '</tbody></table>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);

    $filename = 'export_data.pdf';
    $mpdf->Output($filename, 'D'); // 'D' means force download

    exit;
}

