<!DOCTYPE html>
<html lang="en">
<head>
    <meta lang="PL">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kod Morse'a</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        require "connect.php";

        $conn = mysqli_connect($host, $username, $password, $database) or die("Blad polaczenia!");
        $sql = "SELECT latin_letter, morse_letter FROM morse_data";
        $result = mysqli_query($conn, $sql);

        $slownikMorsea = [];

        if (mysqli_num_rows($result) > 0) 
        {
            while ($row = mysqli_fetch_row($result)) 
            {
                $latinLetter = $row[0];
                $morseLetter = $row[1];
                
                $slownikMorsea[$latinLetter] = $morseLetter;
            }
        }
        mysqli_close($conn);

        function textToMorse($text, $dictionary)
        {
            $text = strtoupper($text);
            $morseCode = '';

            for ($i = 0; $i < strlen($text); $i++) 
            {
                $char = $text[$i];
                if (isset($dictionary[$char])) 
                {
                    $morseCode .= $dictionary[$char] . ' ';
                } 
                else 
                {
                    $morseCode .= '/ ';
                }
            }
            return trim($morseCode);
        }
    ?>
    <header class="head">
        <h1>KOD MORSE'A</h1>
    </header>
    <div class="container">
        <form method="POST" action="strona.php">
            <div class="input-box">
                <label for="latinText">Wprowadź tekst do przetłumaczenia na kod Morse'a</label>
                <input type="text" name="latinText" id="latinText">
            </div>
            <button class="button" type="submit">Przetłumacz do Kodu Morse'a</button>
        </form>
        <div class="result-box">
            <?php
                if (isset($_POST['latinText'])) 
                {
                    $inputText = $_POST['latinText'];
                    $morseTranslation = textToMorse($inputText, $slownikMorsea);
                    echo '<label for="morseOutput">Wynik translacji na kod Morse\'a: </label>';
                    echo '<input type="text" id="morseOutput" value="' . $morseTranslation . '" readonly>';
                }
            ?>
        </div>
    </div>
</body>
</html>