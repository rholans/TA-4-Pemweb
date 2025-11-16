<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$contacts = json_decode(file_get_contents("contacts.json"), true);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kontak</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Daftar Kontak</h2>

    <p>Halo, <?php echo $_SESSION["username"]; ?> | 
    <a href="logout.php">Logout</a></p>

    <a href="add.php">➕ Tambah Kontak</a>
    <br><br>

    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Nomor</th>
            <th>Aksi</th>
        </tr>

        <?php if ($contacts): ?>
            <?php foreach ($contacts as $id => $c): ?>
                <tr>
                    <td><?php echo htmlspecialchars($c["nama"]); ?></td>
                    <td><?php echo htmlspecialchars($c["email"]); ?></td>
                    <td><?php echo htmlspecialchars($c["nomor"]); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $id; ?>">Edit</a> |
                        <a href="delete.php?id=<?php echo $id; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
