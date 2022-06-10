const priceTxt = document.getElementById("price");
const productPrice = Number(priceTxt.innerText.substring(1));

const quantity = document.getElementById("quantity");
const brand = document.getElementById("brand");
const weight = document.getElementById("weight");

const productId = window.location.href.split("=")[1];
const product = document.getElementsByClassName("product-name")[0].innerText;

let store = JSON.parse(localStorage[product] || "{}");

function moreDescription() {
    document.getElementsByClassName('more-description-btn')[0].style.display = 'none';
    document.getElementsByClassName('more-description')[0].style.display = 'block';
}

function updatePrice() {
    var price =  Number(quantity.value) * (productPrice + Number(brand.value) + Number(weight.value));
    priceTxt.innerText = "$" + price;
}

async function addToCart() {
    localStorage[product + "Cart"] = JSON.stringify({
        id: productId,
        price: productPrice + Number(brand.value) + Number(weight.value),
        quantity: quantity.value,
        brand: brand.value,
        weight: weight.value
    });

    await fetch(`/cart/editCart.php?id=${productId}&quantity=${quantity.value}&brand=${brand.value}&weight=${weight.value}`);

    window.location = "/cart";
}

[quantity, brand, weight].forEach(inp => {
    inp.addEventListener("change", () => {
        updatePrice();
        store[inp.name] = inp.value;
        localStorage[product] = JSON.stringify(store);
    });

    if (inp.name in store) {
        inp.value = store[inp.name]
    }
});

window.addEventListener('load', function () {
    updatePrice();
})
