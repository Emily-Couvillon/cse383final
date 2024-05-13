<?php
// Start session
session_start();

// Connect to the SQLite database
$DBSTRING = "sqlite:cse383.db";
include "sql.inc";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Step 1
	// Get the username and pasword from the $_POST variables
	$exchange = $_POST['exchange'];
	$stocks = $_POST['stocks'];
    $fd = date("Y-m-d");
    $past = strtotime("-7 days");
    $pd = date("Y-m-d", $past);
}
Print "
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<!-- CSS -->
        <link href='../cse383_final/css/theme.css' rel='stylesheet'>
        <link href='../cse383_final/css/stocks.css' rel='stylesheet'>
        <!-- JQuery -->
        <script src='https://code.jquery.com/jquery-3.6.1.min.js' integrity='sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=' crossorigin='anonymous'>
        </script>
        <script src='stock.js'></script>
        <!-- Bootstrap -->
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
        <!-- More Bootstrap -->
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js' integrity='sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM' crossorigin='anonymous'></script>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>Stock-Lookup</title>
</head>
<body>
<header>
    <nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
                <a class='navbar-brand' href='#'>Navbar</a>
                <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarTogglerDemo01'>
                    <ul class='navbar-nav mr-auto mt-2 mt-lg-0'>
                    <li class='nav-item'>
                        <a class='nav-link' href='../cse383_final/landingpage.html'>Landing Page</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../cse383_final/stocks.html'>Stocks</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../cse383_final/stock-history-and-display.html'>Stock History & Display</a>
                    </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div id='title' class='container text-center text-light'>
            <h2>Stock Search</h2>
        </div>
        <div id='info' class='container bg-dark'>
            <small class='text-light'>Note: This page only allows for 5 consecutive calls in one minute.</small>
            <p id='important' class='text-center'>Select Exchange: ".$exchange." and Selected Stock (ticker): ".$stocks."</p>
        <div class='container bg-dark text-center'>
            <form method='POST' action='stocks.php'>
                <select id='exchange' class='form-select form-select-lg mb-3' name='exchange'>
                    <option value='' selected disabled hidden>Choose exchange here</option>
                </select>
                <select id='stocks' class='form-select form-select-lg mb-3' name='stocks'>
                    <option value='' selected disabled hidden>Choose a stock here</option>
                </select>
                <button type='submit' class='btn btn-primary'>Submit</button>
            </form>
        <!-- Only appears after user selects/submits an exchange -->
        </div>
        <!-- Both of these divs will be hidden until their respective buttons are clicked.
             These buttons will not be visible unless a stock is selected.-->
        <div id='details-main' class='container buttonBoxes text-center'>
            <p>Click the button below to see details of your selected stock.</p>
            <form method='POST' action='detail.php'>
                <input type='hidden' id='pd' name='pd' value='".$pd."' />
                <input type='hidden' id='fd' name='fd' value='".$fd."' />
                <input type='hidden' id='tick' name='tick' value='".$stocks."' />
                <button id='Bdetails' class='btn btn-primary' type='submit'>Details</button>
            </form>
        </div>
        <div id='news-main' class='container buttonBoxes text-center'>
            <p>Click the button below to see news about your selected stock.</p>
            <form method='POST' action='news.php'>
                <input type='hidden' id='tick' name='tick' value='".$stocks."' />
                <button id='Bnews' class='btn btn-primary' type='submit'>News</button>
            </form>
        </div>
        </div>
        <br>
        <footer class='footer fixed-bottom'>
            <span class='text-light'>Copyright © Emily Couvillon 2023</span>
        </footer>
</body>
</html>";
?>
