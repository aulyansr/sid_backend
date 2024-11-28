<?= $this->extend('layout/dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 w-300 mb-2 text-gray-800"><?= $analisis_master['nama']; ?></h1>
    <h3 class="mb-2 fs-5 text-gray-800">Subject Analisis: <?= esc($subjects_types[$analisis_master['subjek_tipe']] ?? 'Penduduk'); ?></h3>
    <h3 class="h3 mb-2 text-gray-800">Subject Periode: <?= esc($periode['nama']); ?></h3>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header border-bottom">
            <?= $this->include('partials/analisis_tabs', ['activeSideTab' => 'reports']); ?>
        </div>

        <div class="card-body">

            <div class="mb-5">
                <canvas id="myChart" height="100"></canvas>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped compact" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>

                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Klasifikasi</th> <!-- Added Status column -->
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>

                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Klasifikasi</th> <!-- Added Status column -->
                        </tr>
                    </tfoot>
                    <tbody>

                        <?php foreach ($subjects as $index => $subject) : ?>
                            <tr>

                                <td align="center"><?= $index + 1; ?></td>


                                <td><?= esc($subject->nik); ?></td>
                                <td><?= esc($subject->nama); ?></td>
                                <td><?= esc($subject->sex_nama); ?></td>
                                <td><?= esc($subject->klasifikasi_nama); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<!-- Page level plugins -->
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/DataTables-1.13.8/js/dataTables.bootstrap4.min.js"></script>

<!-- Data table plugins -->
<script src="/assets/js/admin/vendors/datatables/extensions/JSZip-3.10.1/jszip.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/pdfmake-0.2.7/pdfmake.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/pdfmake-0.2.7/vfs_fonts.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.html5.min.js"></script>
<script src="/assets/js/admin/vendors/datatables/extensions/Buttons-2.4.2/js/buttons.print.min.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');

    // Define colors for bars
    const backgroundColors = [
        'rgba(255, 99, 132, 0.2)', // First bar
        'rgba(54, 162, 235, 0.2)', // Second bar
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(99, 255, 132, 0.2)',
        'rgba(162, 54, 235, 0.2)',
        'rgba(206, 255, 86, 0.2)',
        'rgba(192, 75, 192, 0.2)',
        'rgba(102, 153, 255, 0.2)' // 10 dummy colors
    ];

    const borderColors = [
        'rgba(255, 99, 132, 1)', // First bar
        'rgba(54, 162, 235, 1)', // Second bar
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(99, 255, 132, 1)',
        'rgba(162, 54, 235, 1)',
        'rgba(206, 255, 86, 1)',
        'rgba(192, 75, 192, 1)',
        'rgba(102, 153, 255, 1)' // 10 dummy colors
    ];

    // Group data by klasifikasi_nama and count occurrences
    const subjectData = <?= json_encode($subjects); ?>;
    const klasifikasiCounts = subjectData.reduce((acc, subject) => {
        const klasifikasi = subject.klasifikasi_nama || 'Unknown';
        acc[klasifikasi] = (acc[klasifikasi] || 0) + 1;
        return acc;
    }, {});

    const labels = Object.keys(klasifikasiCounts);
    const data = Object.values(klasifikasiCounts);

    // Dynamically assign colors for the bars
    const colorsLength = backgroundColors.length;
    const barBackgroundColors = labels.map((_, index) => backgroundColors[index % colorsLength]);
    const barBorderColors = labels.map((_, index) => borderColors[index % colorsLength]);

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels, // Classification names
            datasets: [{
                label: 'Jumlah Subjek',
                data: data, // Count of subjects per classification
                backgroundColor: barBackgroundColors,
                borderColor: barBorderColors,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Distribusi Subjek Berdasarkan Klasifikasi'
                }
            }
        }
    });
</script>

<?= $this->endSection(); ?>