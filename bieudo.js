// Kiểm tra nếu dữ liệu có hợp lệ trước khi vẽ biểu đồ
if (window.days.length > 0 && window.revenues.length > 0) {
    // Tạo đối tượng canvas
    const ctx = document.getElementById('revenueChart').getContext('2d');

    // Khởi tạo biểu đồ
    const revenueChart = new Chart(ctx, {
        type: 'line',  // Loại biểu đồ là line
        data: {
            labels: window.days,  // Dữ liệu cho trục X (Ngày)
            datasets: [{
                label: 'Doanh thu theo ngày',  // Chú thích cho biểu đồ
                data: window.revenues,  // Dữ liệu cho trục Y (Doanh thu)
                borderColor: 'rgba(75, 192, 192, 1)',  // Màu của đường vẽ
                backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Màu nền của các điểm
                fill: true,  // Làm đầy khu vực dưới đường vẽ
                tension: 0.4  // Độ căng của đường (làm đường vẽ mềm mại hơn)
            }]
        },
        options: {
            responsive: true,  // Đảm bảo biểu đồ phản hồi tốt trên các kích thước màn hình khác nhau
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Ngày'  // Tiêu đề cho trục X
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Doanh thu'  // Tiêu đề cho trục Y
                    },
                    beginAtZero: true  // Bắt đầu trục Y từ 0
                }
            }
        }
    });
} else {
    console.error("Dữ liệu không hợp lệ hoặc trống!");
}
