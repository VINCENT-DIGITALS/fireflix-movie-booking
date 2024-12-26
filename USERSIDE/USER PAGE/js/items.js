const product = [{
    id: 0,
    image: '../images/1.png',
    title: 'Popcorn Solo',
    price: 70,
},
{
    id: 1,
    image: '../images/2.png',
    title: 'Popcorn Large',
    price: 110,
},
{
    id: 2,
    image: '../images/3.png',
    title: 'Popcorn Bucket',
    price: 150,
},
{
    id: 3,
    image: '../images/4.png',
    title: 'Regular Soda (500ml)',
    price: 50,
},
{
    id: 4,
    image: '../images/5.png',
    title: 'Large Soda (1L)',
    price: 70,
},
{
    id: 5,
    image: '../images/6.png',
    title: 'Bottle water (500ml)',
    price: 30,
},
{
    id: 6,
    image: '../images/7.png',
    title: 'Regular Fries',
    price: 30,
},
{
    id: 7,
    image: '../images/8.png',
    title: 'Donut',
    price: 35,
},


];
const categories = [...new Set(product.map((item) => {
return item
}))]
let i = 0;
document.getElementById('root').innerHTML = categories.map((item) => {
var {
    image,
    title,
    price
} = item;
return (
    `<div class='box'>
<div class='img-box'>
    <img class='images' src=${image}></img>
</div>
<div class='bottom'>
<p>${title}</p>
<h2>₱ ${price}.00</h2>` +
    "<button onclick='items(" + (i++) + ")'>Buy</button>" +
    `</div>
</div>`
)
}).join('')

var cart = [];

function items(a) {
cart.push({
    ...categories[a]
});
displaycart();
}

function delElement(a) {
cart.splice(a, 1);
displaycart();
}

function displaycart(a) {
let j = 0;
let total = 0;
document.getElementById("count").innerHTML = cart.length;
if (cart.length == 0) {
    document.getElementById('cartItem').innerHTML = "Your selection is empty.";
    document.getElementById("total").innerHTML = "₱" + 0 + ".00";
} else {
    document.getElementById("cartItem").innerHTML = cart.map((items) => {
        var {
            image,
            title,
            price
        } = items;
        total += price;
        document.getElementById("total").innerHTML = "₱ " + total + ".00";
        document.cookie = "passed_total="+total;
        return (
            `<div class='cart-item'>
    <div class='row-img'>
        <img class='rowimg' src=${image}>
    </div>
    <p style='font-size:12px; color:black;'>${title}</p>
    <h2 style='font-size: 15px;'>₱ ${price}.00</h2>` +
            "<i class='fa-solid fa-trash' onclick='delElement(" + (j++) + ")'></i></div>"
        );
    }).join('');
}

function sendData() {
    var data = {

    }
}
}