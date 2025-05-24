<?php
session_start();
require 'DatabaseConnection.php';

$db = new DatabaseConnection();
$db->startConnection();
$conn = $db->conn;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("
        SELECT s.name AS sherbimi, s.price, s.time, r.data_rezervimit, r.id
        FROM rezervimet r
        JOIN sherbimet s ON r.sherbim_id = s.id
        WHERE r.user_id = :user_id
        ORDER BY r.data_rezervimit DESC
    ");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $rezervimet = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Gabim gjatë marrjes së rezervimeve: " . $e->getMessage();
    $rezervimet = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['anulo_rezervimin'])) {
    try {
        $stmt = $conn->prepare("
            DELETE FROM rezervimet 
            WHERE id = :id AND user_id = :user_id
        ");
        $stmt->bindParam(':id', $_POST['rezervim_id'], PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = "Rezervimi u anulua me sukses!";
            header("Location: rezervimet.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gabim gjatë anulimit: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Rezervimet e mia</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #6d4c3d; color: white; }
        tr:hover { background-color: #f5f5f5; }
        .btn { 
            background-color: #e74c3c; color: white; border: none; 
            padding: 8px 12px; border-radius: 4px; cursor: pointer;
        }
        .btn:hover { background-color: #c0392b; }
        .alert { 
            padding: 10px; margin: 10px 0; border-radius: 4px;
        }
        .success { background-color: #dff0d8; color: #3c763d; }
        .error { background-color: #f2dede; color: #a94442; }
        .actions { margin-top: 20px; }
        .actions a { 
            color: #6d4c3d; text-decoration: none; margin-right: 15px;
        }
        .actions a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Rezervimet e mia</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (empty($rezervimet)): ?>
            <p>Nuk keni asnjë rezervim aktual.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Shërbimi</th>
                        <th>Çmimi (€)</th>
                        <th>Kohëzgjatja</th>
                        <th>Data</th>
                        <th>Veprime</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rezervimet as $rezervim): ?>
                        <tr>
                            <td><?= htmlspecialchars($rezervim['sherbimi']) ?></td>
                            <td><?= number_format($rezervim['price'], 2) ?>€</td>
                            <td><?= $rezervim['time'] ?> minuta</td>
                            <td><?= date('d/m/Y H:i', strtotime($rezervim['data_rezervimit'])) ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="rezervim_id" value="<?= $rezervim['id'] ?>">
                                    <button type="submit" name="anulo_rezervimin" class="btn"
                                        onclick="return confirm('A jeni i sigurt që dëshironi të anuloni këtë rezervim?')">
                                        Anulo
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="actions">
            <a href="sherbimet.php">&#8592; Kthehu te shërbimet</a>
            <a href="logout.php">Dil &#8594;</a>
        </div>
    </div>
</body>
</html>