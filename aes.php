<?php
// Fonction pour chiffrer un message avec une clé fournie par l'utilisateur
function encryptMessage($message, $userKey, $userIV) {
    if (strlen($userKey) !== 32 || strlen($userIV) !== 16) {
        return "Erreur : La clé doit faire 32 caractères et l'IV 16 caractères.";
    }
    
    $key = hash('sha256', $userKey, true);
    $iv = $userIV;

    $encrypted = openssl_encrypt($message, 'AES-256-CBC', $key, 0, $iv);
    return base64_encode($encrypted);
}

// Fonction pour déchiffrer un message avec une clé fournie par l'utilisateur
function decryptMessage($encryptedMessage, $userKey, $userIV) {
    if (strlen($userKey) !== 32 || strlen($userIV) !== 16) {
        return "Erreur : La clé doit faire 32 caractères et l'IV 16 caractères.";
    }

    $key = hash('sha256', $userKey, true);
    $iv = $userIV;

    $decrypted = openssl_decrypt(base64_decode($encryptedMessage), 'AES-256-CBC', $key, 0, $iv);
    return $decrypted ?: "Erreur : Impossible de déchiffrer. Vérifiez la clé et l'IV.";
}

$encryptedMessage = "";
$decryptedMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['encrypt'])) {
        $message = $_POST['message'] ?? '';
        $userKey = $_POST['key'] ?? '';
        $userIV = $_POST['iv'] ?? '';

        $encryptedMessage = encryptMessage($message, $userKey, $userIV);
    } elseif (isset($_POST['decrypt'])) {
        $encryptedInput = $_POST['encrypted_message'] ?? '';
        $userKey = $_POST['key'] ?? '';
        $userIV = $_POST['iv'] ?? '';

        $decryptedMessage = decryptMessage($encryptedInput, $userKey, $userIV);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chiffrement AES-256</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5; 
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #000000;
        }
        input, textarea {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #000000;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
        }
        textarea {
            resize: none;
            height: 80px;
        }
        button {
            background-color: #000000;
            color: white;
            border: none;
            padding: 12px 20px;
            margin: 10px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>🔐 Chiffrement et Déchiffrement AES-256</h2>

        <form method="POST">
            <h3>Chiffrement</h3>
            <input type="text" name="message" placeholder="Entrez votre message..." required><br>
            <input type="text" name="key" placeholder="Entrez votre clé (32 caractères)" required><br>
            <input type="text" name="iv" placeholder="Entrez votre IV (16 caractères)" required><br>
            <button type="submit" name="encrypt">🔒 Chiffrer</button>
        </form>

        <?php if (!empty($encryptedMessage)): ?>
            <h3>Message Chiffré</h3>
            <textarea readonly><?= $encryptedMessage ?></textarea>
        <?php endif; ?>

        <form method="POST">
            <h3>Déchiffrement</h3>
            <input type="text" name="encrypted_message" placeholder="Entrez un message chiffré..." required><br>
            <input type="text" name="key" placeholder="Entrez votre clé (32 caractères)" required><br>
            <input type="text" name="iv" placeholder="Entrez votre IV (16 caractères)" required><br>
            <button type="submit" name="decrypt">🔓 Déchiffrer</button>
        </form>

        <?php if (!empty($decryptedMessage)): ?>
            <h3>Message Déchiffré</h3>
            <textarea readonly><?= $decryptedMessage ?></textarea>
        <?php endif; ?>
    </div>

</body>
</html>
