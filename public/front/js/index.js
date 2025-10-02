document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".category-link").forEach(link => {
      link.addEventListener("click", function(event) {
        event.preventDefault();
        let category = this.getAttribute("data-category");

        fetch(`/get-products/${category}`)
          .then(response => response.json())
          .then(products => {
            let categorySection = document.getElementById("category-section");
            let selectedCategory = document.getElementById("selected-category");
            let categoryProducts = document.getElementById("category-products");

            if (products.length === 0) {
              categorySection.style.display = "none";
            } else {
              selectedCategory.innerText = category;
              categorySection.style.display = "block";
              categoryProducts.innerHTML = "";

              products.forEach(product => {
                let productHtml = `
                  <div class="col-sm-6 col-lg-4 text-center item mb-4">
                      ${product.old_price ? '<span class="tag">خصم</span>' : ''}
                      <a href="/shop-single/${product.id}">
                          <img src="${product.image ? product.image : '/front/images/default.jpg'}" alt="Image">
                      </a>
                      <h3 class="text-dark">
                          <a href="/shop-single/${product.id}">${product.name}</a>
                      </h3>
                      <p class="price">
                          ${product.old_price ? `<del>$${product.old_price}</del> &mdash;` : ''}
                          $${product.price}
                      </p>
                  </div>
                `;
                categoryProducts.innerHTML += productHtml;
              });

              // التمرير إلى القسم بعد تحديث المنتجات
              categorySection.scrollIntoView({
                behavior: "smooth",
                block: "start"
              });
            }
          })
          .catch(error => console.error("حدث خطأ:", error));
      });
    });
  });