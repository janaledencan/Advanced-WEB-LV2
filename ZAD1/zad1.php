<!-- Napravite skriptu koja će napraviti backup baze podataka, spremiti ga u .txt datoteku i 
nakon toga sažeti dobivenu .txt datoteku. Format zapisa podataka u datoteku treba biti: 
INSERT INTO nazivTablice (atribut1, atribut2, atribut3) 
VALUES ('vrijednost1', 'vrijednost2', 'vrijednost3)"; 
INSERT INTO nazivTablice (atribut1, atribut2, atribut3) 
VALUES ('vrijednost1', 'vrijednost2', 'vrijednost3)"; -->


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Zad 1</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>

    <body>
        <?php 
        /* Skripta prima podatke iz baze podataka i sprema ih u txt datoteku
        koja se nakon toga sažima pomoću biblioteke zlib */
        
        //Naziv baze podataka
        $db_name = "restaurant";

        //Direktorij za backup
        $dir = "backup/$db_name";

        //Ako direktorij ne postoji stvori ga 
        if (!is_dir($dir)) {
            if (!@mkdir($dir, 0777, true)) {
                die("<p class='alert alert-danger'>Ne možemo stvoriti direktorij $dir.</p></body></html>");
            }
        }

        //Trenutno vrijeme
        $time = time();

        //Spoj na bazu podataka
        $dbc = @mysqli_connect(
            'localhost', 
            'root', 
            '', 
            $db_name
        ) OR die("<p class='alert alert-danger'>Ne možemo se spojiti na bazu $db_name.</p></body></html>");

        //Pokaži sve tablice iz baze podataka
        $r = mysqli_query($dbc, 'SHOW TABLES');

        //Radimo backup ako postoji barem jedna tablica
        if (mysqli_num_rows($r) > 0) {

            //Poruka da se radi backup
            echo "<p class='alert alert-info'>Backup za bazu podataka '$db_name'.</p>";

            //Otvaranje 1 zajednickog backup filea za sve tablice
            $backup_file = "$dir/backup_{$db_name}_{$time}.sql.gz";
            if (!$fp = gzopen ($backup_file, 'w9')) {
                die("<p class='alert alert-danger'>Datoteka $backup_file se ne može otvoriti.</p>");
            }

            
            //Dohvati ime svake tablice
            while (list($table) = mysqli_fetch_array($r, MYSQLI_NUM)) {
            
                // Dohvati nazive stupaca
                $columnsQuery = "SHOW COLUMNS FROM `$table`";
                $columnsResult = mysqli_query($dbc, $columnsQuery);
                $columns = [];

                while ($column = mysqli_fetch_assoc($columnsResult)) {
                    $columns[] = "`" . $column['Field'] . "`"; // Zaštita imena stupaca
                }

                $columnsList = implode(", ", $columns);

                //Dohvati podatke iz tablice
                $q = "SELECT * FROM $table";
                $r2 = mysqli_query($dbc, $q);
                   
                
                //Ako postoje podaci
                if (mysqli_num_rows($r2) > 0) {
                    
                        //Dohvat podataka iz tablice
                        while ($row = mysqli_fetch_array($r2, MYSQLI_NUM)) {
                            
                            // Priprema podataka za INSERT
                            $values = array_map(function ($value) {
                                return "'" . addslashes($value) . "'"; 
                            }, $row);
            
                            $valuesList = implode(", ", $values);
            
                            // SQL upit
                            $sql = "INSERT INTO `$table` ($columnsList) VALUES ($valuesList);\n";
            
                            // Upis u backup datoteku
                            gzwrite($fp, $sql);
        
                        }
                    }
            
                    echo "<p class='alert alert-info'>Tablica '$table' je pohranjena.</p>";
                }
            
                // Zatvori datoteku
                gzclose($fp);
                    
                echo "<p class='alert alert-success'>Backup uspješno završen! Pohranjeno u <b>$backup_file</b>.</p>";
            } else {
                echo "<p class='alert alert-warning'>Baza $db_name ne sadrži tablice.</p>";
            }

        ?>
    </body>
</html>