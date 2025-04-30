<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include Composer's autoloader
$autoload_path = __DIR__ . '/../../vendor/autoload.php';
if (!file_exists($autoload_path)) {
    die("Autoloader not found at: $autoload_path. Please run 'composer require phpoffice/phpspreadsheet setasign/fpdi tecnickcom/tcpdf' in the project root (C:\\Users\\Leader.Din\\Desktop\\VC1-G3).");
}
require_once $autoload_path;

// Import required classes
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\Tcpdf\Fpdi;

// Database connection
$host = 'localhost';
$dbname = 'vc1_db';
$username = 'root'; // Replace with your MySQL username
$password = '';     // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Connection failed: " . $e->getMessage());
}

// Initialize data array
$data = [];
$report_period = $_GET['period'] ?? 'monthly'; // Default to monthly
$filters = $_POST ?? [];

// Determine date range based on period
$end_date = date('Y-m-d');
$start_date = '';
switch ($report_period) {
    case 'daily':
        $start_date = date('Y-m-d');
        break;
    case 'weekly':
        $start_date = date('Y-m-d', strtotime('-7 days'));
        break;
    case 'monthly':
    default:
        $start_date = date('Y-m-d', strtotime('-30 days'));
        break;
}

// Apply filters if submitted
$where = [];
if (!empty($filters['categories']) && !in_array('all', $filters['categories'])) {
    $where[] = "p.category_id IN (" . implode(",", array_map('intval', $filters['categories'])) . ")";
}
// Handle stock status filtering for the query
$status_conditions = [];
$selected_statuses = !empty($filters['stock_status']) ? $filters['stock_status'] : ['inStock', 'lowStock', 'outOfStock', 'overstock'];
if (!empty($filters['stock_status'])) {
    if (in_array('inStock', $filters['stock_status'])) $status_conditions[] = "(p.quantity > 0 AND p.quantity <= 50)";
    if (in_array('lowStock', $filters['stock_status'])) $status_conditions[] = "p.quantity < 10";
    if (in_array('outOfStock', $filters['stock_status'])) $status_conditions[] = "p.quantity = 0";
    if (in_array('overstock', $filters['stock_status'])) $status_conditions[] = "p.quantity > 50";
}
if (!empty($status_conditions)) {
    $where[] = "(" . implode(" OR ", $status_conditions) . ")";
}
$whereClause = !empty($where) ? " WHERE " . implode(" AND ", $where) : "";

