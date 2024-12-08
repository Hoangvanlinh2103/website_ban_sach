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
    if (name === 'taikhoan') {
        document.getElementById('dstaikhoan').style.display = 'block';
    }else if (name === 'nxb') {
        document.getElementById('dsnxb').style.display = 'block';
    }else if (name === 'nhanvien') {
        document.getElementById('dsnhanvien').style.display = 'block';
    } else if (name === 'khachhang') {
        document.getElementById('dskhachhang').style.display = 'block';
    } else if (name === 'sach') {
        document.getElementById('dssach').style.display = 'block';
    } else if (name === 'donhangxuat') {
        document.getElementById('dsdonhangxuat').style.display = 'block';
    } else if (name === 'dathang') {
        document.getElementById('dsdathang').style.display = 'block';
    }else if (name === 'donhangnhap') {
        document.getElementById('dsdonhangnhap').style.display = 'block';
    }else if (name === 'khuyenmai') {
        document.getElementById('dskhuyenmai').style.display = 'block';
    }else if (name === 'gdbanhang') {
        document.getElementById('dsgdbanhang').style.display = 'block';
    }else if (name === 'gdnhaphang') {
        document.getElementById('dsgdnhaphang').style.display = 'block';
    }else if (name === 'tkbanchay') {
        document.getElementById('dstkbanchay').style.display = 'block';
    }
    else if (name === 'tksachsaphet') {
        document.getElementById('dstksachsaphet').style.display = 'block';
    }
    else if (name === 'tksachkhuyenmai') {
        document.getElementById('dstksachkhuyenmai').style.display = 'block';
    }
    else if (name === 'tktienbieudo') {
        document.getElementById('dstktienbieudo').style.display = 'block';
    }
    else if (name === 'tktienthangbieudo') {
        document.getElementById('dstktienthangbieudo').style.display = 'block';
    }
    else if (name === 'chamcong') {
        document.getElementById('dschamcong').style.display = 'block';
    }
    else if (name === 'luong') {
        document.getElementById('dsluong').style.display = 'block';
    }
    
    // Ẩn tất cả các phần tử không liên quan
    const elementsToHide = ['dstaikhoan', 'dsnxb', 'dsnhanvien', 'dskhachhang', 'dssach', 'dsdonhangxuat', 'dsdonhangnhap','dskhuyenmai','dsgdbanhang','dsgdnhaphang','dstkbanchay','dstksachsaphet','dstksachkhuyenmai','dstktienbieudo','dstktienthangbieudo','dschamcong','dsluong' ,'dsdathang'];
    elementsToHide.forEach(id => {
        if (id !== `ds${name}`) {
            document.getElementById(id).style.display = 'none';
        }
    });
    
    // Xóa tham số URL
    const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
    window.history.replaceState({ path: newUrl }, '', newUrl);
});