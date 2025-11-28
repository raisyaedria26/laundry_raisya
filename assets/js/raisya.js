// // variable : let, var, const
// // php variable - $,define, const

// let nama = 'Reza Ibrahim';
// var name = 'Bambang Pamungkas';
// const fullname = 'Wahyudin Kamal';
// // const : tetap tidak boleh merubah nilai
// // document.write()
// // console.log({"nama" : name, "fullname" : fullname});
// // alert(nama);

// // operator
// let angka1 = 10;
// let angka2 = 5;
// console.log(angka1 + angka2);
// console.log(angka1 - angka2);
// console.log(angka1 / angka2);
// console.log(angka1 * angka2);
// console.log(angka1 % angka2);
// console.log(angka1 ** angka2);

// // operator penugasan
// let x = 10;
// x += 5; //15
// console.log(x);

// // operator perbandingan
// // >, <, =, ===, !==
// let a = 1;
// let b = 1;
// if (a === b) {
//   console.log('ya');
// } else {
//   console.log('tidak');
// }

// console.log(a > b);
// console.log(a < b);

// // operator logika
// // &&, AND, OR, ||, !: tidak  / not
// let umur = 20;
// let punyaSim = true;
// if (umur >= 17 && punyaSim) {
//   console.log('boleh mengemud');
// } else {
//   console.log('tidak boleh mengemud');
// }

// // array : sebuah tipe data yang memiliki nilainya lebih dari 1
// let buah = ['Pisang', 'Salak', 'Semangka'];

// console.log('buah di keranjang:', buah);
// console.log('saya mau buah :', buah[2]);
// buah[1] = 'Nanas';
// console.log('Buah baru:', buah);
// buah.push('Pepaya');
// console.log('Buah', buah);
// buah.pop();
// console.log('Buah', buah);

// // ->: php
// // .
// document.getElementById('product-title').innerHTML =
//   '<p>Data product di dalam element p</p>';
// // document.querySelector("#product-title")
// let btn = document.getElementsByClassName("category-btn");
// btn[0].style.color = 'red';
// btn[1].style.color = 'black';
// btn[2].style.color = 'brown';
// console.log('ini button', btn);
// let buttons = document.querySelectorAll(".category-btn");
// // buttons.forEach(function(btn) {});
// buttons.forEach((btn) => {
//     btn.style.color = "blue";
//   console.log(btn);
// });

// let card        = document.getElementById("card");
// let h3          = document.createElement("h3"); //<h3></h3></h3>
// let textH3      = document.createTextNode("Selamat Datang");
// h3.textContent  = "Selamat Datang dengan textcontent";

// let p = document.createElement("p");
// p.innerText     = "Duarr";
// p.textContent   = "Nuall jadi";
// // nambahin element di dalam card
// card.appendChild(h3);
// card.appendChild(p);
// // foreach($buttons as $btn){}

let currentCategory = "all";

function selectCustomers() {
  const select = document.getElementById("customer_id");
  const phone = select.options[select.selectedIndex].getAttribute("data-phone");

  document.getElementById("phone").value = phone || "";
}

function openModal(service) {
  document.getElementById("modal_id").value = service.id;
  document.getElementById("modal_name").value = service.name;
  document.getElementById("modal_price").value = service.price;
  document.getElementById("modal_qty").value = service.qty;
}

let cart = [];

function addToCart() {
  const id = document.getElementById("modal_id").value;
  const name = document.getElementById("modal_name").value;
  const price = parseFloat(document.getElementById("modal_price").value);
  const qty = parseFloat(document.getElementById("modal_qty").value);

  const existing = cart.find((item) => item.id == id);
  if (existing) {
    existing.qty += qty;
  } else {
    cart.push({
      id,
      name,
      price,
      qty,
    });
  }
  renderCart();
}

