<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /UJIKOM/index.php");
    exit;
}

include '../template/header.php';
include '../template/sidebar.php';

$dataAnggota = [
    ['nama' => 'Andi Saputra', 'email' => 'andi.saputra@example.com', 'status' => 'Aktif'],
    ['nama' => 'Bunga Lestari', 'email' => 'bunga.lestari@example.com', 'status' => 'Tidak Aktif'],
    ['nama' => 'Cahyo Pratama', 'email' => 'cahyo.pratama@example.com', 'status' => 'Aktif'],
];
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Anggota</h3>
    </div>

    <div class="card-body">
        <a href="#" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Data
        </a>

        <div class="row mb-3">
            <div class="col-sm-4 ml-auto">
                <input type="text" id="searchAnggota" class="form-control" placeholder="Search">
            </div>
        </div>

        <table id="tabelAnggota" class="table table-bordered table-striped" data-no-datatable="true">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataAnggota as $index => $anggota): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($anggota['nama']); ?></td>
                        <td><?= htmlspecialchars($anggota['email']); ?></td>
                        <td><?= htmlspecialchars($anggota['status']); ?></td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm">Update</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <button type="button" id="prevPage" class="btn btn-secondary btn-sm">Previous</button>
            <div id="paginationNumbers"></div>
            <button type="button" id="nextPage" class="btn btn-secondary btn-sm">Next</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchAnggota');
    const tableBody = document.querySelector('#tabelAnggota tbody');
    const allRows = Array.from(tableBody.querySelectorAll('tr'));
    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');
    const pageNumbersContainer = document.getElementById('paginationNumbers');
    const rowsPerPage = 2;
    let currentPage = 1;
    let filteredRows = allRows;

    function renderRows() {
        const totalPages = Math.max(1, Math.ceil(filteredRows.length / rowsPerPage));
        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageRows = filteredRows.slice(start, end);

        allRows.forEach(row => {
            row.style.display = pageRows.includes(row) ? '' : 'none';
        });

        pageNumbersContainer.innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-sm ' + (i === currentPage ? 'btn-primary' : 'btn-light');
            button.textContent = i;
            button.style.margin = '0 2px';
            button.addEventListener('click', function () {
                currentPage = i;
                renderRows();
            });
            pageNumbersContainer.appendChild(button);
        }

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
    }

    searchInput.addEventListener('input', function () {
        const keyword = searchInput.value.toLowerCase().trim();
        filteredRows = allRows.filter(row => row.textContent.toLowerCase().includes(keyword));
        currentPage = 1;
        renderRows();
    });

    prevBtn.addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            renderRows();
        }
    });

    nextBtn.addEventListener('click', function () {
        const totalPages = Math.max(1, Math.ceil(filteredRows.length / rowsPerPage));
        if (currentPage < totalPages) {
            currentPage++;
            renderRows();
        }
    });

    renderRows();
});
</script>

<?php include '../template/footer.php'; ?>
