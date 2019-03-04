
function loadNames() {
    var text = document.getElementById("input-products").value;
    if (text.length > 0) {
        fetch('?target=product&action=showAutoLoadNames', {
            method: 'POST',
            headers: {'Content-type': 'application/x-www-form-urlencoded'},
            body: 'text=' + text
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (myJson) {
                var autoComplete = document.getElementById("autoComplete");
                autoComplete.innerHTML = "";
                autoComplete.style.display = "block";
                for(var i = 0; i < myJson.length; i++){
                    autoComplete.innerHTML += "<a href='/profile' style='text-decoration: none'>"+myJson[i]+"</a><br>";
                }
            })
            .catch(function (e) {
                alert(e.message);
            })
    }
    else{
        var autoComplete = document.getElementById("autoComplete");
        autoComplete.innerHTML = "";
        autoComplete.style.display = "none";
    }
}

// function loadNames() {
//     var text = document.getElementById("input-products").value;
//     if(text.length > 0){
//         fetch('?target=product&action=showAutoLoadNames?text=' + text)
//             .then(function(response) {
//                 return response.json();
//             })
//             .then(function(myJson) {
//                 var autoComplete = document.getElementById("autoComplete");
//                 autoComplete.innerHTML = "";
//                 autoComplete.style.display = "block";
//                 for(var i = 0; i < myJson.length; i++){
//                     autoComplete.innerHTML += "<a href='/profile'>"+myJson[i]+"</a><br>";
//                 }
//             });
//     }
//     else{
//         var autoComplete = document.getElementById("autoComplete");
//         autoComplete.innerHTML = "";
//         autoComplete.style.display = "none";
//     }
// }