@extends('layouts.admin')

@section('title', 'Bảng điều khiển')
@section('page_title', 'Hệ thống quản trị tổng quan')

@push('styles')
    @vite(['resources/css/admin/layout.css', 'resources/css/admin/dashboard.css'])
@endpush

@section('content')
    
    <div class="stats-overview-grid">
        <div class="stat-metric-card">
            <div class="metric-label">Tổng doanh thu</div>
            <div class="metric-value" style="color: #059669;">
                {{ number_format($totalRevenue, 0, ',', '.') }} đ
            </div>
        </div>
        <div class="stat-metric-card">
            <div class="metric-label">Khách hàng</div>
            <div class="metric-value">{{ $totalCustomers }} thành viên</div>
        </div>
        <div class="stat-metric-card">
            <div class="metric-label">Tổng đơn đặt</div>
            <div class="metric-value">{{ $totalBookings }} đơn hàng</div>
        </div>
        <div class="stat-metric-card">
            <div class="metric-label">Số lượng xe</div>
            <div class="metric-value">{{ $totalCars }} chiếc</div>
        </div>
    </div>

    <div class="dashboard-charts-grid">
        
        <div class="chart-wrapper-card">
            <h3>Doanh thu theo ngày (7 ngày gần nhất)</h3>
            <canvas id="revenueChart" height="280"></canvas>
        </div>

        <div class="chart-wrapper-card">
            <h3>Lượng khách hàng mới theo ngày</h3>
            <canvas id="customerChart" height="280"></canvas>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = {!! json_encode($chartLabels) !!};
        const revenueData = {!! json_encode($revenueData) !!};
        const customerData = {!! json_encode($customerData) !!};

        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (đ)',
                    data: revenueData,
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30, 58, 138, 0.1)',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        const ctxCustomer = document.getElementById('customerChart').getContext('2d');
        new Chart(ctxCustomer, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Khách hàng đăng ký mới',
                    data: customerData,
                    backgroundColor: '#3b82f6',
                    borderRadius: 6,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    </script>
@endsection