function renderCart() {
  const cartContainer = document.querySelector("#cartItems");
  cartContainer.innerHTML = "";

  if (cart.length === 0) {
    cartContainer.innerHTML = `<div class="cart-items" id="cartItems">
          <div class="text-center text-muted mt-5">
            <i class="bi bi-cart mb-3"></i>
            <p>Cart Empty</p>
          </div>
        </div>`;
    updateTotal();
  }
  cart.forEach((item, index) => {
    const div = document.createElement("div");
    div.className =
      "cart-item d-flex justify-content-between align-items-center mb-2";
    div.innerHTML = `
            <div>
            <strong>${item.name}</strong>  
            <small>${item.price}</small>  
          </div>
          <div class="d-flex align-items-center">
            <span>${item.qty}</span> 
            <button class="btn btn-sm btn-danger ms-3" onclick="removeItem(${item.id})">
              <i class="bi bi-trash"></i>
            </button>  
          </div>`;
    cartContainer.appendChild(div);
  });
  updateTotal();
  calculateChange();
}
//hapus item dari cart
function removeItem(id) {
  cart = cart.filter((p) => p.id != id);
  renderCart();
}
// mengatur qty di cart
function changeQty(id, x) {
  const item = cart.find((p) => p.id == id);
  if (!item) {
    return;
  }
  item.qty += x;
  if (item.qty <= 0) {
    alert("minuman harus 1 product");
    item.qty += 1;
    // cart = filter ((p) => p.id != id);
  }
  renderCart();
}
function updateTotal() {
  const qty = parseFloat(document.getElementById("modal_qty").value) || 0;
  const price = parseFloat(document.getElementById("modal_price").value) || 0;
  const subtotal = cart.reduce(
    (sum, item) => sum + parseFloat(item.price) * parseFloat(item.qty),
    0
  );
  const taxValue = document.querySelector(".tax").value;
  let tax = taxValue / 100;
  // console.log(tax);
  tax = subtotal * tax;
  const total = tax + subtotal;

  document.getElementById(
    "subtotal"
  ).textContent = `Rp. ${subtotal.toLocaleString()}`;
  document.getElementById("tax").textContent = `Rp. ${tax.toLocaleString()}`;
  document.getElementById(
    "total"
  ).textContent = `Rp. ${total.toLocaleString()}`;
  // console.log(subtotal);
  // console.log(tax);
  // console.log(total);

  document.getElementById("subtotal_value").value = subtotal;
  document.getElementById("tax_value").value = tax;
  document.getElementById("total_value").value = total;
}
document.getElementById("clearCart").addEventListener("click", function (e) {
  cart = [];
  renderCart();
});

async function processPayment() {
  if (cart.length === 0) {
    alert("Cart Masih Kosong");
    return;
  }
  const order_code = document.querySelector(".orderNumber").textContent.trim();
  const subtotal = document.querySelector("#subtotal_value").value.trim();
  const tax = document.querySelector("#tax_value").value.trim();
  const grandTotal = document.querySelector("#total_value").value.trim();
  const customer_id = parseInt(document.getElementById("customer_id").value);
  const end_date = document.getElementById("end_date").value;
  const order_pay = document.getElementById("pay").value;
  const order_change = document.getElementById("change").value;

  // console.log({ customer_id, end_date });
  try {
    const res = await fetch("add-order.php?payment", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        cart,
        order_code,
        subtotal,
        tax,
        grandTotal,
        customer_id,
        end_date,
        order_pay,
        order_change,
      }),
    });
    const data = await res.json();
    if (data.status == "success") {
      alert("Transaction success");
      window.location.href = "print.php?id=" + data.order_id;
    } else {
      alert("Transaction failed", data.message);
    }
    // const data = await res.json();
  } catch (error) {
    alert("Ups! Transaction failed!");
    console.log("error", error);
  }
}

function calculateChange() {
  const total = document.getElementById("total_value").value;
  const pay = parseFloat(document.getElementById("pay").value);

  const change = pay - total;
  if (change < 0) {
    change = 0;
  }
  document.getElementById("change").value = change;
}
// useEffect(() => {
// }, [])

// DomConterrLoaded   : akan meload function pertama kali
