var stockURL = "https://api.polygon.io/v3/reference/tickers";
var newsURL ="https://api.polygon.io/v2/reference/news";
var aggURL = "https://api.polygon.io/v2/aggs/ticker/";


$(document).ready(function(){
    $.getJSON( "exchange.json", function( json ) {
    }).done(function( json ) {
        for (var index = 0; index <= json.results.length; index++) {
            $('#exchange').append('<option value="' + json.results[index].operating_mic + '">' + json.results[index].name + '</option>');
            console.log("Test to see if stuff happened.");
        }
    }).fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            console.log( "Request Failed: " + err );
    });
    // Responds when the select for exchanges is changed
    $("#exchange").change(function(){
        $('#stocks').empty();
        var exchange = $('option:selected', '#exchange').val();
        console.log(exchange);
        
        a=$.ajax({
            url: stockURL + '?market=stocks&exchange=' + exchange + '&active=true&apiKey=gICVOIcHmXBhTr1wdVuCX5mknN9rNcBC',
            method: 'GET'
        }).done(function(data) {
            for (var i = 0; i <= data.results.length; i++) {
                $('#stocks').append('<option value="' + data.results[i].ticker + '">' + data.results[i].name + '</option>');
                //console.log("Stock: " + data.results[i].name + "was added.");
            }
        }).fail(function(error) {
            console.log("There was an error.");
        });
    });

    $("#Bdetails").on("click", function(){
        $('#details-info').empty();
        var ticker = $('option:selected', '#stocks').val();
        var finalDate = new Date();
        var dd = finalDate.getDate();
        if (dd < 10) {
            dd = '0' + dd;
        }
        var mm = finalDate.getMonth() + 1;
        if (mm < 10) {
            mm = '0' + mm;
        }
        var yyyy = finalDate.getFullYear();

        finalDate = yyyy + "-" + mm + "-" + dd;
        console.log(finalDate);

        var pastDateData = new Date();
        pastDateData.setDate(dd - 7);
        var pastMonth = pastDateData.getMonth() + 1;
        if (pastMonth < 10) {
            pastMonth = '0' + pastMonth;
        }
        var pastDay = pastDateData.getDate();
        if (pastDay < 10) {
            pastDay = '0' + pastDay;
        }
        var pastDate = pastDateData.getFullYear() + "-" + pastMonth + "-" + pastDay;
        console.log(pastDate);
        
        //$.post('detail.php', {tick: ticker});
        /*
        function myCallback(data) {
            //do Something
            $('#details-info').append('<div class="bg-dark">' +'<h3 class="text-center">' + data.results.name + '</h3>' + '<p> Phone Number: ' + data.results.phone_number + '</p>' + '<address>' + data.results.address +'</address>' + '<p>'+ data.results.description + '</p>'+ '<p>' + data.results.sic_code + '</p>' + '<p>' + data.results.sic_description + '</p>' + '<p>Home Page:' + data.results.homepage_url + '</p>' + '<p>Total Employees: ' + data.results.total_employees + '</p>' + '<p>List Date: ' + data.results.list_date + '</p>' + '</div>');
        };
        // This is for the ticker details
        /*
        a=$.ajax({
            url: stockURL + '?ticker='+ ticker +'&apiKey=gICVOIcHmXBhTr1wdVuCX5mknN9rNcBC',
            method: 'GET',
            dataType: 'json',
            contentType: 'application/json',
            success: function(data) {
                $('#details-info').append('<div class="bg-dark">' +'<h3 class="text-center">' + data.results.name + '</h3>' + '<p> Phone Number: ' + data.results.phone_number + '</p>' + '<address>' + data.results.address +'</address>' + '<p>'+ data.results.description + '</p>'+ '<p>' + data.results.sic_code + '</p>' + '<p>' + data.results.sic_description + '</p>' + '<p>Home Page:' + data.results.homepage_url + '</p>' + '<p>Total Employees: ' + data.results.total_employees + '</p>' + '<p>List Date: ' + data.results.list_date + '</p>' + '</div>');
            }
        }).done(function(data) {
            console.log("success");
        }).fail(function(error) {
            console.log("There was an error.");
        });*/

        // This is the historic call/aggregate
        /*
        detailData(ticker, pastDate, finalDate).then(function(data) {
            sendDetail(ticker, data);
        });*/
        // The third call
    });

    // The news button
    $("#Bnews").on("click", function(){
        $('#news-info').empty();
    });
});
/*
testStock();
function testStock() {
    a=$.ajax({
        url: URL + '?market=stocks&exchange=XNYS&active=true&apiKey=gICVOIcHmXBhTr1wdVuCX5mknN9rNcBC',
        method: 'GET'
    }).done(function(data) {
        for (var i = 0; i <= data.results.length; i++) {
            $('#stock').append('<div id="' + data.results[i].ticker + '">' + data.results[i].name + '</div>');
            console.log("Stock: " + data.results[i].name + "was added.");
        }
    }).fail(function(error) {
        console.log("There was an error.");
    });
}*/

