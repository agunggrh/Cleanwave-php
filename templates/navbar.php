        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <i class="fa-solid fa-water fa-bounce" style="color: #60a5fa;"></i> CleanWave
            </div>

            <?php 
            $current_page = basename($_SERVER['PHP_SELF']); 
            $current_dir = basename(dirname($_SERVER['PHP_SELF']));
            ?>

            <ul class="list-unstyled components">
                <li class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
                    <a href="<?= base_url('dashboard.php') ?>"><i class="fa-solid fa-house"></i> Dashboard</a>
                </li>
                <li class="<?= ($current_page == 'tambah.php') ? 'active' : '' ?>">
                    <a href="<?= base_url('transaksi/tambah.php') ?>"><i class="fa-solid fa-plus"></i> Tambah Transaksi</a>
                </li>
                <li class="<?= ($current_page == 'status.php') ? 'active' : '' ?>">
                    <a href="<?= base_url('transaksi/status.php') ?>"><i class="fa-solid fa-bars-progress"></i> Status Transaksi</a>
                </li>
                <li class="<?= ($current_page == 'filter.php') ? 'active' : '' ?>">
                    <a href="<?= base_url('laporan/filter.php') ?>"><i class="fa-solid fa-file-invoice"></i> Laporan</a>
                </li>
                <li>
                    <a href="#" onclick="confirmLogout(event)"><i class="fa-solid fa-right-from-bracket text-danger"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <div class="top-navbar">
                <div>
                    <h5 class="mb-0 text-muted" id="page-title">Sistem Laundry</h5>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle border-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-circle fa-lg text-primary"></i> 
                        <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User' ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item text-danger" href="#" onclick="confirmLogout(event)"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- SweetAlert Logout Confirmation Script -->
            <script>
            function confirmLogout(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Keluar aplikasi?',
                    text: "Sesi Anda akan diakhiri.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url("auth/logout.php") ?>';
                    }
                })
            }
            </script>
            
            <!-- Main Content Container Start -->
            <div class="container-fluid px-4 pb-4">
