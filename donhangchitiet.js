document.addEventListener("DOMContentLoaded", function() {
    // Lấy URL hiện tại
    const urlParams = new URLSearchParams(window.location.search);
    
    // Lấy giá trị của tham số name
    const name = urlParams.get('name');
    console.log("name:", name);  // Kiểm tra giá trị của name
    
    // Kiểm tra và xử lý tham số name
    if (name === 'donhang') {
        document.getElementById('dsdonhang').style.display = 'block';
    } else if (name === 'donhangnhap') {
        document.getElementById('dsdonhangnhap').style.display = 'block';
    }
    else if (name === 'khuyenmai') {
        document.getElementById('dskhuyenmai').style.display = 'block';
    }
    
    // Ẩn tất cả các phần tử không liên quan
    const elementsToHide = ['dsdonhang', 'dsdonhangnhap','dskhuyenmai'];
    elementsToHide.forEach(id => {
        if (id !== `ds${name}`) {
            document.getElementById(id).style.display = 'none';
        }
    });
    
});