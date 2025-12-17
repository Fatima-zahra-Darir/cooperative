@extends('layouts.app')

@section('title', 'Dashboard - Co-op ERP')
@section('page-title', 'Dashboard Overview')

@section('content')
<style>
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .kpi-icon.blue {
        background: #dbeafe;
        color: #1e40af;
    }

    .kpi-icon.purple {
        background: #ede9fe;
        color: #6d28d9;
    }

    .kpi-icon.green {
        background: #d1fae5;
        color: #065f46;
    }

    .kpi-icon.orange {
        background: #fed7aa;
        color: #9a3412;
    }

    .kpi-content {
        flex: 1;
    }

    .kpi-label {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .kpi-value {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .kpi-change {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .kpi-change.positive {
        color: #059669;
    }

    .kpi-change.negative {
        color: #dc2626;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .chart-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .chart-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .chart-subtitle {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .chart-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d7a52;
    }

    .chart-container {
        height: 250px;
        position: relative;
    }

    .activity-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .activity-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1f2937;
    }

    .view-all-link {
        color: #2d7a52;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .view-all-link:hover {
        text-decoration: underline;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-description {
        font-size: 0.875rem;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .activity-time {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    .activity-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-system {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-review {
        background: #ede9fe;
        color: #6d28d9;
    }

    /* Simple chart styling */
    .line-chart {
        position: relative;
        width: 100%;
        height: 200px;
    }

    .bar-chart {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 200px;
        padding: 1rem 0;
    }

    .bar {
        width: 50px;
        background: #e5e7eb;
        border-radius: 4px 4px 0 0;
        transition: all 0.3s;
    }

    .bar:hover {
        opacity: 0.8;
    }

    .bar.active {
        background: #2d7a52;
    }

    .bar-label {
        text-align: center;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: #6b7280;
    }
</style>

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon blue">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
        </div>
        <div class="kpi-content">
            <div class="kpi-label">Total Stock</div>
            <div class="kpi-value">1,240 Units</div>
            <div class="kpi-change positive">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
                <span>+2%</span>
            </div>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon purple">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div class="kpi-content">
            <div class="kpi-label">Active Clients</div>
            <div class="kpi-value">342 Members</div>
            <div class="kpi-change positive">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
                <span>+5%</span>
            </div>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon green">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="kpi-content">
            <div class="kpi-label">Total Revenue</div>
            <div class="kpi-value">$45,200</div>
            <div class="kpi-change positive">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
                <span>+8.5%</span>
            </div>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon orange">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div class="kpi-content">
            <div class="kpi-label">Total Expenses</div>
            <div class="kpi-value">$12,400</div>
            <div class="kpi-change negative">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17l5-5m0 0l-5-5m5 5H6"></path>
                </svg>
                <span>-1.2%</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="charts-grid">
    <!-- Financial Overview Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title">Financial Overview</div>
                <div class="chart-subtitle">Revenue Growth (Jan - Dec)</div>
            </div>
            <div class="chart-value">$45,200</div>
        </div>
        <div class="chart-container">
            <canvas id="financialChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Operational Costs Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title">Operational Costs</div>
                <div class="chart-subtitle">Monthly Expenses</div>
            </div>
        </div>
        <div class="chart-container">
            <div class="bar-chart">
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                    <div class="bar" style="height: 60%;"></div>
                    <div class="bar-label">Jan</div>
                </div>
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                    <div class="bar" style="height: 70%;"></div>
                    <div class="bar-label">Feb</div>
                </div>
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                    <div class="bar" style="height: 65%;"></div>
                    <div class="bar-label">Mar</div>
                </div>
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                    <div class="bar active" style="height: 100%;"></div>
                    <div class="bar-label">Apr</div>
                </div>
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                    <div class="bar" style="height: 80%;"></div>
                    <div class="bar-label">May</div>
                </div>
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                    <div class="bar" style="height: 75%;"></div>
                    <div class="bar-label">Jun</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="activity-card">
    <div class="activity-header">
        <h2 class="activity-title">Recent Activity</h2>
        <a href="#" class="view-all-link">View All</a>
    </div>

    <div class="activity-list">
        <div class="activity-item">
            <div class="activity-avatar" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);">MJ</div>
            <div class="activity-content">
                <div class="activity-description">
                    <strong>Marcus Johnson</strong> paid invoice #INV-2023-001
                </div>
                <div class="activity-time">2 minutes ago</div>
            </div>
            <span class="activity-badge badge-completed">Completed</span>
        </div>

        <div class="activity-item">
            <div class="activity-avatar" style="background: linear-gradient(135deg, #6b7280 0%, #374151 100%);">S</div>
            <div class="activity-content">
                <div class="activity-description">
                    <strong>System</strong> updated stock for "Organic Seeds"
                </div>
                <div class="activity-time">15 minutes ago</div>
            </div>
            <span class="activity-badge badge-system">System</span>
        </div>

        <div class="activity-item">
            <div class="activity-avatar" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">SW</div>
            <div class="activity-content">
                <div class="activity-description">
                    <strong>Sarah Wilson</strong> requested a new membership
                </div>
                <div class="activity-time">1 hour ago</div>
            </div>
            <span class="activity-badge badge-pending">Pending</span>
        </div>

        <div class="activity-item">
            <div class="activity-avatar" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);">DC</div>
            <div class="activity-content">
                <div class="activity-description">
                    <strong>David Chen</strong> submitted expense report "Q3 Supplies"
                </div>
                <div class="activity-time">2 hours ago</div>
            </div>
            <span class="activity-badge badge-review">Review</span>
        </div>
    </div>
</div>

<script>
    // Simple line chart for Financial Overview
    const ctx = document.getElementById('financialChart');
    if (ctx) {
        const canvas = ctx.getContext('2d');
        const width = ctx.width;
        const height = ctx.height;
        
        // Draw axes
        canvas.strokeStyle = '#e5e7eb';
        canvas.lineWidth = 1;
        canvas.beginPath();
        canvas.moveTo(40, 20);
        canvas.lineTo(40, height - 30);
        canvas.lineTo(width - 20, height - 30);
        canvas.stroke();
        
        // Draw line chart
        canvas.strokeStyle = '#2d7a52';
        canvas.lineWidth = 3;
        canvas.beginPath();
        
        const points = [
            {x: 60, y: 150}, {x: 100, y: 140}, {x: 140, y: 130},
            {x: 180, y: 120}, {x: 220, y: 110}, {x: 260, y: 100},
            {x: 300, y: 90}, {x: 340, y: 85}, {x: 380, y: 80}
        ];
        
        canvas.moveTo(points[0].x, points[0].y);
        for (let i = 1; i < points.length; i++) {
            canvas.lineTo(points[i].x, points[i].y);
        }
        canvas.stroke();
        
        // Fill area under line
        canvas.fillStyle = 'rgba(45, 122, 82, 0.1)';
        canvas.beginPath();
        canvas.moveTo(points[0].x, height - 30);
        for (let i = 0; i < points.length; i++) {
            canvas.lineTo(points[i].x, points[i].y);
        }
        canvas.lineTo(points[points.length - 1].x, height - 30);
        canvas.closePath();
        canvas.fill();
        
        // Draw points
        canvas.fillStyle = '#2d7a52';
        points.forEach(point => {
            canvas.beginPath();
            canvas.arc(point.x, point.y, 4, 0, Math.PI * 2);
            canvas.fill();
        });
    }
</script>
@endsection
