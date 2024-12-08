

let selectedItems = new Set(); // Use a Set to track selected items
let total = 0; // Initialize total to zero

function updateTotal() {
    total = 0; // Reset total

    // Calculate the total for each selected item
    selectedItems.forEach(item => {
        const itemTotal = parseFloat(item.querySelector('.item-total').innerText.replace(/[^\d.-]/g, '')); // Get total from item's total span
        total += itemTotal; // Add to the overall total
    });

    // Update the displayed total price
    document.querySelector('.text-price').innerText = total.toLocaleString() + ' VNĐ'; // Format the total price
}

function selectItem(button, price) {
    const productCart = button.closest('.product_cart'); // Get the product container

    if (selectedItems.has(productCart)) {
        // If the item is already selected, deselect it
        selectedItems.delete(productCart);
        button.innerText = 'x'; // Change button text
        button.style.backgroundColor = ''; // Reset the background color
    } else {
        // If the item is not selected, select it
        selectedItems.add(productCart);
        button.innerText = '✓'; // Change button text to checkmark
        button.style.backgroundColor = 'lightgreen'; // Change the background color to indicate selection
    }

    updateTotal(); // Update the total price
}


function payment() {
    if (selectedItems.size === 0) {
        alert("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
        return;
    }

    // Collect selected items' details
    const selectedData = Array.from(selectedItems).map(item => {
        return {
            tensach: item.querySelector('.product-detail p:nth-child(1)').textContent.replace('Tên sách: ', '').trim(),
            soluong: parseInt(item.querySelector('.quantity-input').value.trim()),  // Lấy giá trị từ input
            giaban: parseInt(item.querySelector('.item-total').textContent.replace(/\D/g, '').trim())
        };
    });

    // Prepare form data to send to thanhtoan.php
    const form = document.createElement('form');
    form.method = 'post';
    form.action = 'payment.php';

    selectedData.forEach((data, index) => {
        Object.keys(data).forEach(key => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `${key}[]`; // Send array-like data
            input.value = data[key];
            form.appendChild(input);
        });
    });

    document.body.appendChild(form);
    form.submit(); // Submit the form
}

function deleteItem(button, bookName) {
    if (confirm("Bạn có chắc chắn muốn xóa sách " + bookName + " không?")) {
        // Tìm phần tử cha chứa thông tin sản phẩm
        const productCart = button.closest('.product_cart');
        
        // Tạo form động để gửi dữ liệu
        const form = document.createElement('form');
        form.method = 'post';
        form.action = 'removeproduct.php';
        
        // Thêm input ẩn cho tên sách
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'tensach';
        input.value = bookName;
        form.appendChild(input);

        // Đính kèm form vào body và gửi
        document.body.appendChild(form);
        form.submit();
    }
}

function redirectToUrl() {
    const select = document.getElementById("advanced-search-category-select");
    const bookname = document.getElementById("find-book").value.toLowerCase();
    const selectedValue = select.value;
    const minPrice = document.getElementById("min-price").value;
    const maxPrice = document.getElementById("max-price").value;

    // Start constructing the URL with the base URL
    let url = "giaodienkh.php?";

    // Append the book name if it's not empty
    if (bookname) {
        url += `book_name=${encodeURIComponent(bookname)}`;
    }

    // Append the selected category if one is selected
    if (selectedValue) {
        url += `&title=${decodeURIComponent(selectedValue)}`;
    }

    // Append the minimum price if it's not empty
    if (minPrice) {
        url += `&min_price=${encodeURIComponent(minPrice)}`;
    }

    // Append the maximum price if it's not empty
    if (maxPrice) {
        url += `&max_price=${encodeURIComponent(maxPrice)}`;
    }

    // Redirect to the constructed URL
    window.location.href = url;
}

function toggleAdvancedSearch(e) {
    e.preventDefault();
    const advancedSearch = document.querySelector(".advanced-search");
    if (advancedSearch) {
        advancedSearch.classList.toggle("open");
        document.getElementById("home-service").scrollIntoView();
    } else {
        console.error("Không tìm thấy phần tử .advanced-search");
    }
}


// Toggle the visibility of the rating section
const toggleButton = document.getElementById('toggle-rating-btn');
const ratingSection = document.getElementById('rating-section');

toggleButton.addEventListener('click', () => {
    ratingSection.style.display = ratingSection.style.display === 'none' ? 'block' : 'none';
});

// Star rating functionality
const stars = document.querySelectorAll('.star-rating .star');
let selectedRating = 0;

