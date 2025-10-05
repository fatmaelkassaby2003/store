$(document).ready(function() {
    // عند كتابة المستخدم في مربع البحث
    $('#search-box').on('keyup', function() {
      let query = $(this).val().trim();

      if (query.length > 0) {
        $.ajax({
          url: "{{ route('search.products') }}",
          type: "GET",
          data: {
            query: query
          },
          dataType: "json", // نتوقع استجابة JSON
          success: function(data) {
            console.log("البيانات المستلمة:", data);
            let html = '<ul class="list-unstyled mb-0">';

            if (data.length > 0) {
              data.forEach(function(product) {
                if (product.id) {
                  html += `
                                  <li class="search-item" data-id="${product.id}">
                                      ${product.name}
                                  </li>
                              `;
                }
              });
            } else {
              html += '<li class="no-result">لا يوجد نتائج</li>';
            }
            html += '</ul>';

            $('#search-results').html(html).fadeIn();
          },
          error: function(err) {
            console.error("خطأ أثناء جلب نتائج البحث:", err);
          }
        });
      } else {
        $('#search-results').fadeOut();
      }
    });

    $(document).on('click', '.search-item', function(e) {
      e.preventDefault();
      let productId = $(this).attr('data-id');
      console.log("معرف المنتج المختار:", productId);

      if (!productId) {
        console.warn("معرف المنتج غير معرف.");
        return;
      }
      window.location.href = '{{ url("/shop/product") }}/' + productId;
    });
  });