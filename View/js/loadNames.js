function loadNames() {
    var text = document.getElementById("search-names").value;
    if(text.length > 0){
        fetch('autoLoadService.php?text='+text)
            .then(function(response) {
                return response.json();
            })
            .then(function(myJson) {
                var autoComplete = document.getElementById("autoComplete");
                onqdiv.innerHTML = "";
                onqdiv.style.display = "block";
                for(var i = 0; i < myJson.length; i++){
                    autoComplete.innerHTML += myJson[i] + "<br>";
                }
            });
    }
    else{
        var autoComplete = document.getElementById("autoComplete");
        autoComplete.innerHTML = "";
        autoComplete.style.display = "none";
    }
}