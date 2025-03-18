<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Zad 3</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>

    <body>

        <?php 
        //SimpleXML parser
        
        //Učitaj datoteku
        $xml = simplexml_load_file('LV2.xml');

        echo "<h1 class='row justify-content-center mt-4'>Profili<br></h1>";

        //Iteracija kroz XML
        foreach ($xml->record as $record) { 

            //Ispis
            echo "<div class='card mx-auto mt-3' style='max-width: 50rem;'>
                    <div class='row g-0 justify-content-center'>
                        <div class='d-flex col-md-3 align-items-center justify-content-center'>
                           <img src='$record->slika' class='card-img rounded-circle ' style='width: 6.25rem; height: 6.25rem; object-fit: cover;'>
                        </div>
                        <div class='col-md-9'>
                            <div class='card-body mt-3'>
                                <h3 class='card-title'>$record->ime $record->prezime</h3>
                                <p class='card-text'>$record->zivotopis</p>
                                <div class='row'>
                                    <div class='col-8'>
                                        <p>Email:  <small class='text-muted'>$record->email</small></p>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>";
            
        }
        ?>
    </body>
</html>