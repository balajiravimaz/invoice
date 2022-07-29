const add = document.getElementById("add");


let form = document.forms.invoice;

console.log(form.qty);

form.qty.oninput = calculate;
form.amt.oninput = calculate;

function calculate() {
    let qty = +form.qty.value;
    if (!qty) return;

    let amt = +form.amt.value;
    if (!amt) return;

    let itemtot = qty * amt;

    document.querySelector(".rate").textContent = itemtot;

}



// const inputs = [...document.querySelectorAll("input")]
// const reducer = (accumulator, currentValue) => accumulator + currentValue;

// const getTotal = () => {
//   const values = inputs.map(input => Number(input.value));
//   const total = values.reduce(reducer);
//   console.log(total);
// }

// inputs.forEach(input => input.addEventListener('input', getTotal));


// tbdy.addEventListener("change", function (e) {
//     let sum = e.target.value;
//     if (!isNaN(e.target.value)) {
//         sum = sum * Number.parseFloat(e.target.value);        
//         console.log(sum);
//     }        
// })


function removeTd(e) {
    e.target.parentElement.parentElement.remove();
}

add.addEventListener("click", function (e) {
    e.preventDefault();
    let tbody = document.querySelector("tbody");

    const tr = document.createElement("tr");
    const textarea = document.createElement("textarea");
    textarea.placeholder = "Enter item name";

    for (let i = 0; i <= 5; i++) {
        window['td' + i] = document.createElement("td");
    }


    const qty = document.createElement("input");
    qty.type = "number";
    qty.placeholder = "qty";
    qty.name="qty";
    qty.className = "qty";
    qty.value = "1";

    const amt = document.createElement("input");
    amt.type = "number";
    amt.placeholder = "Amount";
    amt.className = "amnt";
    amt.name="amt";

    form.qty.oninput = calculate;
    form.amt.oninput = calculate;

    const rate = document.createElement("span");
    rate.className = "rate";
    rate.textContent = "0.00";

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

})
// {/* <textarea name="" id="" cols="30" rows="10" placeholder="Enter items name"></textarea>
// </td>
// <td>
// <input type="number" placeholder="qty">
// </td>
// <td>
// <input type="text" placeholder="Rate">
// </td>
// <td>
// <input type="text" readonly>
// </td> */}