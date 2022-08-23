const add = document.getElementById("add");
const sub = document.getElementById("sub_total");
const tbdy = document.querySelector(".tbdy");
const tax_in = document.getElementById("tax_in");
const tax_val = document.getElementById("tax");
const total = document.getElementById("tot");


tax_in.addEventListener("change", function (e) {
    tax();
})
tbdy.addEventListener("change", function (e) {
    calculate(e);
});


function calculate(e) {
    let row = e.target.parentElement.parentElement;
    let qty = row.querySelector(".qty").value;
    if (!qty) return;
    let amt = row.querySelector(".amt").value;
    if (!amt) return;
    let result = row.querySelector(".rate");

    result.value = `${qty * amt}.00`;

    let sum = 0;
    document.querySelectorAll(".rate").forEach(items => {
        sum += +items.value;
        sub.value = `${sum}.00`;
        total.value = `${sum}.00`;
    })
    tax();
}

function addZeroes(num) {
    return num.toFixed(Math.max(((num + '').split(".")[1] || "").length, 2));
}


function tax() {
    // let tax = e.target.value;      
    let tax = tax_in.value;

    let sub_value = +sub.value;
    if (!sub_value) return;
    tax_val.value = addZeroes(sub_value * tax / 100);
    total.value = addZeroes(sub_value + Number.parseFloat(tax_val.value)).toLocaleString();
}

function removeTd(e) {
    e.target.parentElement.parentElement.remove();
    calculate(e);
    tax(e);
}

add.addEventListener("click", function (e) {
    e.preventDefault();
    let tbody = document.querySelector("tbody");

    const tr = document.createElement("tr");
    const textarea = document.createElement("textarea");
    textarea.placeholder = "Enter item name";
    textarea.name = "item[]";
    textarea.required = true;

    for (let i = 0; i <= 5; i++) {
        window['td' + i] = document.createElement("td");
    }


    const qty = document.createElement("input");
    qty.type = "number";
    qty.placeholder = "qty";
    qty.name = "qty[]";
    qty.className = "qty";
    qty.value = "1";
    qty.required = true;

    const amt = document.createElement("input");
    amt.type = "number";
    amt.placeholder = "Amount";
    amt.className = "amt";
    amt.name = "amt[]";
    amt.required = true;

    const rate = document.createElement("input");
    rate.className = "rate";
    rate.name = "rate[]";
    rate.value = "0.00";

    const btn = document.createElement("a");
    btn.innerHTML = "&times";
    btn.className = "close";

    btn.addEventListener("click", removeTd);

    td1.appendChild(textarea);
    td2.appendChild(qty);
    td3.appendChild(amt);
    td4.appendChild(rate);
    td5.appendChild(btn);

    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td4);
    tr.appendChild(td5);

    tbody.appendChild(tr);

    textarea.focus();

})

let name = items

document.querySelectorAll(".close").forEach(item => {
    item.addEventListener("click", function (e) {
        removeTd(e);
        let id = e.target.getAttribute("data-id");
        async function deleteItem() {
            const res = await fetch("delete_item.php", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            });

            const data = await res.text();
            console.log(data);
        }
        deleteItem();
    })
})