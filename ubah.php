<?php
require 'function.php';

session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}


if (!$_GET['id']) {
  header('Location: index.php');
}

$id = $_GET['id'];

$checkerCount = false;

$checker = select("SELECT * FROM mahasiswa");

foreach ($checker as $row) {
  if ($row["id"] === $id) {
    $checkerCount = true;
  }
}

if (!$checkerCount) {
  header('Location: index.php');
}

$data = select("SELECT * FROM mahasiswa WHERE id = $id");


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
    $gambar = $data[0]["gambar"];
  } else {
    $gambar = upload($namaFile,  $ukuranFile, $error, $tmpName);
  }

  if ($gambar) {
    if (ubah($id, $nama, $nim, $email, $jurusan, $gambar) > 0) {
      echo "
              <script type=\"text/javascript\">
                alert('Data berhasil diubah');
                window.location = 'index.php';
              </script>
          ";
    } else {
      echo "
              <script type=\"text/javascript\">
                alert('Tidak ada data yang diubah');
              </script>
          ";
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

  <!-- icon -->
  <!-- Favicon (Web Icon) -->
  <link rel="icon" href="./img/favicon.ico" type="image/ico">

  <!-- jQuery -->
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    <?php include 'style.css'; ?>
  </style>
  <title>Change Data</title>
</head>

<body>

  <div class="container">
    <div class="header">
      <h1>Ubah Data</h1>
      <hr>
    </div>

    <div class="form">
      <form method="post" action="" enctype="multipart/form-data">
        <ul>
          <li>
            <label for="nama">Nama</label>
            <input type="text" name="nama" placeholder="Masukkan Nama..." required value="<?= $data[0]["nama"] ?>">
          </li>
          <li>
            <label for="nim">NIM</label>
            <input type="text" name="nim" placeholder="Masukkan NIM..." required value="<?= $data[0]["nim"] ?>">
          </li>
          <li>
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Masukkan Email..." required value="<?= $data[0]["email"] ?>">
          </li>
          <li>
            <label for="jurusan">Jurusan</label>
            <input type="text" name="jurusan" placeholder="Masukkan Jurusan..." required value="<?= $data[0]["jurusan"] ?>">
          </li>
          <li>
            <label for="gambar">Gambar</label>
            <img src="./img/upload/<?= $data[0]["gambar"] ?>" alt="Gambar Profile" class="img-change">
            <input type="file" name="gambar">
          </li>
          <button type="submit" name="submit" id="kirim">Ubah</button>
        </ul>
      </form>

      <a href="index.php" class="kembali">Kembali</a>
    </div>
  </div>

</body>

</html>