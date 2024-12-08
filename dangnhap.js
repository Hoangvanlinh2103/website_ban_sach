let btnf1 = document.getElementById('switch-btn1');
let btnf2 = document.getElementById('switch-btn2');
let login_form = document.getElementById('login-form');
let reg_form = document.getElementById('reg-form');
let btnLogout = document.getElementById('btnLogout');

btnf1.onclick = function() {
   login_form.style.display = 'none';
   reg_form.style.display = 'block';
}

//nút chuyển
btnf2.onclick = function() {
    
    reg_form.style.display = 'none';
    login_form.style.display = 'block';

}

// Hàm kiểm tra email hợp lệ
function validateEmail(email) {
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return regex.test(email);
}

// Hàm kiểm tra khi submit form đăng ký
document.querySelector("form[action='dangnhap.php?action=2']").addEventListener("submit", function(event) {
    const email = document.getElementById("usernameR").value;

    if (!validateEmail(email)) {
        alert("Vui lòng nhập địa chỉ email hợp lệ.");
        event.preventDefault(); // Ngừng submit form nếu email không hợp lệ
    }
});








