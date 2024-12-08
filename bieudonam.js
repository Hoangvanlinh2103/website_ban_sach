// Kiểm tra nếu dữ liệu có hợp lệ trước khi vẽ biểu đồ
if (window.months.length > 0 && window.revenues.length > 0) {
    // Lấy đối tượng canvas
    const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');

    // Khởi tạo biểu đồ
    const monthlyRevenueChart = new Chart(ctx, {
        type: 'bar',  // Biểu đồ cột
        data: {
            labels: window.months,  // Dữ liệu cho trục X (tháng)
            datasets: [{
                label: 'Doanh thu theo tháng',  // Tiêu đề cho biểu đồ
                data: window.revenues,  // Dữ liệu cho trục Y (doanh thu)
                backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Màu nền của các cột
                borderColor: 'rgba(75, 192, 192, 1)',  // Màu viền của các cột
                borderWidth: 1  // Độ rộng viền
            }]
        },
        options: {
            responsive: true,  // Đảm bảo biểu đồ phản hồi tốt trên các kích thước màn hình khác nhau
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tháng'  // Tiêu đề cho trục X
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
