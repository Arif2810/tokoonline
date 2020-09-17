<?php
session_start();

// Menghancurkan session pelanggan
session_destroy();

echo "<script>alert('Anda telah logout!');</script>";
echo "<script>location='index.php';</script>";