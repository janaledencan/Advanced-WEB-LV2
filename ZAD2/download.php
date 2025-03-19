<!-- Skripta za preuzimanje dekriptirane datoteke. -->

<?php
if (isset($_GET['file'])) {
    $file_name = basename($_GET['file']);
    $file_path = 'decrypted/' . $file_name;

    if (file_exists($file_path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}
?>
