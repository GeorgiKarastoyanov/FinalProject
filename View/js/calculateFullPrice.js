function calculate(){
    var quantity = document.getElementById("quantity").value;
    var price = document.getElementById('price').value;
    var result = document.getElementById('result')
    result.innerHTML = quantity*price;
}