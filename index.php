<?php
include 'koneksi.php';

// Ambil data meja dari database
$stmt = $pdo->query("SELECT * FROM tables ORDER BY id ASC");
$tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_tables = count($tables);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Table Entry Form & Catalog</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="StyleSheet.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <!-- Header Utama -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="fw-bold text-dark">Restaurant & Cafe System</h1>
                <hr class="w-25 mx-auto">
            </div>
        </div>

        <div class="row g-4">
            <!-- Kolom Kiri: Form Input -->
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0">➕ Restaurant Table Entry Form</h5>
                    </div>
                    <div class="card-body">
                        <!-- Mengarah ke file tambah.php -->
                        <form action="tambah.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Table Number:</label>
                                <input type="text" name="table_number" class="form-control" placeholder="e.g. T-009" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Capacity (Seats):</label>
                                <input type="number" name="capacity" class="form-control" placeholder="e.g. 4" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Area:</label>
                                <select name="area" class="form-select" required>
                                    <option value="Indoor">Indoor</option>
                                    <option value="Outdoor">Outdoor</option>
                                    <option value="VIP">VIP</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Table Status:</label>
                                <select name="status" class="form-select" required>
                                    <option value="Available">Available</option>
                                    <option value="Occupied">Occupied</option>
                                    <option value="Reserved">Reserved</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Add Table</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Catalog (Data dari Database MySQL) -->
            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">📋 Table Catalog</h5>
                        <span class="badge bg-secondary">Total: <?= $total_tables; ?> Tables</span>
                    </div>
                    <div class="card-body">
                        <!-- Table Catalog Display -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Table No</th>
                                        <th>Capacity</th>
                                        <th>Area</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($total_tables > 0): ?>
                                        <?php foreach ($tables as $row): ?>
                                            <?php 
                                                // Styling badge warna area
                                                $areaClass = 'bg-info text-dark';
                                                if ($row['area'] == 'Outdoor') $areaClass = 'bg-warning text-dark';
                                                if ($row['area'] == 'VIP') $areaClass = 'bg-secondary';

                                                // Styling badge warna status
                                                $statusClass = 'bg-success';
                                                if ($row['status'] == 'Occupied') $statusClass = 'bg-danger';
                                                if ($row['status'] == 'Reserved') $statusClass = 'bg-warning text-dark';
                                            ?>
                                            <tr>
                                                <td class="fw-bold"><?= htmlspecialchars($row['table_number']); ?></td>
                                                <td><?= htmlspecialchars($row['capacity']); ?> Persons</td>
                                                <td><span class="badge <?= $areaClass; ?>"><?= htmlspecialchars($row['area']); ?></span></td>
                                                <td><span class="badge <?= $statusClass; ?>"><?= htmlspecialchars($row['status']); ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-muted py-3">No tables found in database.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>