// Fetch data from database
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total_products FROM products p" . $whereClause);
    $data['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'] ?? 0;

    $stmt = $pdo->query("SELECT SUM(price * quantity) as inventory_value FROM products p" . $whereClause);
    $data['inventory_value'] = $stmt->fetch(PDO::FETCH_ASSOC)['inventory_value'] ?? 0;

    $stmt = $pdo->query("SELECT COUNT(*) as low_stock_items FROM products p WHERE quantity < 10" . ($whereClause ? " AND " . str_replace("WHERE", "", $whereClause) : ""));
    $data['low_stock_items'] = $stmt->fetch(PDO::FETCH_ASSOC)['low_stock_items'] ?? 0;

    $stmt = $pdo->query("SELECT COUNT(*) as not_in_stock FROM products p WHERE quantity = 0" . ($whereClause ? " AND " . str_replace("WHERE", "", $whereClause) : ""));
    $data['not_in_stock'] = $stmt->fetch(PDO::FETCH_ASSOC)['not_in_stock'] ?? 0;

    $stmt = $pdo->query("SELECT COUNT(*) as overstocked_items FROM products p WHERE quantity > 50" . ($whereClause ? " AND " . str_replace("WHERE", "", $whereClause) : ""));
    $data['overstocked_items'] = $stmt->fetch(PDO::FETCH_ASSOC)['overstocked_items'] ?? 0;

    $stmt = $pdo->query("SELECT SUM(quantity) as total_out FROM stock_management WHERE stock_type = 'OUT' AND last_updated BETWEEN '$start_date' AND '$end_date'");
    $total_out = $stmt->fetch(PDO::FETCH_ASSOC)['total_out'] ?? 0;
    $stmt = $pdo->query("SELECT SUM(quantity) as total_stock FROM products p" . $whereClause);
    $total_stock = $stmt->fetch(PDO::FETCH_ASSOC)['total_stock'] ?? 1;
    $data['monthly_turnover'] = ($total_out / $total_stock) * 100;

    // Modified top_products query to respect selected stock statuses
    $stmt = $pdo->query("
        SELECT 
            p.product_id,
            p.name,
            p.price as unit_cost,
            p.quantity,
            (p.price * p.quantity) as total_value,
            CASE 
                WHEN p.quantity = 0 THEN 'Out of Stock'
                WHEN p.quantity < 10 THEN 'Low Stock'
                WHEN p.quantity > 50 THEN 'Overstock'
                ELSE 'In Stock'
            END as status
        FROM products p
        $whereClause
        ORDER BY (p.price * p.quantity) DESC
        LIMIT 10
    ");
    // Filter top_products to only include selected statuses
    $top_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['top_products'] = array_filter($top_products, function($product) use ($selected_statuses) {
        $status_map = [
            'In Stock' => 'inStock',
            'Low Stock' => 'lowStock',
            'Out of Stock' => 'outOfStock',
            'Overstock' => 'overstock'
        ];
        return in_array($status_map[$product['status']], $selected_statuses);
    });

    $stmt = $pdo->query("
        SELECT 
            s.supplier_name,
            COUNT(p.product_id) as product_count,
            SUM(p.price * p.quantity) as total_value
        FROM suppliers s
        LEFT JOIN products p ON p.supplier_id = s.supplier_id
        $whereClause
        GROUP BY s.supplier_id, s.supplier_name
        ORDER BY total_value DESC
        LIMIT 5
    ");
    $data['top_suppliers'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT name FROM products p $whereClause ORDER BY quantity DESC LIMIT 1");
    $data['top_recommendation'] = $stmt->fetch(PDO::FETCH_ASSOC) ?? ['name' => 'N/A'];

    // Fetch historical sales/provision data
    $stmt = $pdo->query("
        SELECT 
            DATE(last_updated) as period_date,
            SUM(quantity) as total_quantity,
            SUM(quantity * (SELECT price FROM products WHERE product_id = stock_management.product_id)) as total_value
        FROM stock_management
        WHERE stock_type = 'OUT' AND last_updated >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DATE(last_updated)
        ORDER BY period_date DESC
    ");
    $data['daily_history'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("
        SELECT 
            YEAR(last_updated) as year,
            WEEK(last_updated, 1) as week,
            SUM(quantity) as total_quantity,
            SUM(quantity * (SELECT price FROM products WHERE product_id = stock_management.product_id)) as total_value
        FROM stock_management
        WHERE stock_type = 'OUT' AND last_updated >= DATE_SUB(CURDATE(), INTERVAL 4 WEEK)
        GROUP BY YEAR(last_updated), WEEK(last_updated, 1)
        ORDER BY year DESC, week DESC
    ");
    $data['weekly_history'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("
        SELECT 
            DATE_FORMAT(last_updated, '%Y-%m') as period_date,
            SUM(quantity) as total_quantity,
            SUM(quantity * (SELECT price FROM products WHERE product_id = stock_management.product_id)) as total_value
        FROM stock_management
        WHERE stock_type = 'OUT' AND last_updated >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
        GROUP BY DATE_FORMAT(last_updated, '%Y-%m')
        ORDER BY period_date DESC
    ");
    $data['monthly_history'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("
        SELECT 
            YEAR(last_updated) as period_date,
            SUM(quantity) as total_quantity,
            SUM(quantity * (SELECT price FROM products WHERE product_id = stock_management.product_id)) as total_value
        FROM stock_management
        WHERE stock_type = 'OUT' AND last_updated >= DATE_SUB(CURDATE(), INTERVAL 5 YEAR)
        GROUP BY YEAR(last_updated)
        ORDER BY period_date DESC
    ");
    $data['yearly_history'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log("Data fetch error: " . $e->getMessage());
    die("Error fetching data: " . $e->getMessage());
}

// Export Logic
if (isset($_GET['export'])) {
    if (ob_get_length()) {
        ob_end_clean();
    }

    // Determine which history data to export
    $history_period = $_GET['history_period'] ?? 'monthly';
    $history_data = $data[$history_period . '_history'] ?? [];

    switch ($_GET['export']) {
        case 'pdf':
            try {
                if (!class_exists('setasign\Fpdi\Tcpdf\Fpdi')) {
                    die("FPDI with TCPDF class not found. Please ensure 'setasign/fpdi' and 'tecnickcom/tcpdf' are installed via Composer.");
                }
                $pdf = new Fpdi();
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(0, 10, 'Inventory Report - ' . ucfirst($report_period), 0, 1, 'C');
                $pdf->Ln(10);

                // Quick Stats
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Quick Stats', 0, 1);
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, "Total Products: " . ($data['total_products'] ?? 0), 0, 1);
                $pdf->Cell(0, 10, "Inventory Value: $" . number_format($data['inventory_value'] ?? 0, 2), 0, 1);
                $pdf->Cell(0, 10, "Low Stock Items: " . ($data['low_stock_items'] ?? 0), 0, 1);
                $pdf->Cell(0, 10, "Turnover: " . number_format($data['monthly_turnover'] ?? 0, 1) . "%", 0, 1);
                $pdf->Ln(10);

                // Top Products
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Top Products by Value', 0, 1);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(40, 10, 'Product', 1);
                $pdf->Cell(30, 10, 'Quantity', 1);
                $pdf->Cell(30, 10, 'Unit Cost', 1);
                $pdf->Cell(30, 10, 'Total Value', 1);
                $pdf->Cell(30, 10, 'Status', 1);
                $pdf->Ln();
                foreach ($data['top_products'] as $product) {
                    $pdf->Cell(40, 10, $product['name'] ?? 'N/A', 1);
                    $pdf->Cell(30, 10, $product['quantity'] ?? 0, 1);
                    $pdf->Cell(30, 10, '$' . number_format($product['unit_cost'] ?? 0, 2), 1);
                    $pdf->Cell(30, 10, '$' . number_format($product['total_value'] ?? 0, 2), 1);
                    $pdf->Cell(30, 10, $product['status'] ?? 'Unknown', 1);
                    $pdf->Ln();
                }
                $pdf->Ln(10);

                // Top Suppliers
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Top Suppliers by Value', 0, 1);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(60, 10, 'Supplier', 1);
                $pdf->Cell(40, 10, 'Product Count', 1);
                $pdf->Cell(40, 10, 'Total Value', 1);
                $pdf->Ln();
                foreach ($data['top_suppliers'] as $supplier) {
                    $pdf->Cell(60, 10, $supplier['supplier_name'] ?? 'N/A', 1);
                    $pdf->Cell(40, 10, $supplier['product_count'] ?? 0, 1);
                    $pdf->Cell(40, 10, '$' . number_format($supplier['total_value'] ?? 0, 2), 1);
                    $pdf->Ln();
                }
                $pdf->Ln(10);

                // Sales/Provision History
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(0, 10, 'Sales/Provision History (' . ucfirst($history_period) . ')', 0, 1);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(60, 10, 'Period', 1);
                $pdf->Cell(40, 10, 'Total Quantity', 1);
                $pdf->Cell(40, 10, 'Total Value', 1);
                $pdf->Ln();
                if (!empty($history_data)) {
                    foreach ($history_data as $entry) {
                        $period = $history_period === 'weekly' ? "Week {$entry['week']}, {$entry['year']}" : ($entry['period_date'] ?? 'N/A');
                        $pdf->Cell(60, 10, $period, 1);
                        $pdf->Cell(40, 10, $entry['total_quantity'] ?? 0, 1);
                        $pdf->Cell(40, 10, '$' . number_format($entry['total_value'] ?? 0, 2), 1);
                        $pdf->Ln();
                    }
                } else {
                    $pdf->Cell(140, 10, 'No history found', 1);
                    $pdf->Ln();
                }

                // Output PDF
                $pdf->Output('D', "Inventory_Report_$report_period.pdf");
                exit;
            } catch (Exception $e) {
                error_log("PDF generation failed: " . $e->getMessage());
                die("PDF generation failed: " . $e->getMessage());
            }
            break;

        case 'excel':
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Inventory Report - ' . ucfirst($report_period));
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->setCellValue('A3', 'Quick Stats');
            $sheet->getStyle('A3')->getFont()->setBold(true);
            $stats = [
                ['Total Products', $data['total_products'] ?? 0],
                ['Inventory Value', '$' . number_format($data['inventory_value'] ?? 0, 2)],
                ['Low Stock Items', $data['low_stock_items'] ?? 0],
                ['Turnover', number_format($data['monthly_turnover'] ?? 0, 1) . '%'],
            ];
            $sheet->fromArray($stats, NULL, 'A4');

            $sheet->setCellValue('A9', 'Top Products by Value');
            $sheet->getStyle('A9')->getFont()->setBold(true);
            $sheet->fromArray(['Product', 'Quantity', 'Unit Cost', 'Total Value', 'Status'], NULL, 'A10');
            $sheet->fromArray(
                $data['top_products'] ? array_map(function ($p) {
                    return [
                        $p['name'] ?? 'N/A',
                        $p['quantity'] ?? 0,
                        '$' . number_format($p['unit_cost'] ?? 0, 2),
                        '$' . number_format($p['total_value'] ?? 0, 2),
                        $p['status'] ?? 'Unknown'
                    ];
                }, $data['top_products']) : [['No products found']],
                NULL,
                'A11'
            );

            $startRow = 11 + count($data['top_products']) + 1;
            $sheet->setCellValue("A$startRow", 'Top Suppliers by Value');
            $sheet->getStyle("A$startRow")->getFont()->setBold(true);
            $sheet->fromArray(['Supplier', 'Product Count', 'Total Value'], NULL, "A" . ($startRow + 1));
            $sheet->fromArray(
                $data['top_suppliers'] ? array_map(function ($s) {
                    return [
                        $s['supplier_name'] ?? 'N/A',
                        $s['product_count'] ?? 0,
                        '$' . number_format($s['total_value'] ?? 0, 2)
                    ];
                }, $data['top_suppliers']) : [['No suppliers found']],
                NULL,
                "A" . ($startRow + 2)
            );

            $historyRow = $startRow + count($data['top_suppliers']) + 3;
            $sheet->setCellValue("A$historyRow", 'Sales/Provision History (' . ucfirst($history_period) . ')');
            $sheet->getStyle("A$historyRow")->getFont()->setBold(true);
            $sheet->fromArray(['Period', 'Total Quantity', 'Total Value'], NULL, "A" . ($historyRow + 1));
            $sheet->fromArray(
                $history_data ? array_map(function ($entry) use ($history_period) {
                    $period = $history_period === 'weekly' ? "Week {$entry['week']}, {$entry['year']}" : ($entry['period_date'] ?? 'N/A');
                    return [
                        $period,
                        $entry['total_quantity'] ?? 0,
                        '$' . number_format($entry['total_value'] ?? 0, 2)
                    ];
                }, $history_data) : [['No history found']],
                NULL,
                "A" . ($historyRow + 2)
            );

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Inventory_Report_' . $report_period . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit;
            break;

        case 'csv':
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename="Inventory_Report_' . $report_period . '.csv"');
            $output = fopen('php://output', 'w');

            fputcsv($output, ['Inventory Report - ' . ucfirst($report_period)]);
            fputcsv($output, []);
            fputcsv($output, ['Quick Stats']);
            fputcsv($output, ['Total Products', $data['total_products'] ?? 0]);
            fputcsv($output, ['Inventory Value', '$' . number_format($data['inventory_value'] ?? 0, 2)]);
            fputcsv($output, ['Low Stock Items', $data['low_stock_items'] ?? 0]);
            fputcsv($output, ['Turnover', number_format($data['monthly_turnover'] ?? 0, 1) . '%']);
            fputcsv($output, []);

            fputcsv($output, ['Top Products by Value']);
            fputcsv($output, ['Product', 'Quantity', 'Unit Cost', 'Total Value', 'Status']);
            if (!empty($data['top_products'])) {
                foreach ($data['top_products'] as $product) {
                    fputcsv($output, [
                        $product['name'] ?? 'N/A',
                        $product['quantity'] ?? 0,
                        '$' . number_format($product['unit_cost'] ?? 0, 2),
                        '$' . number_format($product['total_value'] ?? 0, 2),
                        $product['status'] ?? 'Unknown'
                    ]);
                }
            } else {
                fputcsv($output, ['No products found']);
            }
            fputcsv($output, []);

            fputcsv($output, ['Top Suppliers by Value']);
            fputcsv($output, ['Supplier', 'Product Count', 'Total Value']);
            if (!empty($data['top_suppliers'])) {
                foreach ($data['top_suppliers'] as $supplier) {
                    fputcsv($output, [
                        $supplier['supplier_name'] ?? 'N/A',
                        $supplier['product_count'] ?? 0,
                        '$' . number_format($supplier['total_value'] ?? 0, 2)
                    ]);
                }
            } else {
                fputcsv($output, ['No suppliers found']);
            }
            fputcsv($output, []);

            fputcsv($output, ['Sales/Provision History (' . ucfirst($history_period) . ')']);
            fputcsv($output, ['Period', 'Total Quantity', 'Total Value']);
            if (!empty($history_data)) {
                foreach ($history_data as $entry) {
                    $period = $history_period === 'weekly' ? "Week {$entry['week']}, {$entry['year']}" : ($entry['period_date'] ?? 'N/A');
                    fputcsv($output, [
                        $period,
                        $entry['total_quantity'] ?? 0,
                        '$' . number_format($entry['total_value'] ?? 0, 2)
                    ]);
                }
            } else {
                fputcsv($output, ['No history found']);
            }

            fclose($output);
            exit;
            break;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Inventory Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    @media print {
        .col-lg-3 {
            display: none !important;
        }

        .col-lg-9 {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .btn,
        .dropdown,
        .modal,
        .pagination,
        #createReportModal,
        #scheduleReportModal {
            display: none !important;
        }

        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }

        .table {
            width: 100% !important;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000 !important;
            padding: 8px !important;
        }

        .table-responsive {
            page-break-inside: avoid;
        }

        .alert {
            background: none !important;
            border: none !important;
            padding: 5px !important;
        }

        .alert i,
        .card-body i {
            display: none !important;
        }

        #history-table {
            width: 100% !important;
            border-collapse: collapse;
        }

        #history-table th,
        #history-table td {
            border: 1px solid #000 !important;
            padding: 8px !important;
        }

        #history-table tbody:not(:first-child) {
            display: none;
        }
    }
    </style>
</head>

<body>
    <div class="container-fluid px-4 py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1">Reports & Analytics</h1>
                <p class="text-muted mb-0">Generate and analyze inventory data reports</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#scheduleReportModal">
                    <i class="fas fa-clock me-2"></i>Schedule Reports
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReportModal">
                    <i class="fas fa-plus me-2"></i>Create Report
                </button>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-box text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Products</h6>
                            <h3 class="mb-0"><?php echo (int)($data['total_products'] ?? 0); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="fas fa-dollar-sign text-success fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Inventory Value</h6>
                            <h3 class="mb-0"><?php echo '$' . number_format($data['inventory_value'] ?? 0, 2); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-exclamation-triangle text-warning fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Low Stock Items</h6>
                            <h3 class="mb-0"><?php echo (int)($data['low_stock_items'] ?? 0); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                            <i class="fas fa-exchange-alt text-info fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1"><?php echo ucfirst($report_period); ?> Turnover</h6>
                            <h3 class="mb-0"><?php echo number_format($data['monthly_turnover'] ?? 0, 1) . '%'; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Report Categories</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="?period=monthly"
                                class="list-group-item list-group-item-action <?php echo $report_period == 'monthly' ? 'active' : ''; ?> d-flex align-items-center">
                                <i class="fas fa-chart-line me-3"></i><span>Overview Dashboard</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Filters</h5>
                        <button class="btn btn-sm btn-outline-secondary" type="button"
                            onclick="document.querySelector('form').reset();">Reset</button>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Date Range</label>
                                <select class="form-select mb-2" onchange="window.location.href='?period='+this.value">
                                    <option value="daily" <?php echo $report_period == 'daily' ? 'selected' : ''; ?>>
                                        Daily</option>
                                    <option value="weekly" <?php echo $report_period == 'weekly' ? 'selected' : ''; ?>>
                                        Weekly</option>
                                    <option value="monthly"
                                        <?php echo $report_period == 'monthly' ? 'selected' : ''; ?>>Monthly</option>
                                </select>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="date" class="form-control form-control-sm" name="start_date"
                                            value="<?php echo $start_date; ?>">
                                    </div>
                                    <div class="col-6">
                                        <input type="date" class="form-control form-control-sm" name="end_date"
                                            value="<?php echo $end_date; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Product Categories</label>
                                <select class="form-select" name="categories[]" multiple size="3">
                                    <option value="all"
                                        <?php echo empty($filters['categories']) || in_array('all', $filters['categories']) ? 'selected' : ''; ?>>
                                        All Categories</option>
                                    <option value="1"
                                        <?php echo !empty($filters['categories']) && in_array('1', $filters['categories']) ? 'selected' : ''; ?>>
                                        Electronics</option>
                                    <option value="2"
                                        <?php echo !empty($filters['categories']) && in_array('2', $filters['categories']) ? 'selected' : ''; ?>>
                                        Books</option>
                                    <option value="3"
                                        <?php echo !empty($filters['categories']) && in_array('3', $filters['categories']) ? 'selected' : ''; ?>>
                                        Furniture</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Stock Status (Uncheck to hide)</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="stock_status[]"
                                        value="inStock" id="inStock"
                                        <?php echo empty($filters['stock_status']) || in_array('inStock', $filters['stock_status']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="inStock">In Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="stock_status[]"
                                        value="lowStock" id="lowStock"
                                        <?php echo empty($filters['stock_status']) || in_array('lowStock', $filters['stock_status']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="lowStock">Low Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="stock_status[]"
                                        value="outOfStock" id="outOfStock"
                                        <?php echo empty($filters['stock_status']) || in_array('outOfStock', $filters['stock_status']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="outOfStock">Out of Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="stock_status[]"
                                        value="overstock" id="overstock"
                                        <?php echo empty($filters['stock_status']) || in_array('overstock', $filters['stock_status']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="overstock">Overstock</label>
                                </div>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">
                                <i class="fas fa-filter me-2"></i>Apply Filters
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">
                                <?php echo $report_period === 'sales' ? 'Sales Analysis' : 'Inventory Overview Dashboard'; ?>
                            </h4>
                            <div class="btn-group">
                                <select class="form-select form-select-sm me-2"
                                    onchange="window.location.href='?period='+this.value">
                                    <option value="daily" <?php echo $report_period == 'daily' ? 'selected' : ''; ?>>
                                        Daily</option>
                                    <option value="weekly" <?php echo $report_period == 'weekly' ? 'selected' : ''; ?>>
                                        Weekly</option>
                                    <option value="monthly"
                                        <?php echo $report_period == 'monthly' ? 'selected' : ''; ?>>Monthly</option>
                                    <option value="sales" <?php echo $report_period == 'sales' ? 'selected' : ''; ?>>
                                        Sales</option>
                                </select>
                                <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                                    <i class="fas fa-print me-1"></i> Print
                                </button>
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-download me-1"></i> Export
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <h6 class="dropdown-header">Export with History</h6>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="?export=pdf&period=<?php echo $report_period; ?>&history_period=daily"><i
                                                class="far fa-file-pdf me-2"></i>PDF (Daily History)</a></li>
                                    <li><a class="dropdown-item"
                                            href="?export=pdf&period=<?php echo $report_period; ?>&history_period=weekly"><i
                                                class="far fa-file-pdf me-2"></i>PDF (Weekly History)</a></li>
                                    <li><a class="dropdown-item"
                                            href="?export=pdf&period=<?php echo $report_period; ?>&history_period=monthly"><i
                                                class="far fa-file-pdf me-2"></i>PDF (Monthly History)</a></li>
                                    <li><a class="dropdown-item"
                                            href="?export=pdf&period=<?php echo $report_period; ?>&history_period=yearly"><i
                                                class="far fa-file-pdf me-2"></i>PDF (Yearly History)</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="?export=excel&period=<?php echo $report_period; ?>&history_period=daily"><i
                                                class="far fa-file-excel me-2"></i>Excel (Daily History)</a></li>
                                    <li><a class="dropdown-item"
                                            href="?export=excel&period=<?php echo $report_period; ?>&history_period=weekly"><i
                                                class="far fa-file-excel me-2"></i>Excel (Weekly History)</a></li>
                                    <li><a class="dropdown-item"
                                            href="?export=excel&period=<?php echo $report_period; ?>&history_period=monthly"><i
                                                class="far fa-file-excel me-2"></i>Excel (Monthly History)</a></li>
                                    <li><a class="dropdown-item"
                                            href="?export=excel&period=<?php echo $report_period; ?>&history_period=yearly"><i
                                                class="far fa-file-excel me-2"></i>Excel (Yearly History)</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="?export=csv&period=<?php echo $report_period; ?>&history_period=daily"><i
                                                class="far fa-file-csv me-2"></i>CSV (Daily History)</a></li>
                                    <li><a class="dropdown-item"
                                            href="?export=csv&period=<?php echo $report_period; ?>&history_period=weekly"><i
                                                class="far fa-file-csv me-2"></i>CSV (Weekly History)</a></li>
                                    <li><a class="dropdown-item"
                                            href="?export=csv&period=<?php echo $report_period; ?>&history_period=monthly"><i
                                                class="far fa-file-csv me-2"></i>CSV (Monthly History)</a></li>
                                    <li><a class="dropdown-item"
                                            href="?export=csv&period=<?php echo $report_period; ?>&history_period=yearly"><i
                                                class="far fa-file-csv me-2"></i>CSV (Yearly History)</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-muted">
                            Showing data for <strong><?php echo ucfirst($report_period); ?></strong>
                            (<?php echo $start_date . ' - ' . $end_date; ?>) •
                            <?php echo !empty($filters['categories']) && !in_array('all', $filters['categories']) ? implode(', ', array_map(function($id) use ($pdo) {
                            $stmt = $pdo->prepare("SELECT category_name FROM categories WHERE category_id = ?");
                            $stmt->execute([$id]);
                            return $stmt->fetchColumn();
                        }, $filters['categories'])) : 'All Categories'; ?>
                            • Status:
                            <?php echo !empty($filters['stock_status']) ? implode(', ', array_map('ucfirst', str_replace('Stock', ' Stock', $filters['stock_status']))) : 'All'; ?>
                        </p>
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="fas fa-box me-3 fa-lg"></i>
                            <div>
                                <strong>Total Products in Inventory:</strong>
                                <?php echo (int)($data['total_products'] ?? 0); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Top Products by Value</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                data-bs-toggle="dropdown">Top 10</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Top 5</a></li>
                                <li><a class="dropdown-item" href="#">Top 10</a></li>
                                <li><a class="dropdown-item" href="#">Top 20</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Unit Cost</th>
                                        <th class="text-end">Total Value</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data['top_products'])): ?>
                                    <?php foreach ($data['top_products'] as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['name'] ?? 'N/A'); ?></td>
                                        <td class="text-center"><?php echo (int)($product['quantity'] ?? 0); ?></td>
                                        <td class="text-end">
                                            <?php echo '$' . number_format($product['unit_cost'] ?? 0, 2); ?></td>
                                        <td class="text-end">
                                            <?php echo '$' . number_format($product['total_value'] ?? 0, 2); ?></td>
                                        <td class="text-center">
                                            <span class="badge <?php
                                                    switch ($product['status'] ?? '') {
                                                        case 'In Stock': echo 'bg-success'; break;
                                                        case 'Low Stock': echo 'bg-warning text-dark'; break;
                                                        case 'Out of Stock': echo 'bg-danger'; break;
                                                        case 'Overstock': echo 'bg-info'; break;
                                                        default: echo 'bg-secondary';
                                                    }
                                                ?>">
                                                <?php echo htmlspecialchars($product['status'] ?? 'Unknown'); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No products found</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Top Suppliers by Value</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                data-bs-toggle="dropdown">Top 5</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Top 5</a></li>
                                <li><a class="dropdown-item" href="#">Top 10</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Supplier</th>
                                        <th class="text-center">Product Count</th>
                                        <th class="text-end">Total Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data['top_suppliers'])): ?>
                                    <?php foreach ($data['top_suppliers'] as $supplier): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($supplier['supplier_name'] ?? 'N/A'); ?></td>
                                        <td class="text-center"><?php echo (int)($supplier['product_count'] ?? 0); ?>
                                        </td>
                                        <td class="text-end">
                                            <?php echo '$' . number_format($supplier['total_value'] ?? 0, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No suppliers found</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Sales/Provision History</h5>
                        <select class="form-select form-select-sm" onchange="toggleHistoryView(this.value)">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly" selected>Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="history-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Period</th>
                                        <th class="text-center">Total Quantity</th>
                                        <th class="text-end">Total Value</th>
                                    </tr>
                                </thead>
                                <tbody id="daily-history" style="display: none;">
                                    <?php if (!empty($data['daily_history'])): ?>
                                    <?php foreach ($data['daily_history'] as $entry): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($entry['period_date']); ?></td>
                                        <td class="text-center"><?php echo (int)($entry['total_quantity'] ?? 0); ?></td>
                                        <td class="text-end">
                                            <?php echo '$' . number_format($entry['total_value'] ?? 0, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No daily history found</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tbody id="weekly-history" style="display: none;">
                                    <?php if (!empty($data['weekly_history'])): ?>
                                    <?php foreach ($data['weekly_history'] as $entry): ?>
                                    <tr>
                                        <td>Week <?php echo htmlspecialchars($entry['week']) . ', ' . $entry['year']; ?>
                                        </td>
                                        <td class="text-center"><?php echo (int)($entry['total_quantity'] ?? 0); ?></td>
                                        <td class="text-end">
                                            <?php echo '$' . number_format($entry['total_value'] ?? 0, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No weekly history found</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tbody id="monthly-history">
                                    <?php if (!empty($data['monthly_history'])): ?>
                                    <?php foreach ($data['monthly_history'] as $entry): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($entry['period_date']); ?></td>
                                        <td class="text-center"><?php echo (int)($entry['total_quantity'] ?? 0); ?></td>
                                        <td class="text-end">
                                            <?php echo '$' . number_format($entry['total_value'] ?? 0, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No monthly history found</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tbody id="yearly-history" style="display: none;">
                                    <?php if (!empty($data['yearly_history'])): ?>
                                    <?php foreach ($data['yearly_history'] as $entry): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($entry['period_date']); ?></td>
                                        <td class="text-center"><?php echo (int)($entry['total_quantity'] ?? 0); ?></td>
                                        <td class="text-end">
                                            <?php echo '$' . number_format($entry['total_value'] ?? 0, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No yearly history found</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0">Alerts & Recommendations</h5>
                    </div>
                    <div class="card-body">
                        <?php if (in_array('lowStock', $selected_statuses)): ?>
                        <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                            <div>
                                <strong><?php echo (int)($data['low_stock_items'] ?? 0); ?> products</strong> are
                                currently at low stock levels.
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (in_array('outOfStock', $selected_statuses)): ?>
                        <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                            <i class="fas fa-times-circle me-3 fa-lg"></i>
                            <div>
                                <strong><?php echo (int)($data['not_in_stock'] ?? 0); ?> products</strong> are out of
                                stock.
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (in_array('overstock', $selected_statuses)): ?>
                        <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
                            <i class="fas fa-info-circle me-3 fa-lg"></i>
                            <div>
                                <strong><?php echo (int)($data['overstocked_items'] ?? 0); ?> products</strong> have
                                been overstocked.
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="alert alert-success d-flex align-items-center mb-0" role="alert">
                            <i class="fas fa-lightbulb me-3 fa-lg"></i>
                            <div>
                                Recommended: Increase stock for
                                <strong><?php echo htmlspecialchars($data['top_recommendation']['name'] ?? 'N/A'); ?></strong>
                                by 20%.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Report Modal -->
    <div class="modal fade" id="createReportModal" tabindex="-1" aria-labelledby="createReportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createReportModalLabel">Create New Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="GET">
                        <div class="mb-3">
                            <label class="form-label">Report Name</label>
                            <input type="text" class="form-control" placeholder="Enter report name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Report Type</label>
                            <select class="form-select" name="period">
                                <option value="monthly">Inventory Overview</option>
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Format</label>
                                <select class="form-select" name="export">
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Report Modal -->
    <div class="modal fade" id="scheduleReportModal" tabindex="-1" aria-labelledby="scheduleReportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleReportModalLabel">Schedule Reports</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Report</label>
                        <select class="form-select">
                            <option value="monthly">Inventory Overview</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Frequency</label>
                        <select class="form-select">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Schedule Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleHistoryView(period) {
        document.querySelectorAll('#history-table tbody').forEach(tbody => tbody.style.display = 'none');
        document.getElementById(period + '-history').style.display = 'table-row-group';
    }
    </script>
</body>

</html>