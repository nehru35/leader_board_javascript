<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/leaderboard.css">
    <style>
        body {
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .container {
            max-width: 600px;
        }
        h1, h2, h3 {
            text-align: center;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Leaderboard</h1>
        <?php

        // Connect to the database
        $conn = new sqlite3.Database('mydb.sqlite');

        // Execute a SELECT query to retrieve the data
        $query = 'SELECT winner_name, loser_name, moves FROM leaderboard';
        $result = $conn->query($query);

        // Loop through the result set and count the number of wins for each player
        $wins = array();
        while ($row = $result->fetchArray()) {
            $winner_name = $row['winner_name'];
            $loser_name = $row['loser_name'];
            if (!isset($wins[$winner_name])) {
                $wins[$winner_name] = 0;
            }
            $wins[$winner_name]++;
        }

        // Sort the players by the number of wins
        arsort($wins);

        // Display the scores
        foreach ($wins as $name => $num_wins) {
            echo '<div class="card">';
            echo '<div class="card-header">' . htmlspecialchars($name) . ': ' . htmlspecialchars($num_wins) . ' wins</div>';

            // Execute a SELECT query to retrieve the games won by this player
            $query = "SELECT * FROM leaderboard WHERE winner_name = '$name' ORDER BY moves DESC";
            $result = $conn->query($query);

            // Loop through the result set and display the scores
            echo '<div class="card-body">';
            while ($row = $result->fetchArray()) {
                $loser_name = $row['loser_name'];
                $moves = $row['moves'];
                echo '<p class="card-text">Defeated ' . htmlspecialchars($loser_name) . ' in ' . htmlspecialchars($moves) . ' moves</p>';
            }
            echo '</div>';
            echo '</div>';
        }

        // Close the database connection
        $conn->close();

        ?>
    </div>
</body>
</html>
