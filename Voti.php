<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Voti</title>
        <style>
            * {
                font-size: 1.1em;
            }
            table {
                border-collapse: collapse; /* PER AVERE LA RIGA COLORATA */
            }
            tr {
                margin-top: 10px;
            }
            td {
                font-size: 0.85em;
            }
            .bordoRosso {
                border: 3px solid red;
            }
            .bordoVerde {
                border: 3px solid green;
            }
            .testoRosso {
                color: red;
            }
            .testoArancione {
                color: orange;
            }
            .testoVerde {
                color: green;
            }
            .bold {
                font-weight: bold;
            }
            p {
                margin: 5px;
            }
        </style>
    </head>
    <body>

        <table>
            <tr>
                <th>Materia</th>
                <th>Voti</th>
                <th>Media</th>
            </tr>
<?php
    // Array originale dei voti
    $voti_orig = [
        "Italiano" => [7, 8, 6],
        "Matematica" => [8, 7, 9, 6],
        "Inglese" => [6, 7, 6],
        "Storia" => [5, 6, 7],
        "Informatica" => [9, 8, 10],
        "Scienze" => [7, 7, 8]
    ];

    // Rifaccio un altro array in modo che l'indice sia la materia e il contenuto sia
    // un altro array contenente voti e media già calcolata. Esempio
    // array(6) {
    //      ["Italiano"]=> array(2) {
    //          ["voti"]=> array(3) { [0]=> int(7) [1]=> int(8) [2]=> int(6) }
    //          ["media"]=> float(7)
    //      }
    //      ["Matematica"]=> [ ... ]
    //      ...
    // }
    // In alternativa posso fare un altro array con le medie avendo come indice le materie e usare quello.
    $voti=[];
    foreach ($voti_orig as $m => $v) {
        $media = array_sum($v) / count($v);
        $voti[$m] = [
            "voti" => $v,
            "media" => (float) round($media, 2)
        ];
    }
    //var_dump($voti);


    // Calcolo delle statistiche della media, potevo utilizzare anche il for sovrastante ma per comprensione uso uno nuovo
    $mediaColmpessiva = 0;
    $mediaHighest = [
        "materia" => "notSet",
        "valore" => -1
    ];
    $mediaLowest = [
        "materia" => "notSet",
        "valore" => 11
    ];
    $votoHighest = [
        "materia" => "notSet",
        "valore" => -1
    ];
    $votoLowest = [
        "materia" => "notSet",
        "valore" => 11
    ];
    $nInsufficenze = 0;
    $nSufficenze = 0;

    foreach ($voti as $mat => $vot) {
        $mediaColmpessiva += $vot['media'];
        if ($mediaHighest['valore'] < $vot["media"]) { // CALCOLO MEDIA PIÙ ALTA
            $mediaHighest['materia'] = $mat;
            $mediaHighest['valore'] = $vot["media"];
        }
        if ($mediaLowest['valore'] > $vot["media"]) { // CALCOLO MEDIA PIÙ BASSA
            $mediaLowest['materia'] = $mat;
            $mediaLowest['valore'] = $vot["media"];
        }
        foreach ($vot['voti'] as $v) {
            if ($votoHighest['valore'] < $v) { // CALCOLO VOTO PIÙ ALTO
                $votoHighest['materia'] = $mat;
                $votoHighest['valore'] = $v;
            }
            if ($votoLowest['valore'] > $v) { // CALCOLO VOTO PIÙ BASSO
                $votoLowest['materia'] = $mat;
                $votoLowest['valore'] = $v;
            }
            if ($v >= 6) $nSufficenze++; // CALCOLO INSUFFICENZE
            else $nInsufficenze++; // CALCOLO SUFFICENZE
        }
    }
    $mediaColmpessiva = round($mediaColmpessiva / count($voti), 2);

    /*
    echo "<b>mediaHighest</b>" . var_dump($mediaHighest) . "<br>";
    echo "<b>mediaLowest</b>" . var_dump($mediaLowest) . "<br>";
    echo "<b>votoHighest</b>" . var_dump($votoHighest) . "<br>";
    echo "<b>votoLowest</b>" . var_dump($votoLowest) . "<br>";
    echo "<b>nInsufficenze</b>" . var_dump($nInsufficenze) . "<br>";
    echo "<b>nSufficenze</b>" . var_dump($nSufficenze) . "<br>";
    */

    // STAMPA DELLA TABELLA
    foreach ($voti as $mat => $c) {

        // CONTROLLO SE MATERIA CON MEDIA MINORE O MAGGIORE E COLORO LA RIGA
        if ($mat == $mediaLowest['materia']) echo "<tr class='bordoRosso'>";
        elseif ($mat == $mediaHighest['materia']) echo "<tr class='bordoVerde'>";
        else echo "<tr>";

        echo "<td>$mat</td>";

        echo "<td>";
        foreach ($c["voti"] as $v) {
            // Controllo se il testo deve essere bold o no
            if (($mat == $votoHighest['materia'] || $mat == $votoLowest['materia']) &&
                ($v == $votoHighest['valore'] || $v == $votoLowest['valore']))
                $bold= "bold";
            else
                $bold = "";

            if ($v < 6) echo "<span class='testoRosso $bold'>$v  </span>";
            elseif ($v == 6) echo "<span class='testoArancione $bold'>$v  </span>";
            else echo "<span class='testoVerde $bold'>$v  </span>";
        }
        echo "</td>";

        echo "<td>";
        if ($c['media'] < 6) echo "<span class='testoRosso'>" . $c['media'] . "  </span>";
        elseif ($c['media'] >= 6 && $c['media'] < 7) echo "<span class='testoArancione'>" . $c['media'] . "  </span>";
        else echo "<span class='testoVerde'>" . $c['media'] . "  </span>";
        echo "</td>";

        echo "</tr>";
    }
?>

        </table>

        <!-- (COMMENTO HTML)
        IN NUOVI PEZZI DI PHP STAMPO IL RIEPILOGO.
        In nuovi per questioni di stile e per far vedere che ci possono essere più pezzi
        con php intralacciati con il testo html quando serve
        -->
        <br>
        <h1>Riepologo</h1>
        <p>Media complessiva <?php echo $mediaColmpessiva;?></p>
        <p>Materia con la media più alta: <?php echo $mediaHighest['materia'];?> </p>
        <p>Materia con la media più bass: <?php echo $mediaLowest['materia'];?> </p>
        <p>Voto massimo: <?php echo $votoHighest['materia'];?> </p>
        <p>Voto minimo: <?php echo $votoLowest['materia'];?> </p>
        <p>Numero di voti sufficienti: <?php echo $nSufficenze;?> </p>
        <p>Numero di voti insufficienti: <?php echo $nSufficenze;?> </p>

    </body>
</html>
