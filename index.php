<?php

// database connection
try{
    $db=new PDO('mysql:host=localhost;dbname=weather;charset=utf8','root','');
    $db->exec('SET NAMES "UTF8"');
}
catch(PDOException  $e)
{
    die('Erreur: '.$e->getMessage());   
}

// READ
$sql = 'SELECT * FROM `meteo`';
$query = $db->prepare($sql);
$query->execute();
$result  = $query->fetchAll(PDO::FETCH_ASSOC);

// CREATE
if(! empty($_GET['submit'])){

    $city = $_GET['city'];
    $basse = $_GET['basse'];
    $haute = $_GET['haute'];

    $sql = "INSERT INTO `meteo` (`city`, `basse`, `haute`) VALUES (:city, :basse, :haute);";
    $query = $db->prepare($sql);

    $query->bindValue(':city', $city, PDO::PARAM_STR);
    $query->bindValue(':basse', $basse, PDO::PARAM_INT);
    $query->bindValue(':haute', $haute, PDO::PARAM_INT);

    $query->execute();

    Header('Location: '.$_SERVER['PHP_SELF']);
    Exit(); //optional
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather app</title>
</head>
<body>
    <?php if(! empty($result)){ ?>
    <table>
        <thead>
            <th>Ville</th>
            <th>T° Basse</th>
            <th>T° Haute</th>
        </thead>
        <tbody>
            <h1>Weather app</h1>

            <?php foreach($result  as $data){ ?>
                <tr>
                    <td>
                        <?php echo $data['city'] ?>
                    </td>
                    <td>
                        <?php echo $data['basse'] ?>
                    </td>
                    <td>
                        <?php echo $data['haute'] ?>
                    </td>
                </tr>
            <?php } ?>  <!-- end foreach -->

        </tbody>
    </table>
    <?php } ?>  <!-- end if -->
    
    <form action="#" method="get">
        <label for="city">Ville</label>
        <input type="text" name="city">
        <br>
        <label for="basse">T° Basse</label>
        <input type="number" name="basse">
        <br>
        <label for="haute">T° Haute</label>
        <input type="number" name="haute">
        <br>
        <input type="submit" name="submit" value="Send me">
    </form>
</body>
</html>