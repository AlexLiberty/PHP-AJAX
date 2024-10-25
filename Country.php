<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <title>Країни</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Додати країну</h2>

<form method="post" action="">
    <label for="country">Назва країни:</label>
    <input class="input" type="text" name="country" id="country" required>
    <button class="button" type="submit">Додати</button>
</form>

<?php
$file = 'countries.txt';
$dictionary = 'dictionary.txt';

function getCountries($file)
{
    if (file_exists($file))
    {
        return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
    return [];
}

$dictionaryCountries = getCountries($dictionary);

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $country = trim($_POST['country']);

    if (!empty($country))
    {
        if (in_array($country, $dictionaryCountries))
        {
            $countries = getCountries($file);

            if (!in_array($country, $countries))
            {
                file_put_contents($file, $country . PHP_EOL, FILE_APPEND);
                echo "<p style='color: green;'>Країна '$country' успішно додана.</p>";
            }
            else
            {
                echo "<p style='color: red;'>Країна '$country' вже є у списку.</p>";
            }
        }
        else
        {
            echo "<p style='color: red;'>Країна '$country' не знайдена в еталонному списку.</p>";
        }
    }
}

$countries = getCountries($file);

if (!empty($countries))
{
    echo '<h3>Перелік країн:</h3>';
    echo '<select class="select">';
    foreach ($countries as $c)
    {
        echo "<option>$c</option>";
    }
    echo '</select>';
}
?>

</body>
</html>
