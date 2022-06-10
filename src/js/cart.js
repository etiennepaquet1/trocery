const brands = ["Bingi", "Porto"];
const weights = ["250g", "", "", "500g"];

const table = document.getElementById("cart-table");

function updateTotal() {
  var numberOfItems = 0;

  document.querySelectorAll('.quantityInp').forEach(function(q) {
    numberOfItems += Number(q.value);
  });

  document.getElementById("numberOfItems").innerHTML = numberOfItems;

  var subtotal = 0;
  var priceTotals = document.getElementsByClassName("priceTotal");

  for (i = 0; i < priceTotals.length; i++) {
    var pTotal = priceTotals[i].innerText;
    if (pTotal) {
      subtotal += Number(pTotal.substring(1));
    }
  }

  document.getElementById("subtotal").innerHTML = "$" + subtotal;

  var qst = subtotal * 0.09975;
  var gst = subtotal * 0.05;
  var total = subtotal + qst + gst;

  document.getElementById("QST").innerHTML = "$" + qst.toFixed(2);
  document.getElementById("GST").innerHTML = "$" + gst.toFixed(2);
  document.getElementById("total").innerHTML = "$" + total.toFixed(2);
}

async function updateCart() {
  await fetch("/cart/getCart.php")
    .then(response => response.json())
    .then(dataPhp => dataPhp.forEach(function(key) {
      localStorage[key["name"] + "Cart"] = JSON.stringify({
        id: key["id"],
        price: key["price"],
        quantity: key["quantity"],
        brand: key["brand"],
        weight: key["weight"]
      });
    }));

    Object.keys(localStorage).forEach(function(key) {
      if (key.slice(-4) == "Cart") {
        var data = JSON.parse(localStorage[key]);

        var item = key.slice(0, -4) + " (" + brands[data.brand] + ", " + weights[data.weight] + ")";
        var price = data.price;
        var quantity = data.quantity;
        var priceTotal = price * quantity;

        var row = table.insertRow();

        var itemCell = row.insertCell();
        var priceCell = row.insertCell();
        var quantityCell = row.insertCell();
        var priceTotalCell = row.insertCell();

        itemCell.innerHTML = '<button class="remove"><b>X</b></button> ' + item;
        itemCell.className = "item";

        priceCell.innerHTML = "$" + price;
        priceCell.className = "price";

        quantityCell.innerHTML = '<input type="number" class="quantityInp" name="quantity" min="1" max="100" value="' + quantity + '">';
        quantityCell.className = "quantity";

        priceTotalCell.innerHTML = "$" + priceTotal;
        priceTotalCell.className = "priceTotal";
      }
    });

    const subtotalRow = table.insertRow();

    subtotalRow.insertCell().innerHTML = "Subtotal";
    subtotalRow.insertCell();
    subtotalRow.insertCell();

    subtotalCell = subtotalRow.insertCell();
    subtotalCell.innerHTML = "$0";
    subtotalCell.id = "subtotal";

    updateTotal();

    document.querySelectorAll('.remove').forEach(function(r) {
      r.onclick = async function() {
        var name = r.parentNode.innerText.split(' (')[0].substring(2) + "Cart";
        var data = JSON.parse(localStorage[name]);

        localStorage.removeItem(name);

        await fetch(`/cart/editCart.php?id=${data.id}&delete`);
        window.location.reload(true);
      };
    });

    document.querySelectorAll('.quantityInp').forEach(function(q) {
      q.onchange = function() {
        q.value = parseInt(q.value);
        if (q.value > 0) {
          var item = q.parentNode.parentNode.getElementsByClassName("remove")[0];
          var pTotal = q.parentNode.parentNode.getElementsByClassName("priceTotal")[0];
          var price = q.parentNode.parentNode.getElementsByClassName("price")[0];

          if (item) {
            var name = item.parentNode.innerText.split(' (')[0].substring(2) + "Cart";

            var data = JSON.parse(localStorage[name]);

            fetch(`/cart/editCart.php?id=${data.id}&quantity=${q.value}&brand=${data.brand}&weight=${data.weight}`);

            localStorage[name] = JSON.stringify({
              id: data.id,
              price: price.innerHTML.substring(1),
              quantity: q.value,
              brand: data.brand,
              weight: data.weight
            });

            pTotal.innerHTML = "$" + q.value * price.innerHTML.substring(1);
            updateTotal();
          }
        } else {
          q.value = 1;
        }

      };
    });
}

updateCart();
