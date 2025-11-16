<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];
$contacts = json_decode(file_get_contents("contacts.json"), true);

if (!isset($contacts[$id])) {
    die("Kontak tidak ditemukan!");
}

$errors = [];
$nama = $contacts[$id]["nama"];
$email = $contacts[$id]["email"];
$nomor = $contacts[$id]["nomor"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["nama"])) $errors[] = "Nama wajib diisi";
    else $nama = htmlspecialchars(trim($_POST["nama"]));

    if (empty($_POST["email"])) $errors[] = "Email wajib diisi";
    elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        $errors[] = "Email tidak valid";
    else $email = htmlspecialchars(trim($_POST["email"]));

    if (empty($_POST["nomor"])) $errors[] = "Nomor wajib diisi";
    elseif (!preg_match("/^[0-9]+$/", $_POST["nomor"]))
        $errors[] = "Nomor harus angka";
    else $nomor = htmlspecialchars(trim($_POST["nomor"]));

    if (empty($errors)) {
        $contacts[$id] = [
            "nama" => $nama,
            "email" => $email,
            "nomor" => $nomor
        ];
        file_put_contents("contacts.json", json_encode($contacts, JSON_PRETTY_PRINT));
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Kontak</title></head>
<body>

<h2>Edit Kontak</h2>

<?php foreach ($errors as $e): ?>
<p style="color:red;"><?php echo $e; ?></p>
<?php endforeach; ?>

<form method="POST">
    Nama: <input type="text" name="nama" value="<?php echo $nama; ?>"><br><br>
    Email: <input type="email" name="email" value="<?php echo $email; ?>"><br><br>
    Nomor: <input type="text" name="nomor" value="<?php echo $nomor; ?>"><br><br>

    <button type="submit">Update</button>
</form>

<a href="dashboard.php">Kembali</a>

</body>
</html>
