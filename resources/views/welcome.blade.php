{{-- login page --}}<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nexus Admin - Bootstrap Dashboard</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>



    <aside class="sidebar" id="sidebar">
        @include('layouts.sidebar')
    </aside>
    <!-- ============================================================
    MAIN CONTENT
    ============================================================ -->
    <main class="main-content">

        <!-- ===== NAVBAR ===== -->
        <nav class="navbar-top">
            <div class="row align-items-center g-3 w-100">
                <div class="col-auto d-flex align-items-center gap-3">
                    <button class="navbar-hamburger" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="navbar-greeting">
                        👋 Good morning, <strong>John</strong>
                    </div>
                </div>

            </div>
        </nav>

        <!-- ===== PAGE HEADER ===== -->
        <div class="page-header d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">
                    <i class="bi bi-calendar3"></i> Welcome back! Here's what's happening with your business today.
                </p>
            </div>
        </div>

        <!-- ===== STATS ===== -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-decoration"></div>
                    <div class="stat-icon"><i class="bi bi-currency-dollar"></i></div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value">$48,295</div>
                    <span class="stat-change up"><i class="bi bi-arrow-up"></i> +12.5%</span>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-decoration"></div>
                    <div class="stat-icon"><i class="bi bi-cart-check"></i></div>
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-value">1,284</div>
                    <span class="stat-change up"><i class="bi bi-arrow-up"></i> +8.2%</span>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-decoration"></div>
                    <div class="stat-icon"><i class="bi bi-people"></i></div>
                    <div class="stat-label">Active Users</div>
                    <div class="stat-value">3,842</div>
                    <span class="stat-change up"><i class="bi bi-arrow-up"></i> +23.1%</span>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-decoration"></div>
                    <div class="stat-icon"><i class="bi bi-star"></i></div>
                    <div class="stat-label">Conversion Rate</div>
                    <div class="stat-value">4.6%</div>
                    <span class="stat-change down"><i class="bi bi-arrow-down"></i> -0.8%</span>
                </div>
            </div>
        </div>

        <!-- ===== CONTENT GRID ===== -->
        <div class="row g-4 mb-4">
            <!-- Chart -->
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-head">
                        <h5>
                            <i class="bi bi-graph-up" style="color:var(--accent-1);margin-right:8px;"></i>
                            Weekly Revenue
                        </h5>
                        <button class="card-action"><i class="bi bi-three-dots"></i></button>
                    </div>
                    <div class="chart-bars">
                        <div class="d-flex flex-column flex-grow-1 h-100">
                            <div class="chart-bar"
                                style="height:45%;background:linear-gradient(180deg,#6c5ce7,#a29bfe);"></div>
                            <div class="chart-bar-label">Mon</div>
                        </div>
                        <div class="d-flex flex-column flex-grow-1 h-100">
                            <div class="chart-bar"
                                style="height:62%;background:linear-gradient(180deg,#6c5ce7,#a29bfe);"></div>
                            <div class="chart-bar-label">Tue</div>
                        </div>
                        <div class="d-flex flex-column flex-grow-1 h-100">
                            <div class="chart-bar"
                                style="height:38%;background:linear-gradient(180deg,#6c5ce7,#a29bfe);"></div>
                            <div class="chart-bar-label">Wed</div>
                        </div>
                        <div class="d-flex flex-column flex-grow-1 h-100">
                            <div class="chart-bar"
                                style="height:78%;background:linear-gradient(180deg,#6c5ce7,#a29bfe);"></div>
                            <div class="chart-bar-label">Thu</div>
                        </div>
                        <div class="d-flex flex-column flex-grow-1 h-100">
                            <div class="chart-bar"
                                style="height:55%;background:linear-gradient(180deg,#6c5ce7,#a29bfe);"></div>
                            <div class="chart-bar-label">Fri</div>
                        </div>
                        <div class="d-flex flex-column flex-grow-1 h-100">
                            <div class="chart-bar"
                                style="height:90%;background:linear-gradient(180deg,#00b894,#55efc4);"></div>
                            <div class="chart-bar-label">Sat</div>
                        </div>
                        <div class="d-flex flex-column flex-grow-1 h-100">
                            <div class="chart-bar"
                                style="height:70%;background:linear-gradient(180deg,#00b894,#55efc4);"></div>
                            <div class="chart-bar-label">Sun</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-head">
                        <h5>
                            <i class="bi bi-clock-history" style="color:var(--accent-2);margin-right:8px;"></i>
                            Recent Activity
                        </h5>
                        <button class="card-action"><i class="bi bi-three-dots"></i></button>
                    </div>
                    <div class="transaction-list">
                        <div class="transaction-item">
                            <div class="t-icon green"><i class="bi bi-arrow-down"></i></div>
                            <div class="flex-grow-1">
                                <div class="t-name">Payment from Stripe</div>
                                <div class="t-date">Today, 2:30 PM</div>
                            </div>
                            <div class="t-amount positive">+$1,240</div>
                        </div>
                        <div class="transaction-item">
                            <div class="t-icon purple"><i class="bi bi-arrow-up"></i></div>
                            <div class="flex-grow-1">
                                <div class="t-name">Refund to Customer #432</div>
                                <div class="t-date">Today, 1:15 PM</div>
                            </div>
                            <div class="t-amount negative">-$89.50</div>
                        </div>
                        <div class="transaction-item">
                            <div class="t-icon yellow"><i class="bi bi-arrow-down"></i></div>
                            <div class="flex-grow-1">
                                <div class="t-name">New Order #1289</div>
                                <div class="t-date">Today, 11:45 AM</div>
                            </div>
                            <div class="t-amount positive">+$345.00</div>
                        </div>
                        <div class="transaction-item">
                            <div class="t-icon red"><i class="bi bi-arrow-up"></i></div>
                            <div class="flex-grow-1">
                                <div class="t-name">Subscription Renewal</div>
                                <div class="t-date">Today, 9:20 AM</div>
                            </div>
                            <div class="t-amount negative">-$29.99</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== BOTTOM GRID ===== -->
        <div class="row g-4 mb-4">
            <!-- Progress -->
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-head">
                        <h5>
                            <i class="bi bi-pie-chart" style="color:var(--accent-3);margin-right:8px;"></i>
                            Project Progress
                        </h5>
                        <button class="card-action"><i class="bi bi-three-dots"></i></button>
                    </div>
                    <div class="progress-item">
                        <div class="progress-head">
                            <span>Website Redesign</span>
                            <span>78%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill purple" style="width:78%;"></div>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-head">
                            <span>Mobile App</span>
                            <span>45%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill green" style="width:45%;"></div>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-head">
                            <span>Marketing Campaign</span>
                            <span>92%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill yellow" style="width:92%;"></div>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-head">
                            <span>API Integration</span>
                            <span>33%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill orange" style="width:33%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Feed -->
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-head">
                        <h5>
                            <i class="bi bi-rss" style="color:var(--accent-4);margin-right:8px;"></i>
                            Live Feed
                        </h5>
                        <button class="card-action"><i class="bi bi-three-dots"></i></button>
                    </div>
                    <div class="activity-item">
                        <div class="a-dot green"></div>
                        <div class="flex-grow-1">
                            <div class="a-text"><strong>Sarah</strong> completed a new order</div>
                            <div class="a-time">2 min ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="a-dot purple"></div>
                        <div class="flex-grow-1">
                            <div class="a-text"><strong>Michael</strong> joined the team</div>
                            <div class="a-time">18 min ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="a-dot yellow"></div>
                        <div class="flex-grow-1">
                            <div class="a-text">System update <strong>v2.4.1</strong> deployed</div>
                            <div class="a-time">1 hour ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="a-dot red"></div>
                        <div class="flex-grow-1">
                            <div class="a-text"><strong>5</strong> new support tickets</div>
                            <div class="a-time">2 hours ago</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team -->
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-head">
                        <h5>
                            <i class="bi bi-people" style="color:var(--accent-1);margin-right:8px;"></i>
                            Team
                        </h5>
                        <button class="card-action"><i class="bi bi-three-dots"></i></button>
                    </div>
                    <div class="team-member">
                        <div class="tm-avatar a1">AK</div>
                        <div class="flex-grow-1">
                            <div class="tm-name">Alex Kim</div>
                            <div class="tm-role">Lead Designer</div>
                        </div>
                        <span class="tm-status online">Online</span>
                    </div>
                    <div class="team-member">
                        <div class="tm-avatar a2">MR</div>
                        <div class="flex-grow-1">
                            <div class="tm-name">Maya Rodriguez</div>
                            <div class="tm-role">Frontend Dev</div>
                        </div>
                        <span class="tm-status online">Online</span>
                    </div>
                    <div class="team-member">
                        <div class="tm-avatar a3">JT</div>
                        <div class="flex-grow-1">
                            <div class="tm-name">James Tan</div>
                            <div class="tm-role">Backend Dev</div>
                        </div>
                        <span class="tm-status offline">Offline</span>
                    </div>
                    <div class="team-member">
                        <div class="tm-avatar a4">LW</div>
                        <div class="flex-grow-1">
                            <div class="tm-name">Lisa Wong</div>
                            <div class="tm-role">Product Manager</div>
                        </div>
                        <span class="tm-status online">Online</span>
                    </div>
                    <div class="team-member">
                        <div class="tm-avatar a5">DP</div>
                        <div class="flex-grow-1">
                            <div class="tm-name">David Park</div>
                            <div class="tm-role">Data Analyst</div>
                        </div>
                        <span class="tm-status online">Online</span>
                    </div>
                </div>
            </div>
        </div>



        <!-- ===== FOOTER ===== -->
        <footer class="footer d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>&copy; 2026 <strong>Nexus</strong> — Crafted with <i class="bi bi-heart-fill"
                    style="color:var(--accent-4);font-size:12px;"></i></span>
            <ul class="footer-links">
                <li><a href="#">Privacy</a></li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">Support</a></li>
                <li><a href="#">Status</a></li>
            </ul>
        </footer>

    </main>

    <!-- ============================================================
    SCRIPTS
    ============================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('index.js') }}"></script>

</body>

</html>
