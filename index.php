<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum PHP</title>
</head>

<body class="a">
    <hi>belajar PHP belajar</hi>
    <?php
    echo "<p>PHP BERHASIL DIJALANKAN </p>";
    echo "<p> waktu server: " . date("d-m-y H:i:s") . "</p>";
    ?>

    <!-- latihan 2  -->
    <?php
    $nama = "Siti";
    $tugas = 85;
    $uts = 78;
    $uas = 90;
    $nilaiAkhir = ($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40);

    if ($nilaiAkhir >= 85) {
        $predikat = "A";
    } elseif ($nilaiAkhir >= 75) {
        $predikat = "B";
    } elseif ($nilaiAkhir >= 60) {
        $predikat = "C";
    } else {
        $predikat = "D";
    }
    echo "Nama: " . htmlspecialchars($nama) . "<br>";
    echo "Nilai akhir: " . number_format($nilaiAkhir, 2) . "<br>";
    echo "Predikat: " . $predikat;
    ?>

    <!-- latihan 3 -->
    <?php
    $mahasiswa = ["Alya", "Bima", "Citra", "Doni"];
    echo "<h3>Daftar Mahasiswa</h3><ol>";
    foreach ($mahasiswa as $nama) {
        echo "<li>" . htmlspecialchars($nama) . "</li>";
    }
    echo "</ol>";
    ?>

    <!-- latihan 4 -->
    <?php
    function hitungDiskon($harga, $persen)
    {
        $potongan = $harga * ($persen / 100);
        return $harga - $potongan;
    }

    function hitungLuasPersegiPanjang($panjang, $lebar)
    {
        return $panjang * $lebar;
    }

    function tentukanKelulusan($nilai)
    {
        return $nilai >= 60 ? "LULUS" : "TIDAK LULUS";
    }

    $hargaAkhir = hitungDiskon(150000, 10);
    echo "<p>Harga setelah diskon 10% dari Rp150.000: Rp" . number_format($hargaAkhir, 0, ",", ".") . "</p>";

    echo "<p>Luas persegi panjang 8 x 4 = " . hitungLuasPersegiPanjang(8, 4) . "</p>";

    foreach ([85, 60, 45] as $n) {
        echo "<p>Nilai $n: " . tentukanKelulusan($n) . "</p>";
    }
    ?>

    <!-- latihan 5 -->
    <!-- cari.php -->
    <form method="GET" action="">
        <label for="kata">Kata kunci:</label>
        <input id="kata" name="kata" type="text">
        <button type="submit">Cari</button>
    </form>
    <?php
    if (isset($_GET["kata"])) {
        $kata = trim($_GET["kata"]);
        echo "Kata kunci: " . htmlspecialchars($kata, ENT_QUOTES, "UTF-8");
    }
    ?>

    <!-- latihan 6 -->
    <!-- index.php -->
    <form method="POST" action="">
        <label for="nama">Nama:</label>
        <input id="nama" name="nama" type="text" required>
        <label for="prodi">Program Studi:</label>
        <input id="prodi" name="prodi" type="text" required>
        <button type="submit" name="kirim">Kirim Data</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nama = trim($_POST["nama"] ?? "");
        $prodi = trim($_POST["prodi"] ?? "");
        if ($nama === "" || $prodi === "") {
            echo "<p>Semua kolom wajib diisi.</p>";
        } else {
            echo "<h3>Data diterima</h3>";
            echo "Nama: " . htmlspecialchars($nama, ENT_QUOTES, "UTF-8") . "<br>";
            echo "Program Studi: " . htmlspecialchars($prodi, ENT_QUOTES, "UTF-8");
        }
    }
    ?>

    <!-- latihan 7 -->
    <?php
    $hasil = null;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $barang = trim($_POST["barang"] ?? "");
        $hargaInput = $_POST["harga"] ?? "";
        $jumlahInput = $_POST["jumlah"] ?? "";
        if (
            $barang === "" || !is_numeric($hargaInput) ||
            !ctype_digit((string) $jumlahInput) ||
            (float) $hargaInput < 0 || (int) $jumlahInput < 1
        ) {
            $error = "Periksa kembali nama barang, harga, dan jumlah.";
        } else {
            $harga = (float) $hargaInput;
            $jumlah = (int) $jumlahInput;
            $subtotal = $harga * $jumlah;
        }
    }
    ?>
    <form method="POST">
        <label>Nama barang <input name="barang" required></label>
        <label>Harga <input name="harga" type="number" min="0" step="0.01" required></label>
        <label>Jumlah <input name="jumlah" type="number" min="1" step="1" required></label>
        <button type="submit">Hitung</button>
    </form>
    <?php
    if (isset($error)) {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    } elseif (isset($subtotal)) {
        echo "<p>Barang: " . htmlspecialchars($barang) . "</p>";
        echo "<p>Subtotal: Rp" . number_format($subtotal, 0, ",", ".") . "</p>";
    }
    ?>

</body>

</html>