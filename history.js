$(document).ready(function(){

            $("form").on("submit", function(event){
                event.preventDefault();
                $('tbody').empty();
                $('.data').remove();

                var formValues= $(this).serialize();
                $.ajax({
                    url: "http://172.17.12.75/cse383_final/final.php?method=getLookup&" + formValues,
                    method: "GET"
                }).done(function(data){
                    $('#result').removeClass("visually-hidden");
                    $('#enclose').removeClass("contain");
                    $('#enclose').addClass("contain2");
                    $('#result').append("<p class='data'>Count: " + data.result.length +"</p>");
                    for (var i = 0; i <= data.result.length; i++) {
                        $("tbody").append("<tr class='data" + i + "'><td>" + data.result[i].dateTime + "</td><td>" + data.result[i].stockTicker + "</td><td>" + data.result[i].queryType + "</td><td id='" + i + "'class='moreInfo'><input type='checkbox' id='check'><label for='check'><p class='json'>" + JSON.stringify(data.result[i].jsonData) + "</p></label></td></tr>");
                    }
                }).fail(function(error){
                    console.log(error);
                });
            });

        });
