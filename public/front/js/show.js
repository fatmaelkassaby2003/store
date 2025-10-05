function openModal(id) {
    // إغلاق جميع النوافذ المفتوحة قبل فتح الجديدة
    document.querySelectorAll(".modal").forEach(modal => {
        modal.style.display = "none";
    });

    // فتح المودال المطلوب
    document.getElementById(id).style.display = "block";
}

// تجهيز أزرار فتح مودال الصورة
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".open-image-modal").forEach(button => {
        button.addEventListener("click", function() {
            let imageUrl = this.getAttribute("data-image");
            let productName = this.getAttribute("data-name");

            // إغلاق أي مودال مفتوح
            document.querySelectorAll(".modal").forEach(modal => {
                modal.style.display = "none";
            });

            // تحديث الصورة والعنوان وفتح المودال
            document.getElementById("modalImage").src = imageUrl;
            document.getElementById("modalImageTitle").innerText = productName;
            document.getElementById("productImageModal").style.display = "block";
        });
    });
});

function closeModal(id) {
    document.getElementById(id).style.display = "none";
}

// إغلاق أي مودال عند الضغط خارج المحتوى
document.querySelectorAll(".modal").forEach(modal => {
    modal.addEventListener("click", function(event) {
        if (event.target === modal) {
            closeModal(modal.id);
        }
    });
});