stars.forEach(star => {
    star.addEventListener('click', () => {
        // Get the value of the clicked star
        selectedRating = parseInt(star.getAttribute('data-value'));

        // Reset all stars to silver
        stars.forEach(s => s.classList.remove('gold'));

        // Set gold color for all stars up to the selected one
        for (let i = 0; i < selectedRating; i++) {
            stars[i].classList.add('gold');
        }
    });
});

document.querySelectorAll(".star-rating .star").forEach((star) => {
    star.addEventListener("click", () => {
        // Lấy giá trị của ngôi sao được chọn
        const value = parseInt(star.getAttribute("data-value"));

        // Reset tất cả các ngôi sao
        document.querySelectorAll(".star-rating .star").forEach((s) => {
            s.classList.remove("selected");
        });

        // Đánh dấu các ngôi sao từ 1 đến giá trị đã chọn
        for (let i = 0; i < value; i++) {
            document.querySelectorAll(".star-rating .star")[i].classList.add("selected");
        }

    });
});


function selectStar(starCount) {
    // Highlight stars up to the selected one
    const stars = document.querySelectorAll(".star-rating .star");
    stars.forEach((star, index) => {
        if (index < starCount) {
            star.classList.add("selected");
        } else {
            star.classList.remove("selected");
        }
    });
}

function submitReview() {
    const tensach = document.getElementById("tensach").innerText;
    const diemdanhgia = document.querySelectorAll(".star-rating .star.selected").length; // Count selected stars
    const noidung = document.getElementById("review-content").value;
    console.log(diemdanhgia);
    console.log(noidung);
    console.log(tensach);
    if (diemdanhgia === 0 || !noidung.trim()) {
        alert("Vui lòng chọn số sao và viết nội dung đánh giá!");
        return;
    }
    else{
        let url = "danhgiasach.php?";

   
        // Append the minimum price if it's not empty
        if (tensach) {
            url += `&tensach=${decodeURIComponent(tensach)}`;
        }
        // Append the minimum price if it's not empty
        if (diemdanhgia) {
            url += `&diemdanhgia=${decodeURIComponent(diemdanhgia)}`;
        }

        // Append the maximum price if it's not empty
        if (noidung) {
            url += `&noidung=${decodeURIComponent(noidung)}`;
        }
        // Redirect to the constructed URL
        window.location.href = url;
        };   // Gửi dữ liệu bằng AJAX
 
}

// Lưu số lượng sản phẩm trong giỏ hàng
function saveQuantity(button) {
    const productCart = button.closest('.product_cart'); // Lấy phần tử chứa sản phẩm
    const quantityInput = productCart.querySelector('.quantity-input'); // Lấy input số lượng
    const newQuantity = quantityInput.value; // Lấy giá trị số lượng mới
    const masach = button.closest('.product_cart').querySelector('.quantity-input').getAttribute('data-masach'); // Lấy mã sách từ data-masach

    if (newQuantity <= 0) {
        alert("Số lượng phải lớn hơn 0!");
        return;
    }

    // Gửi dữ liệu (mã sách và số lượng) lên server
    const form = document.createElement('form');
    form.method = 'post';
    form.action = 'giaodienkh.php?action=3'; // Đặt trang xử lý

    const masachInput = document.createElement('input');
    masachInput.type = 'hidden';
    masachInput.name = 'masach';
    masachInput.value = masach; // Thêm mã sách
    form.appendChild(masachInput);

    const quantityInputField = document.createElement('input');
    quantityInputField.type = 'hidden';
    quantityInputField.name = 'soluong';
    quantityInputField.value = newQuantity;
    form.appendChild(quantityInputField);

    document.body.appendChild(form);
    form.submit(); // Gửi form để cập nhật số lượng
}
document.addEventListener("DOMContentLoaded", () => {
    const starFilter = document.getElementById("star-filter");
    const reviewsContainer = document.getElementById("reviews-container");

    // Event listener for the star filter dropdown
    starFilter.addEventListener("change", () => {
        const selectedStar = starFilter.value; // Get the selected value

        // Get all review elements
        const reviews = reviewsContainer.querySelectorAll(".review");

        reviews.forEach(review => {
            const reviewStar = review.getAttribute("data-star");

            if (selectedStar === "" || reviewStar === selectedStar) {
                review.style.display = "block"; // Show the review
            } else {
                review.style.display = "none"; // Hide the review
            }
        });
    });
});


