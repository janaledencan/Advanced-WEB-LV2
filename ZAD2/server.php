<!-- Skripta šifrira učitanu datoteku i sprema samo enkriptiranu verziju -->

<?php
session_start();

// Provjera je li file učitan
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $file_name = basename($_FILES['file']['name']);
    $file_tmp = $_FILES['file']['tmp_name'];
    $upload_dir = 'uploads/';

    // Čitanje sadržaja filea
    $file_data = file_get_contents($file_tmp);

    // Ključ i metoda za šifriranje
    $encryption_key = md5('jed4n j4k0 v3l1k1 kljuc');
    $cipher = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($cipher);
    $encryption_iv = random_bytes($iv_length);

    // Enkripcija sadržaja iz filea
    $encrypted_data = openssl_encrypt($file_data, $cipher, $encryption_key, 0, $encryption_iv);

    // Spremanje enkriptiranih podataka i IV
    $encrypted_file_path = $upload_dir . $file_name . ".enc";
    file_put_contents($encrypted_file_path, $encryption_iv . $encrypted_data);

    echo "<p>File successfully uploaded and encrypted.</p>";
    echo "<p><a href='zad2.php'>Back</a></p>";
} else {
    echo "<p>File upload failed!</p>";
}
?>
