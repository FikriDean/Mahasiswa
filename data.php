<?php

require 'function.php';

$keyword = $_GET["keyword"];

$data = cari($keyword);

?>

<div class="row" id="head">
  <div class="nomor column">
    <h3>No</h3>
  </div>
  <div class="aksi column">
    <h3>Aksi</h3>
  </div>
  <div class="gambar column">
    <h3>Gambar</h3>
  </div>
  <div class="nim column">
    <h3>NIM</h3>
  </div>
  <div class="nama column">
    <h3>Nama</h3>
  </div>
  <div class="email column">
    <h3>Email</h3>
  </div>
  <div class="jurusan column">
    <h3>Jurusan</h3>
  </div>
</div>

<?php $num = 1 ?>
<?php foreach ($data as $row) :  ?>
  <div class="row">
    <div class="nomor column">
      <h3><?= $num ?></h3>
    </div>
    <div class="aksi column">
      <a href="ubah.php?id=<?php echo $row["id"] ?>"><button>Ubah</button></a>
      <a href="hapus.php?id=<?php echo $row["id"] ?>" onclick="return confirm('yakin?')"><button>Hapus</button></a>
    </div>
    <div class="gambar">
      <img src="./img/upload/<?php echo $row["gambar"] ?>" alt="gambar-profile">
    </div>
    <div class="nrp column">
      <h3><?php echo $row["nim"] ?></h3>
    </div>
    <div class="nama column">
      <h3><?php echo $row["nama"] ?></h3>
    </div>
    <div class="email column">
      <h3><?php echo $row["email"] ?></h3>
    </div>
    <div class="jurusan column">
      <h3><?php echo $row["jurusan"] ?></h3>
    </div>
  </div>
  <?php $num += 1 ?>
<?php endforeach; ?>