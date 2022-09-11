<?php

// Connect to database
$conn = mysqli_connect("localhost", "root", "password", "mahasiswa");

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function select($query)
{
  // ambil data dari tabel 
  global $conn;

  $result = mysqli_query($conn, $query);
  $rows = [];

  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

function add($nama, $nim, $email, $jurusan, $gambar)
{
  global $conn;

  $query = "INSERT INTO mahasiswa (nama, nim, email, gambar, jurusan)
  VALUES ('$nama', '$nim', '$email', '$gambar', '$jurusan')";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function hapus($id)
{
  global $conn;

  $query = "DELETE FROM mahasiswa WHERE id='$id'";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function ubah($id, $nama, $nim, $email, $jurusan, $gambar)
{
  global $conn;

  $query = "UPDATE mahasiswa SET nama='$nama', nim='$nim', email='$email', gambar='$gambar', jurusan='$jurusan' WHERE id=$id;";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function cari($val)
{
  $query = "SELECT * FROM mahasiswa WHERE 
          nama LIKE '%$val%' OR
          nim LIKE '%$val%' OR
          email LIKE '%$val%' OR
          gambar LIKE '%$val%' OR
          jurusan LIKE '%$val%'
          ";
  return select($query);
}

function upload($namaFile, $ukuranFile, $error, $tmpName)
{

  // cek apakah yang diupload adalah gambar
  $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
  $ekstensiGambar = explode('.', $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));

  if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "
              <script type=\"text/javascript\">
                alert('File yang dimasukkan bukanlah gambar!');
              </script>
          ";
    return false;
  }

  // cek apakah ukuran gambar melewati ketentuan
  if ($ukuranFile > 10000000) {
    echo "
              <script type=\"text/javascript\">
                alert('Ukuran gambar terlalu besar!');
              </script>
          ";
    return false;
  }

  $temp = explode(".", $namaFile);
  $newfilename = round(microtime(true)) . '.' . end($temp);
  move_uploaded_file($tmpName, 'img/upload/' . $newfilename);

  return $newfilename;
}

function registrasi($data)
{
  global $conn;

  $username = strtolower(test_input($data["username"]));
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $repassword = mysqli_real_escape_string($conn, $data["repassword"]);

  // cek username sudah ada
  $checker = mysqli_query($conn, "SELECT username FROM users WHERE username='$username';");

  if (mysqli_fetch_assoc($checker)) {
    echo "
            <script type=\"text/javascript\">
              alert('Username tersebut sudah ada, silahkan login');
            </script>
        ";
    return false;
  }

  // cek konfirmasi password
  if ($password !== $repassword) {
    echo "
            <script type=\"text/javascript\">
              alert('Password tidak sesuai');
            </script>
        ";
    return false;
  }

  // ekripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // adding user to database
  $query = "INSERT INTO users (username, password)
  VALUES ('$username', '$password');";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}
