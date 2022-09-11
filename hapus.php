<?php

require 'function.php';

$id = $_GET['id'];

if (hapus($id) > 0) {
  echo "
          <script type=\"text/javascript\">
            alert('Data berhasil dihapus');
          </script>
         
      ";
} else {
  echo "
        <script type=\"text/javascript\">
          alert('Data gagal dihapus');
        </script>
      ";
}

header('Location: index.php');
