<?php
require 'function.php';
require 'cek.php';


if (isset($_POST['export_excel'])) {
    exportToExcel();
}

if (isset($_POST['export_pdf'])) {
    exportToPDF();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock Barang</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-dark">
            <a class="navbar-brand" href="index.php">GUDANG CEMARA K9</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Stock Barang</h1>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                        Tambah Barang
                                </button>
                                 <!-- Tambahkan tombol ekspor ke Excel dan PDF -->
                                <form method="post" style="display: inline-block;">
                                    <button type="submit" class="btn btn-success" name="export_excel">Export to Excel</button>
                                </form>
                                <form method="post" style="display: inline-block;">
                                    <button type="submit" class="btn btn-danger" name="export_pdf">Export to PDF</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Deskripsi</th>
                                                <th>Stock</th>
                                                <th>Harga</th>
                                                <th>Total Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php
                                            $ambilsemuadatastock = mysqli_query($conn,"select * from stock");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $nama_barang = $data['nama_barang'];
                                                $deskripsi = $data['deskripsi'];
                                                $stock = $data['stock'];
                                                $harga = $data['harga'];
                                                $tharga = $data['total_harga'];
                                                $idb = $data['id_barang'];

                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$nama_barang;?></td>
                                                <td><?=$deskripsi;?></td>
                                                <td><?=$stock;?></td>
                                                <td><?=$harga;?></td>
                                                <td><?=$tharga;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idb;?>">
                                                            Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idb;?>">
                                                            Delete
                                                    </button>
                                                </td>
                                            </tr>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="edit<?=$idb;?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                        <h4 class="modal-title">Edit Barang</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                            
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                        <div class="modal-body">
                                                        <input type="text" name="nama_barang" value="<?=$nama_barang;?>" class="form-control" required>
                                                        <br>
                                                        <input type="text" name="deskripsi" value="<?=$deskripsi;?>" class="form-control" required>
                                                        <br>
                                                        <input type="text" name="stock" class="form-control" placeholder="Stock" id="editStock<?=$idb;?>" required>
                                                        <br>    
                                                        <input type="text" name="harga" class="form-control" placeholder="Harga" id="editHarga<?=$idb;?>" required>
                                                        <br>
                                                        <input type="hidden" name="idb" value="<?=$idb;?>">
                                                        <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
                                                        </div>
                                                        </form>
                                                            
                                                    </div>
                                                    </div>
                                                </div>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="delete<?=$idb;?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                        <h4 class="modal-title">Hapus barang?</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                            
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                        <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus <?=$nama_barang;?>?
                                                        <input type="hidden" name="idb" value="<?=$idb;?>">
                                                        <br>  
                                                        <br>
                                                        <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                                                        </div>
                                                        </form>
                                                            
                                                    </div>
                                                    </div>
                                                </div>

                                                </div>







                                            <?php
                                            };
                                            
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; K9</div>
                           
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>

        <script>
    $(document).ready(function() {
        $('#edit<?=$idb;?>').on('show.bs.modal', function() {
            var stock = <?=$stock;?>;
            var harga = <?=$harga;?>; // Get the previous harga value
            $('#editStock<?=$idb;?>').val(stock);
            $('#editHarga<?=$idb;?>').val(harga); // Set the value in the input field
        });
    });
</script>
    </body>
    
        <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tambah Barang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form method="post">
            <div class="modal-body">
            <input type="text" name="nama_barang" placeholder="Nama Barang" class="form-control" required>
            <br>
            <input type="text" name="deskripsi" placeholder="Deskripsi barang" class="form-control" required>
            <br>
            <input type="number" name="stock" class="form-control" placeholder="Stock" required>
            <br>
            <input type="number" name="harga" class="form-control" placeholder="Harga" required>
            <br>
            <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
            </div>
            </form>
             
        </div>
        </div>
    </div>
</html>




