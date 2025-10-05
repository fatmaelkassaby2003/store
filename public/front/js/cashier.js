let products = JSON.parse(localStorage.getItem("products")) || [];
    let currentProduct = null;

    function saveToLocalStorage() {
        localStorage.setItem("products", JSON.stringify(products));
    }

    function fetchProductDetails() {
        let code = document.getElementById("productCode").value.trim();
        if (code.length < 3) return; 

        fetch(`/get-product/${code}`)
            .then(response => response.json())
            .then(product => {
                if (product) {
                    currentProduct = product;
                    document.getElementById("productName").value = product.name;
                    updateTotalPrice();
                } else {
                    currentProduct = null;
                    document.getElementById("productName").value = "";
                    document.getElementById("totalPrice").value = "";
                }
            })
            .catch(error => console.error("حدث خطأ في جلب البيانات:", error));
    }

    function updateTotalPrice() {
        let quantity = parseInt(document.getElementById("productQuantity").value);
        if (currentProduct && !isNaN(quantity) && quantity > 0) {
            let total = currentProduct.price * quantity;
            document.getElementById("totalPrice").value = total + " جنيه";
        } else {
            document.getElementById("totalPrice").value = "";
        }
    }

    function addProduct() {
        let code = document.getElementById("productCode").value.trim();
        let quantity = parseInt(document.getElementById("productQuantity").value);

        if (!currentProduct || isNaN(quantity) || quantity <= 0) {
            alert("يرجى إدخال بيانات صحيحة!");
            return;
        }

        let existingProduct = products.find(p => p.code === code);
        if (existingProduct) {
            existingProduct.quantity += quantity;
            existingProduct.totalPrice = existingProduct.price * existingProduct.quantity;
        } else {
            products.push({
                code,
                name: currentProduct.name,
                price: currentProduct.price,
                quantity,
                totalPrice: currentProduct.price * quantity
            });
        }

        saveToLocalStorage();
        updateProductList();
        document.getElementById("productCode").value = "";
        document.getElementById("productQuantity").value = 1;
        document.getElementById("productName").value = "";
        document.getElementById("totalPrice").value = "";
        currentProduct = null;
    }

    function updateProductList() {
        let list = document.getElementById("productList");
        list.innerHTML = "";
        products.forEach((p, i) => {
            let li = document.createElement("li");
            li.className = "product-item1";
            li.innerHTML = `
                <div class="product-info">${p.name} ← ${p.price} جنيه × ${p.quantity} = ${p.totalPrice} جنيه</div>
                <div class="actions">
                    <button class="btn-delete" onclick="removeProduct(${i})">❌</button>
                </div>
            `;
            list.appendChild(li);
        });
    }

    function increaseQuantity(index) {
        products[index].quantity++;
        products[index].totalPrice = products[index].price * products[index].quantity;
        saveToLocalStorage();
        updateProductList();
    }

    function decreaseQuantity(index) {
        if (products[index].quantity > 1) {
            products[index].quantity--;
            products[index].totalPrice = products[index].price * products[index].quantity;
        } else {
            products.splice(index, 1);
        }
        saveToLocalStorage();
        updateProductList();
    }

    function removeProduct(index) {
        products.splice(index, 1);
        saveToLocalStorage();
        updateProductList();
    }


    let shouldPrint = false;
    
    function syncTotalPrice() {
        let total = products.reduce((sum, p) => sum + p.totalPrice, 0);
        document.getElementById("hiddenTotalPrice").value = total;
    }

    function submitAndPrint(e) {
        e.preventDefault();
        syncTotalPrice();
        shouldPrint = true;
        
        // إرسال النموذج عبر AJAX
        fetch(document.getElementById('invoiceForm').action, {
            method: 'POST',
            body: new FormData(document.getElementById('invoiceForm'))
        })
        .then(response => {
            if (response.ok && shouldPrint) {
                printInvoice();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function printInvoice() {
        if (products.length === 0) {
            alert("القائمة فارغة، لا يوجد منتجات للطباعة!");
            return;
        }
    
        let invoiceContent = `
            <html>
            <head>
                <title>فاتورة البيع</title>
                <style>
                    body { font-family: Arial, sans-serif; text-align: right; direction: rtl; padding: 20px; }
                    h2 { text-align: center; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid black; padding: 8px; text-align: center; }
                    th { background-color: #f2f2f2; }
                </style>
            </head>
            <body>
                <h2>🧾 فاتورة البيع</h2>
                <table>
                    <thead>
                        <tr>
                            <th>اسم المنتج</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>`;
    
        let totalAmount = 0;
        products.forEach(p => {
            let total = p.price * p.quantity;
            totalAmount += total;
            invoiceContent += `
                        <tr>
                            <td>${p.name}</td>
                            <td>${p.price} جنيه</td>
                            <td>${p.quantity}</td>
                            <td>${total} جنيه</td>
                        </tr>`;
        });
    
        invoiceContent += `
                    </tbody>
                </table>
                <h3>الإجمالي الكلي: ${totalAmount} جنيه</h3>
                <script>
                    window.print();
                    setTimeout(() => window.close(), 5000);
                <\/script>
            </body>
            </html>`;
    
        let printWindow = window.open("", "", "width=800,height=600");
        printWindow.document.open();
        printWindow.document.write(invoiceContent);
        printWindow.document.close();
    
        localStorage.removeItem("products"); // مسح المنتجات بعد الطباعة
        products = [];
        updateProductList();
    }
    
    window.onload = updateProductList;