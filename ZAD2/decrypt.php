<!-- Skripta dohvaća šifrirane datoteke, dekriptira ih i daje link za preuzimanje. -->

<?php
session_start();

// Provjera je li naziv datoteke proslijeđen putem URL-a (?file=imedatoteke.ext), čisćenje, 
// konstruira se putanja datoteke i provjerava postoji li datoteka prije nastavka
if (isset($_GET['file'])) {
    $file_name = basename($_GET['file']);
    $file_path = 'uploads/' . $file_name;

    if (!file_exists($file_path)) {
        die("File not found.");
    }

    // Čitanje enkriptiranog filea
    $encrypted_content = file_get_contents($file_path);
    
    // Ključ i metoda za dekriptiranje
    $decryption_key = md5('jed4n j4k0 v3l1k1 kljuc');
    $cipher = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($cipher);

    $decryption_iv = substr($encrypted_content, 0, $iv_length);
    $encrypted_data = substr($encrypted_content, $iv_length);

    // Dešifriranje sadržaja datoteke
    $decrypted_data = openssl_decrypt($encrypted_data, $cipher, $decryption_key, 0, $decryption_iv);

    // Spremanje dekriptirane datoteke
    $decrypted_dir = 'decrypted/';
    if (!file_exists($decrypted_dir)) {
        mkdir($decrypted_dir, 0777, true);
    }
    
    $decrypted_file_path = $decrypted_dir . str_replace(".enc", "", $file_name);
    file_put_contents($decrypted_file_path, $decrypted_data);

    // Link za preuzimanje
    echo "<p>Decryption successful. <a href='download.php?file=" . urlencode(basename($decrypted_file_path)) . "'>Download File</a></p>";
} else {
    echo "<p>No file specified.</p>";
}
?>
