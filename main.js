function ajaxrequest(){
    // Create the XMLHttpRequest variable.
    var xhr2 = new XMLHttpRequest();
    // This variable represents the AJAX communication between client and
    // server.
        //var xhr2 = new XMLHttpRequest(); -- now declared globally, BIG MISTAKE, MULTIPLIED EVENTLISTENERS.. EVENT LISTERNS
        // SHOULD BE DECLARED LOCALLY 
    // Read the data from the form fields.
    var search = document.getElementById("search").value;
    
    // Specify the CALLBACK function. 
    // When we get a response from the server, the callback function will run
    xhr2.addEventListener ("load", responseReceived);
    // Open the connection to the server
    // We are sending a request to "flights.php" and passing in the 
    // destination and date as a query string. 
    xhr2.open('GET', 'searchresults.php?search='+search);
    
    // Send the request.
    xhr2.send();
}



function showShelves(){
    document.getElementById("shelves").style.display='block';
    var xhr2 = new XMLHttpRequest();
    xhr2.addEventListener("load", responseShelves);
    xhr2.open('GET', 'shelves.php');
    xhr2.send();
}
function hideShelves(){
    document.getElementById("shelves").style.display='none';
}



function basketOnLoad(){
    // Create the XMLHttpRequest variable.
    var xhr2 = new XMLHttpRequest();
    // This variable represents the AJAX communication between client and
    // server.
        //var xhr2 = new XMLHttpRequest(); -- now declared globally, BIG MISTAKE, MULTIPLIED EVENTLISTENERS.. EVENT LISTERNS
        // SHOULD BE DECLARED LOCALLY 
    // Read the data from the form fields.
    
    // Specify the CALLBACK function. 
    // When we get a response from the server, the callback function will run
    xhr2.addEventListener ("load", responseAlert);
    // Open the connection to the server
    // We are sending a request to "flights.php" and passing in the 
    // destination and date as a query string. 
    xhr2.open('GET', 'basketonload.php');
    // Send the request.
    xhr2.send();
}


//add to basket function
function atb(id){
    var xhr2 = new XMLHttpRequest();
    var qty = document.getElementById('qty'+id).value;
    var agelimit = parseInt(document.getElementById('agelimit'+id).innerHTML);
     //use innerHTML to target values in html
    console.log(agelimit);
    xhr2.open('GET', 'basket.php?ID='+id+'&qty='+qty+'&agelimit='+agelimit);
    //console.log(id,qty); uncomment to see if values are being passed through
    xhr2.addEventListener ("load", responseAlert);
    xhr2.send(); 
}

//remove from basket function
function rfb(id){
    //console.log(id);  //uncomment to see if values are being passed through
    var xhr2 = new XMLHttpRequest();
    xhr2.open('GET', 'removefb.php?ID='+id);
    xhr2.addEventListener ("load", responseAlert);
    xhr2.send(); 
}

function sendRating(id,rating) {
        console.log(id,rating);
        var xhr2 = new XMLHttpRequest();
        xhr2.addEventListener ("load", responseRating);
        xhr2.open('GET', 'ratings.php?rating='+rating+'&ID='+id);
        xhr2.send();
}

// The callback function
// It simply places the response from the server in the div with the ID
// of 'response'.

// The parameter "e" contains the original XMLHttpRequest variable as
// "e.target".
// We get the actual response from the server as "e.target.responseText"
function responseReceived(e){
    document.getElementById('response').innerHTML = e.target.responseText;
}
function responseRating(e){
    document.getElementById('response').innerHTML = e.target.responseText;
    ajaxrequest();
}
function responseAlert(e){
    document.getElementById('basket').innerHTML = e.target.responseText;
    ajaxrequest();
}

function responseShelves(e){
    document.getElementById('shelves').innerHTML = e.target.responseText;
}

//purchase modal below

var purchase = document.querySelector('#purchase');
    var backdrop = document.querySelector('.backdrop');
    var modal = document.querySelector('.modal');

function openModal(){
    backdrop.style.display = 'block';
    modal.style.display = 'block';
}

