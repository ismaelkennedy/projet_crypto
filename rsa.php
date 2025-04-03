<?php
// Générer des clés RSA (si elles n'existent pas encore)
$keyFilePublic = 'rsa_public.pem';
$keyFilePrivate = 'rsa_private.pem';

if (!file_exists($keyFilePublic) || !file_exists($keyFilePrivate)) {
    $res = openssl_pkey_new([
        "private_key_bits" => 2048,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    ]);
    openssl_pkey_export($res, $privateKey);
    $publicKey = openssl_pkey_get_details($res)["key"];

    file_put_contents($keyFilePrivate, $privateKey);
    file_put_contents($keyFilePublic, $publicKey);
} else {
    $privateKey = file_get_contents($keyFilePrivate);
    $publicKey = file_get_contents($keyFilePublic);
}

// Fonction pour chiffrer un message avec la clé publique
function encryptMessage($message, $publicKey) {
    openssl_public_encrypt($message, $encrypted, $publicKey);
    return base64_encode($encrypted);
}

// Fonction pour déchiffrer un message avec la clé privée
function decryptMessage($encryptedMessage, $privateKey) {
    openssl_private_decrypt(base64_decode($encryptedMessage), $decrypted, $privateKey);
    return $decrypted;
}

$encryptedMessage = "";
$decryptedMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['encrypt'])) {
        $message = $_POST['message'] ?? '';
        $encryptedMessage = encryptMessage($message, $publicKey);
    } elseif (isset($_POST['decrypt'])) {
        $encryptedInput = $_POST['encrypted_message'] ?? '';
        $decryptedMessage = decryptMessage($encryptedInput, $privateKey);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chiffrement RSA</title>
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
        <h2>🔐 Chiffrement et Déchiffrement RSA</h2>

        <form method="POST">
            <h3>Chiffrement</h3>
            <input type="text" name="message" placeholder="Entrez votre message..." required>
            <br>
            <button type="submit" name="encrypt">🔒 Chiffrer</button>
        </form>

        <?php if (!empty($encryptedMessage)): ?>
            <h3>Message Chiffré</h3>
            <textarea readonly><?= $encryptedMessage ?></textarea>
        <?php endif; ?>

        <form method="POST">
            <h3>Déchiffrement</h3>
            <input type="text" name="encrypted_message" placeholder="Entrez un message chiffré..." required>
            <br>
            <button type="submit" name="decrypt">🔓 Déchiffrer</button>
        </form>

        <?php if (!empty($decryptedMessage)): ?>
            <h3>Message Déchiffré</h3>
            <textarea readonly><?= $decryptedMessage ?></textarea>
        <?php endif; ?>
    </div>

</body>
</html>
