function calculate(){
    var myForm = document.forms.cart;
    var products = myForm.elements[('product')];
    console.log(products);
    var total = 0;
    for(var index in products) {
        var price = products[index]['price'];
        var quantity = products[index]['quantity'];
        var totPerProduct = quantity*price;
        total += totPerProduct;
    }
    result.innerHTML = total;
}