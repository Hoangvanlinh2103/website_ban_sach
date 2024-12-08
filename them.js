// Lấy ngày hiện tại
const currentDate = new Date();

// Định dạng ngày theo kiểu yyyy-mm-dd
const formattedDate = currentDate.toISOString().split('T')[0];

// Gán giá trị ngày hiện tại vào input
document.getElementById('currentDate').value = formattedDate;


// Hàm để bật tắt menu con
function toggleSubmenu(menuItem) {
    // Xóa class 'active' của các mục khác để chỉ mở submenu của một mục
    var allMenuItems = document.querySelectorAll('.menu-item');
    allMenuItems.forEach(function(item) {
        if (item !== menuItem) {
            item.classList.remove('active');
        }
    });

    // Bật tắt submenu cho menu hiện tại
    menuItem.classList.toggle('active');
}
const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const themeToggler = document.querySelector(".theme-toggler");

menuBtn.addEventListener('click',() => {
    sideMenu.style.display = 'block';
})

closeBtn.addEventListener('click',() => {
    sideMenu.style.display = 'none';
})

// đổi màu
themeToggler.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme-variables');

    themeToggler.querySelector('span:nth-child(1)').classList.toggle('active')
    themeToggler.querySelector('span:nth-child(2)').classList.toggle('active')
})


document.addEventListener("DOMContentLoaded", function() {
    // Lấy URL hiện tại
    const urlParams = new URLSearchParams(window.location.search);
    
    // Lấy giá trị của tham số name
    const name = urlParams.get('name');
    console.log("name:", name);  // Kiểm tra giá trị của name
    
    // Kiểm tra và xử lý tham số name
    if (name == 'taikhoan') {
        document.getElementById('dstaikhoan').style.display = 'block';
    }else if (name == 'nxb') {
        document.getElementById('dsnxb').style.display = 'block';
    }else if (name == 'nhanvien') {
        document.getElementById('dsnhanvien').style.display = 'block';
    } else if (name == 'khachhang') {
        document.getElementById('dskhachhang').style.display = 'block';
    } else if (name == 'sach') {
        document.getElementById('dssach').style.display = 'block';
    } else if (name == 'donhangxuat') {
        document.getElementById('dsdonhangxuat').style.display = 'block';
    } else if (name == 'donhangnhap') {
        document.getElementById('dsdonhangnhap').style.display = 'block';
    }else if (name == 'dathang') {
        document.getElementById('dsdathang').style.display = 'block';
    }else if (name == 'themDHCT') {
        document.getElementById('dsthemDHCT').style.display = 'block';
    }
    else if (name == 'themNhapDHCT') {
        document.getElementById('dsthemNhapDHCT').style.display = 'block';
    }
    else if (name == 'khuyenmai') {
        document.getElementById('dskhuyenmai').style.display = 'block';
    }
    
    // Ẩn tất cả các phần tử không liên quan
    const elementsToHide = ['dstaikhoan', 'dsnxb', 'dsnhanvien', 'dskhachhang', 'dssach', 'dsdonhangxuat','dsdonhangnhap','dskhuyenmai', 'dsthemDHCT','dsthemNhapDHCT', 'dsdathang'];
    elementsToHide.forEach(id => {
        if (id !== `ds${name}`) {
            document.getElementById(id).style.display = 'none';
        }
    });
    
    // Xóa tham số URL
    const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
    window.history.replaceState({ path: newUrl }, '', newUrl);
});


document.querySelectorAll('#dsdonhangxuat #add-product-btn, #dsthemDHCT #add-product-btn').forEach(function (button) {
    button.addEventListener('click', function () {
        // Xác định form cha của nút đang được nhấn
        const form = button.closest('form');
        const container = form.querySelector('#product-container');

        // Tạo phần tử mới cho sản phẩm
        const newProductItem = document.createElement('div');
        newProductItem.className = 'form-group product-item';

        // Lấy danh sách các sách từ PHP (truyền qua biến JavaScript)
        let options = '';
        dssach.forEach(function (sach) {
            options += `<option value="${sach.masach}">${sach.tensach}</option>`;
        });

        // HTML cho phần tử mới
        newProductItem.innerHTML = `
            <label>Tên Sách</label>
            <select name="mas[]" required>
                ${options}
            </select>
            <label>Số Lượng</label>
            <input type="text" name="soluong[]" placeholder="Nhập số lượng" required>
        `;

        container.appendChild(newProductItem);
    });
});



document.querySelectorAll('#add-donhang_nhap-btn').forEach(function (button) {
    button.addEventListener('click', function () {
        // Xác định form cha của nút bấm
        const form = button.closest('form');
        const container = form.querySelector('#donhang_nhap-container');

        // Tạo một phần tử mới để thêm sản phẩm
        const newdonhang_nhapItem = document.createElement('div');
        newdonhang_nhapItem.className = 'form-group donhang_nhap-item';

        // Tạo các tùy chọn cho danh sách sách
        let options = "";
        dssach.forEach(function (sach) {
            options += `<option value="${sach.masach}">${sach.tensach}</option>`;
        });

        // Nội dung HTML cho sản phẩm mới
        newdonhang_nhapItem.innerHTML = `
            <label>Tên sách</label>
            <select name="mas[]" required>
                ${options}
            </select>
            <label>Số Lượng</label>
            <input type="text" name="soluong[]" placeholder="Nhập số lượng" required>
            <label>Giá nhập</label>
            <input type="text" name="gianhap[]" placeholder="Nhập giá nhập về" required>
            <label>Ghi chú</label>
            <input type="text" name="ghichu[]" placeholder="Nhập ghi chú về sách" value="Nhập hàng" required>
        `;

        // Thêm phần tử mới vào container
        container.appendChild(newdonhang_nhapItem);
    });
});


  
document.getElementById("add-sach-btn").addEventListener("click", function () {
    // Lấy phần tử container sản phẩm
    const container = document.getElementById("product-tuychon-container");
  
    // Tạo một phần tử mới để thêm sản phẩm
    const newProductItem = document.createElement("div");
    newProductItem.className = "form-group product-item";
  
    let options = "";
    dssach.forEach(function (sach) {
      options += `<option value="${sach.masach}">${sach.tensach}</option>`;
    });
  
    // Thêm HTML vào phần tử mới
    newProductItem.innerHTML = `
      <label for="">Chọn sách:</label>
              <select name="sachtuychon[]" required>
                  ${options}
              </select>
              <label for="">Phần trăm khuyến mãi:</label>
              <input type="number" name="ptkm_tuychon[]" min="0" max="100" required>
    `;
  
    // Thêm phần tử mới vào container
    container.appendChild(newProductItem);
  });






