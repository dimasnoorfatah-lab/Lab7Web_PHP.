<?php
// Mini Project Praktikum 7: Formulir Data Mahasiswa
$data = null;
$error = [];

$nama = "";
$nim = "";
$prodi = "";
$semesterInput = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    $semesterInput = trim($_POST["semester"] ?? "");
    $email = trim($_POST["email"] ?? "");

    // Validasi server-side
    if ($nama === "") {
        $error[] = "Nama wajib diisi.";
    }

    if ($nim === "") {
        $error[] = "NIM wajib diisi.";
    } elseif (!ctype_digit($nim)) {
        $error[] = "NIM hanya boleh berisi angka.";
    }

    if ($prodi === "") {
        $error[] = "Program studi wajib diisi.";
    }

    if (!ctype_digit($semesterInput) || (int)$semesterInput < 1 || (int)$semesterInput > 14) {
        $error[] = "Semester harus berupa bilangan bulat dari 1 sampai 14.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Format email tidak valid.";
    }

    if (empty($error)) {
        $data = [
            "nama" => $nama,
            "nim" => $nim,
            "prodi" => $prodi,
            "semester" => (int)$semesterInput,
            "email" => $email
        ];
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Data Mahasiswa</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; padding: 32px 16px;
            font-family: Arial, sans-serif;
            background: #f1f5f9; color: #172033;
        }
        .container {
            max-width: 760px; margin: auto;
            background: white; padding: 28px;
            border-radius: 16px; box-shadow: 0 10px 30px #0f172a12;
        }
        h1 { margin-top: 0; color: #174ea6; }
        .intro { color: #64748b; margin-bottom: 24px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .field { display: flex; flex-direction: column; gap: 7px; }
        .field.full { grid-column: 1 / -1; }
        label { font-weight: 700; font-size: 14px; }
        input, select {
            width: 100%; padding: 12px; border: 1px solid #cbd5e1;
            border-radius: 8px; font-size: 15px; background: white;
        }
        input:focus, select:focus { outline: 2px solid #bfdbfe; border-color: #2563eb; }
        .actions { display: flex; gap: 10px; margin-top: 20px; }
        button, .reset {
            border: 0; border-radius: 8px; padding: 12px 18px;
            font-weight: 700; font-size: 14px; cursor: pointer; text-decoration: none;
        }
        button { color: white; background: #2563eb; }
        .reset { color: #334155; background: #e2e8f0; }
        .error {
            background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
            padding: 14px 18px; border-radius: 10px; margin-bottom: 20px;
        }
        .result {
            margin-top: 24px; border: 1px solid #bbf7d0; background: #f0fdf4;
            padding: 20px; border-radius: 12px;
        }
        .result h2 { margin-top: 0; color: #166534; }
        .result table { width: 100%; border-collapse: collapse; }
        .result td { padding: 10px 6px; border-bottom: 1px solid #dcfce7; vertical-align: top; }
        .result td:first-child { font-weight: 700; width: 34%; }
        .footer { margin-top: 24px; font-size: 12px; color: #64748b; text-align: center; }
        @media (max-width: 560px) {
            .form-grid { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
            .container { padding: 20px; }
        }
    </style>
</head>
<body>
<main class="container">
    <h1>Formulir Data Mahasiswa</h1>
    <p class="intro">Mini Project Praktikum 7 · Pemrograman Server-Side dengan PHP</p>

    <?php if (!empty($error)): ?>
        <div class="error" role="alert">
            <strong>Data belum valid:</strong>
            <ul>
                <?php foreach ($error as $pesan): ?>
                    <li><?= e($pesan) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-grid">
            <div class="field">
                <label for="nama">Nama lengkap</label>
                <input id="nama" name="nama" type="text" value="<?= e($nama) ?>" required>
            </div>
            <div class="field">
                <label for="nim">NIM (angka saja)</label>
                <input id="nim" name="nim" type="text" inputmode="numeric" value="<?= e($nim) ?>" required>
            </div>
            <div class="field full">
                <label for="prodi">Program studi</label>
                <input id="prodi" name="prodi" type="text" value="<?= e($prodi) ?>" required>
            </div>
            <div class="field">
                <label for="semester">Semester (1–14)</label>
                <select id="semester" name="semester" required>
                    <option value="">Pilih semester</option>
                    <?php for ($i = 1; $i <= 14; $i++): ?>
                        <option value="<?= $i ?>" <?= (string)$i === $semesterInput ? "selected" : "" ?>>Semester <?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="<?= e($email) ?>" required>
            </div>
        </div>
        <div class="actions">
            <button type="submit">Kirim Data</button>
            <a class="reset" href="index.php">Reset</a>
        </div>
    </form>

    <?php if ($data !== null): ?>
        <section class="result" aria-live="polite">
            <h2>Data mahasiswa berhasil diterima</h2>
            <table>
                <tr><td>Nama</td><td><?= e($data["nama"]) ?></td></tr>
                <tr><td>NIM</td><td><?= e($data["nim"]) ?></td></tr>
                <tr><td>Program Studi</td><td><?= e($data["prodi"]) ?></td></tr>
                <tr><td>Semester</td><td><?= e($data["semester"]) ?></td></tr>
                <tr><td>Email</td><td><?= e($data["email"]) ?></td></tr>
            </table>
        </section>
    <?php endif; ?>

    <p class="footer">Data diproses di server menggunakan PHP dan metode POST.</p>
</main>
</body>
</html>
