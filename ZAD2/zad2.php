<!-- Napraviti skriptu koja će omogućiti upload dokumenta ili slike (pdf, jpeg,png) i kriptiranje dokumenta 
pomoću biblioteke OpenSSL. Na serveru treba biti uploadan samo kriptirani dokument. Napraviti skriptu 
koja će dohvatiti sve kriptirane dokumente, dekriptirati ih i prikazati linkove za preuzimanje dokumenata -->

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload & Encrypt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="mb-5">Upload & Encrypt File</h2>
    
    <form action="server.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="file" class="form-label">Choose a file (PDF, JPEG, PNG)</label>
            <input type="file" class="form-control" name="file" id="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>

    <hr>
    <h3 class="mt-5">Encrypted Files</h3>
    <ul>
        <?php
        if ($handle = opendir('uploads/')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    echo "<li><a href='decrypt.php?file=" . urlencode($file) . "'>$file (Decrypt & Download)</a></li>";
                }
            }
            closedir($handle);
        }
        ?>
    </ul>
</body>
</html>