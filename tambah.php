<?php

require 'function.php';

if (isset($_POST["submit"])) {

  global $conn;

  $nama = test_input($_POST["nama"]);
  $nim = test_input($_POST["nim"]);
  $email = test_input($_POST["email"]);
  $jurusan = test_input($_POST["jurusan"]);

  $namaFile = $_FILES['gambar']['name'];
  $ukuranFile = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmpName = $_FILES['gambar']['tmp_name'];

  // cek apakah tidak ada gambar yang diupload
  if ($error === 4) {
    echo "
              <script type=\"text/javascript\">
                alert('Tidak ada file yang diupload!');
              </script>
          ";
    return false;
  }

  $gambar = upload($namaFile,  $ukuranFile, $error, $tmpName);

  if ($gambar) {
    $nameChecker = select("SELECT nama
          FROM mahasiswa
          WHERE nama = '$nama' OR nim = '$nim' OR email = '$email' OR jurusan = '$jurusan';");

    if ($nameChecker) {
      echo "
            <script type=\"text/javascript\">
              alert('Maaf, mahasiwa tersebut sudah terdaftar di database');
            </script>
        ";
    } else {
      if (add($nama, $nim, $email, $jurusan, $gambar) > 0) {
        echo "
              <script type=\"text/javascript\">
                alert('Data berhasil ditambahkan');
                window.location = 'index.php';
              </script>
          ";
        // header('Location: index.php');
      } else {
        echo "
              <script type=\"text/javascript\">
                alert('Data gagal ditambahkan');
              </script>
          ";
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Data</title>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    <?php include 'style.css'; ?>
  </style>

</head>

<body>
  <div class="container">
    <div class="header">
      <h1>Tambah Data</h1>
      <hr>
    </div>

    <div class="form">
      <form method="post" action="" enctype="multipart/form-data">
        <ul>
          <li>
            <label for="nama">Nama</label>
            <input type="text" name="nama" placeholder="Masukkan Nama..." required>
          </li>
          <li>
            <label for="nim">NIM</label>
            <input type="text" name="nim" placeholder="Masukkan NIM..." required>
          </li>
          <li>
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Masukkan Email..." required>
          </li>
          <li>
            <label for="jurusan">Jurusan</label>
            <input type="text" name="jurusan" placeholder="Masukkan Jurusan..." required>
          </li>
          <li>
            <label for="gambar">Gambar</label>
            <input type="file" name="gambar" id="gambar" required>
          </li>
          <button type="submit" name="submit" id="kirim">Kirim</button>
        </ul>
      </form>

      <a href="index.php" class="kembali">Kembali</a>
    </div>
  </div>
</body>

</html>