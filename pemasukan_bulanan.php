<?php
session_start();
require_once 'config.php';

// Proteksi: hanya ADMIN boleh melihat halaman ini
if (!isset($_SESSION['class']) || strtoupper($_SESSION['class']) !== 'ADMIN') {
    header('Location: index.php');
    exit();
}

// Ambil daftar anggota kelas 1KA25 dari DB
$class = '1KA25';
$users = [];
$stmt = $conn->prepare("SELECT id, name FROM users WHERE class = ? ORDER BY name");
if ($stmt) {
    $stmt->bind_param('s', $class);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res) $users = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemasukan Bulanan - PayClass</title>
    <style>
        body {
            margin: 0;
            background: #f5f6fa;
            font-family: Arial, Helvetica, sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #522780;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #522780;
        }
        .back-btn {
            padding: 10px 20px;
            background: #522780;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .back-btn:hover {
            background: #3d1f5c;
        }
        .controls {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        .controls label {
            font-weight: bold;
            font-size: 14px;
        }
        .controls select,
        .controls button {
            padding: 10px 15px;
            border: 1px solid #aaa;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }
        .controls select {
            min-width: 200px;
        }
        .controls button {
            background: #522780;
            color: #fff;
            border: none;
            font-weight: bold;
        }
        .controls button:hover {
            background: #3d1f5c;
        }
        .view-buttons {
            display: flex;
            gap: 10px;
        }
        .view-btn {
            padding: 8px 15px;
            background: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s;
        }
        .view-btn.active {
            background: #522780;
            color: #fff;
            border-color: #522780;
        }
        
        /* Tabel Styles */
        .month-section {
            margin-bottom: 20px;
        }
        .month-header {
            background: #522780;
            color: #fff;
            padding: 15px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .month-header:hover {
            background: #3d1f5c;
        }
        .month-header.collapsed::before {
            content: "▶ ";
        }
        .month-header.expanded::before {
            content: "▼ ";
        }
        .month-content {
            display: none;
            background: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .month-content.active {
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th {
            background: #f0f0f0;
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
            color: #333;
        }
        table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table input[type="number"],
        table input[type="text"] {
            width: 95%;
            padding: 6px;
            border: 1px solid #aaa;
            border-radius: 3px;
            font-size: 13px;
        }
        .subtotal {
            text-align: right;
            font-weight: bold;
            color: #2e7d32;
            margin-top: 10px;
            font-size: 16px;
        }
        .total-container {
            text-align: right;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 3px solid #522780;
        }
        .total-container div {
            font-size: 20px;
            font-weight: bold;
            color: #2e7d32;
        }
        .add-row-btn {
            padding: 8px 15px;
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            margin-top: 10px;
        }
        .add-row-btn:hover {
            background: #45a049;
        }
        .no-data {
            text-align: center;
            padding: 30px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>💰 Pemasukan Bulanan - Kelas 1KA25</h1>
        <button class="back-btn" onclick="window.location.href='admin_page.php'">⬅ Kembali</button>
    </div>

    <div class="controls">
        <div>
            <label for="monthFilter">Filter Bulan:</label>
            <select id="monthFilter" onchange="filterByMonth()">
                <option value="">-- Pilih Bulan --</option>
            </select>
        </div>
        <div class="view-buttons">
            <button class="view-btn active" onclick="switchView('filter')">📊 Filter View</button>
            <button class="view-btn" onclick="switchView('accordion')">📂 Semua Bulan</button>
        </div>
    </div>

    <!-- Filter View: Single Month -->
    <div id="filterView" style="display: block;">
        <table id="filterTable">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 50%;">Nama Anggota</th>
                    <th style="width: 45%;">Jumlah Pemasukan (Rp)</th>
                </tr>
            </thead>
            <tbody id="filterTableBody">
                <tr><td colspan="3" class="no-data">Pilih bulan untuk melihat data</td></tr>
            </tbody>
        </table>
        <div class="subtotal" id="filterSubtotal" style="display: none;">Subtotal: Rp 0</div>
    </div>

    <!-- Accordion View: All Months -->
    <div id="accordionView" style="display: none;" id="accordionContainer">
        <div id="monthAccordion"></div>
        <div class="total-container">
            <div>Total Pemasukan Setahun: <span id="totalYear">Rp 0</span></div>
        </div>
    </div>

</div>

<script>
    let pemasukanData = {}; // Format: { 'YYYY-MM': { 'user_id': amount, ... } }
    const currentYear = new Date().getFullYear();
    const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadPemasukanData();
        initMonthSelect();
        populateAccordion();
        
        // Refresh data setiap 2 detik (untuk sinkronisasi dari admin_page)
        setInterval(function() {
            const prevData = JSON.stringify(pemasukanData);
            loadPemasukanData();
            const currData = JSON.stringify(pemasukanData);
            if (prevData !== currData) {
                populateAccordion(); // Update accordion jika ada perubahan
                const monthKey = document.getElementById('monthFilter').value;
                if (monthKey) filterByMonth();
            }
        }, 2000);
    });

    // Load pemasukan data from localStorage
    function loadPemasukanData() {
        const saved = localStorage.getItem('pemasukanBulanan');
        if (saved) {
            pemasukanData = JSON.parse(saved);
        }
    }

    // Save pemasukan data to localStorage
    function savePemasukanData() {
        localStorage.setItem('pemasukanBulanan', JSON.stringify(pemasukanData));
    }

    // Initialize month select dropdown
    function initMonthSelect() {
        const select = document.getElementById('monthFilter');
        for (let m = 0; m < 12; m++) {
            const monthKey = `${currentYear}-${String(m + 1).padStart(2, '0')}`;
            const monthName = `${months[m]} ${currentYear}`;
            const opt = document.createElement('option');
            opt.value = monthKey;
            opt.textContent = monthName;
            select.appendChild(opt);
        }
    }

    // Filter pemasukan by month
    function filterByMonth() {
        const monthKey = document.getElementById('monthFilter').value;
        const tbody = document.getElementById('filterTableBody');
        const subtotalEl = document.getElementById('filterSubtotal');

        if (!monthKey) {
            tbody.innerHTML = '<tr><td colspan="3" class="no-data">Pilih bulan untuk melihat data</td></tr>';
            subtotalEl.style.display = 'none';
            return;
        }

        if (!pemasukanData[monthKey]) {
            pemasukanData[monthKey] = {};
        }

        tbody.innerHTML = '';
        let subtotal = 0;
        let rowNum = 1;

        const users = <?php echo json_encode($users); ?>;
        users.forEach(user => {
            const amount = pemasukanData[monthKey][user.id] || 0;
            subtotal += amount;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="text-align: center;">${rowNum++}</td>
                <td>${user.name}</td>
                <td style="text-align: right;">${amount > 0 ? amount.toLocaleString('id-ID') : '-'}</td>
            `;
            tbody.appendChild(row);
        });

        subtotalEl.textContent = `Subtotal: Rp ${subtotal.toLocaleString('id-ID')}`;
        subtotalEl.style.display = 'block';
    }

    // Update pemasukan amount
    function updateAmount(input) {
        const monthKey = input.getAttribute('data-month');
        const userId = input.getAttribute('data-user-id');
        const amount = parseInt(input.value) || 0;

        if (!pemasukanData[monthKey]) {
            pemasukanData[monthKey] = {};
        }

        if (amount > 0) {
            pemasukanData[monthKey][userId] = amount;
        } else {
            delete pemasukanData[monthKey][userId];
        }

        savePemasukanData();
        filterByMonth(); // Refresh subtotal
        populateAccordion(); // Update accordion
    }

    // Add row to filter view
    function addRowToFilter() {
        alert('Gunakan list anggota di atas untuk menambah pemasukan');
    }

    // Switch view
    function switchView(view) {
        const filterView = document.getElementById('filterView');
        const accordionView = document.getElementById('accordionView');
        const buttons = document.querySelectorAll('.view-btn');

        buttons.forEach(b => b.classList.remove('active'));

        if (view === 'filter') {
            filterView.style.display = 'block';
            accordionView.style.display = 'none';
            event.target.classList.add('active');
        } else {
            filterView.style.display = 'none';
            accordionView.style.display = 'block';
            event.target.classList.add('active');
        }
    }

    // Populate accordion with all months
    function populateAccordion() {
        const accordion = document.getElementById('monthAccordion');
        accordion.innerHTML = '';
        let totalYear = 0;

        for (let m = 0; m < 12; m++) {
            const monthKey = `${currentYear}-${String(m + 1).padStart(2, '0')}`;
            const monthName = `${months[m]} ${currentYear}`;

            const data = pemasukanData[monthKey] || {};
            let subtotal = 0;
            const users = <?php echo json_encode($users); ?>;
            
            users.forEach(user => {
                subtotal += data[user.id] || 0;
            });
            totalYear += subtotal;

            // Header
            const header = document.createElement('div');
            header.className = 'month-header collapsed';
            header.textContent = `${monthName} - Rp ${subtotal.toLocaleString('id-ID')}`;
            header.onclick = function() {
                const content = this.nextElementSibling;
                content.classList.toggle('active');
                this.classList.toggle('collapsed');
                this.classList.toggle('expanded');
            };
            accordion.appendChild(header);

            // Content
            const content = document.createElement('div');
            content.className = 'month-content';
            
            let html = '<table><thead><tr><th style="width:5%;">No</th><th style="width:50%;">Nama</th><th style="width:45%;">Rp</th></tr></thead><tbody>';
            let rowNum = 1;
            users.forEach(user => {
                const amount = data[user.id] || 0;
                html += `<tr><td>${rowNum++}</td><td>${user.name}</td><td style="text-align:right;">${amount > 0 ? amount.toLocaleString('id-ID') : '-'}</td></tr>`;
            });
            html += '</tbody></table>';
            html += `<div class="subtotal">Subtotal: Rp ${subtotal.toLocaleString('id-ID')}</div>`;
            
            content.innerHTML = html;
            accordion.appendChild(content);
        }

        document.getElementById('totalYear').textContent = `Rp ${totalYear.toLocaleString('id-ID')}`;
    }
</script>

</body>
</html>
