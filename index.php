<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/main.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <title>Shop Opening Times</title>
</head>
<body>
    <h1>Shop Opening Times</h1>
    <div id="container">
        
        <span class="current-time" id="current-time"></span>
        <?php
            include_once('openingHours.php');

            $date           = shopOpeningHours::getDateTime();
            $openingTimes   = shopOpeningHours::getOpeningTimes();
   
            // List opening times
            foreach ($openingTimes as $key => $time) :
                echo "<div class='times' id='${key}'>${key} ${time['Open']} - ${time['Closed']}</div><br>";
            endforeach;
        ?>

        <div id="openStatus"></div><br/>
    
        <hr>

        <div class="description">
            <p>The above display is created using HTML, CSS, JavaScript and PHP. </p>

            <p>The page activity, such as the time ticking by and the updating of the 'open' status, is achieved using JavaScript. The content itself, is gained through PHP classes and methods.</p>

            <p>The main PHP class implements an Interface. This is not actually necessary for this project, but I added it for demonstration purposes.</p>
        </div>

    </div>
</body>
</html>