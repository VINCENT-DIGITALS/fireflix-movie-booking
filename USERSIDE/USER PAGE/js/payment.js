window.onload = display();
let quantity = 0;

function display() {

  let localdata = localStorage.getItem('productsdata');
  let data = JSON.parse(localdata);
  console.log(data);


  let localdata2 = localStorage.getItem('cart');
  let data2 = JSON.parse(localdata2);
  console.log(data2);

  document.getElementById("cartcount").innerHTML = data2.reduce((acc, d) => acc + d.quantity, 0);

  data2.map((d) => {
    document.getElementById("name").innerHTML += d.name + '<br><br>'
    document.getElementById("quantity").innerHTML += d.quantity + '<br><br>'
    document.getElementById("price").innerHTML += d.price + '<br><br>'
    document.getElementById("amount").innerHTML += d.price * d.quantity + '<br><br>'
  })

  document.getElementById("total").innerHTML = data2.reduce((acc, v) => acc + (v.price * v.quantity), 0);

}

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  window.addEventListener('load', function () {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation')

    // Loop over them and prevent submission
    Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
  }, false)
}())
