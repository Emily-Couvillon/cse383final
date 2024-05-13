<?php
    
    $DBSTRING = "sqlite:cse383.db";
    include "sql.inc";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ticker = $_POST['tick'];
        $start = $_POST['pd'];
        $final = $_POST['fd']; 
    }
    $i = 7;
    $historicURL = 'https://api.polygon.io/v2/aggs/ticker/'.$ticker.'/range/1/day/'.$start.'/'.$final.'?adjusted=true&sort=asc&limit=120&apiKey=gICVOIcHmXBhTr1wdVuCX5mknN9rNcBC';
    $historic_json = file_get_contents($historicURL);
    $historic_response = json_decode($historic_json);
    $historic_results = $historic_response->results;

    $detailURL = 'https://api.polygon.io/v3/reference/tickers/'.$ticker.'?apiKey=gICVOIcHmXBhTr1wdVuCX5mknN9rNcBC';
        $detail_json =file_get_contents($detailURL);
        $response_data = json_decode($detail_json);
        $results = $response_data->results;
        $logo = $results->branding->logo_url."?apiKey=gICVOIcHmXBhTr1wdVuCX5mknN9rNcBC";
    
    $json_array = array();
    $json_array['details'] = $response_data;
    $json_array['historic'] = $historic_response;
    $encoded_merge = json_encode($json_array);
    
    $databaseURL = 'http://172.17.12.75/cse383_final/final.php?method=setStock&stockTicker='.$ticker.'&queryType=detail&jsonData='.urlencode($encoded_merge);
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($json_array)
        )
    );
    $context  = stream_context_create($options);
    $resultCall = file_get_contents($databaseURL, false, $context);
    if ($resultCall === FALSE) { //Handle error  
    }

    print "
    <!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<!-- CSS -->
        <link href='../cse383_final/css/theme.css' rel='stylesheet'>
        <link href='../cse383_final/css/stock-detail.css' rel='stylesheet'>
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
<title>Stock-Lookup-Details</title>
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
            <p>Select an exchange and look up a stock.
        <div class='container bg-dark'>
            <form method='POST' action='stocks.php'>
                <select id='exchange' class='form-select form-select-lg mb-3' name='exchange' required>
                    <option value='' selected disabled hidden>Choose exchange here</option>
                </select>
                <select id='stocks' class='form-select form-select-lg mb-3' name='stocks' required>
                    <option value='' selected disabled hidden>Choose a stock here</option>
                </select>
                <button type='submit' class='btn btn-primary'>Submit</button>
            </form>
        <!-- Only appears after user selects/submits an exchange -->
        </div>
        <!-- Both of these divs will be hidden until their respective buttons are clicked.
             These buttons will not be visible unless a stock is selected.-->
        <div id='details-main' class='container'>
            <div id='details-info'>
                <div class='bg-dark detail'>
                    <img class='rounded mx-auto d-block' src='".$logo."' alt='logo'>
                    <h3 class='text-center'>".$results->name."</h3>
                    <p>Phone Number: ".$results->phone_number."</p>
                    <address class='bg-light'>".$results->address->address1."<br>"
                    .$results->address->city.", ".$results->address->state." ".$results->address->postal_code."</address>
                    <p>".$results->description."</p>
                    <p>Standard Industrial Classification (SIC) Code: ".$results->sic_code."</p>
                    <p>Standard Industrial Classification (SIC) Description: ".$results->sic_description."</p>
                    <p>Home Page: ".$results->homepage_url."</p>
                    <p>Total Employees: ".$results->total_employees."</p>
                    <p>List Date: ".$results->list_date."</p>
                </div>
                <h3 class='text-center'>Historic Data</h3>";
                foreach($historic_results as $res) {
                    $date = strtotime('-'.$i.' days');
                    print "<div class='daily text-center'>
                        <p id='date'>".date('Y-m-d', $date)."</p>
                        <p><b>Volume:</b> ".$res->v."</p>
                        <p><b>Open Price:</b> $".$res->o."</p>
                        <p><b>Close Price:</b> $".$res->c."</p>
                        <p><b>High Price:</b> $".$res->h."</p>
                        <p><b>Low Price:</b> $".$res->l."</p>
                        <p><b>Total transactions:</b> ".$res->n."</p>
                    </div>";
                    $i--;
                }
            print "</div>
        </div>
        </div>
        <br>
        <footer class='footer fixed-bottom'>
            <span class='text-light'>Copyright © Emily Couvillon 2023</span>
        </footer>
    </body>
    </html>";
?>
