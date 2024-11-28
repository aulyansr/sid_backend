<?= $this->extend('layout/public'); ?>

<?= $this->section('content'); ?>



<div class="container px-5">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home.html">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Statistik</li>
        </ol>
    </nav>
    <h1 class="mb-3">
        Statistik Berdasar
        Kelompok Umur
    </h1>
    <div class="card">
        <div class="card-body">
            <div class="mb-5">
                <canvas id="myChart" height="100"></canvas>
            </div>
            <table border="1" class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelompok_umur</th>
                        <th>Jumlah</th>
                        <th>%</th>
                        <th>Laki-laki</th>
                        <th>%</th>
                        <th>Perempuan</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($summary as $row): ?>
                        <tr>
                            <td><?= $row['kelompok_umur'] === 'TOTAL' ? '' : $no++; ?></td>
                            <td><?= $row['kelompok_umur']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                            <td><?= $row['persen']; ?>%</td>
                            <td><?= $row['laki_laki']; ?></td>
                            <td><?= $row['laki_laki_persen']; ?>%</td>
                            <td><?= $row['perempuan']; ?></td>
                            <td><?= $row['perempuan_persen']; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>


</div>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');


    const backgroundColors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(99, 255, 132, 0.2)',
        'rgba(162, 54, 235, 0.2)',
        'rgba(206, 255, 86, 0.2)',
        'rgba(192, 75, 192, 0.2)',
        'rgba(102, 153, 255, 0.2)'
    ];

    const borderColors = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(99, 255, 132, 1)',
        'rgba(162, 54, 235, 1)',
        'rgba(206, 255, 86, 1)',
        'rgba(192, 75, 192, 1)',
        'rgba(102, 153, 255, 1)'
    ];


    const pendidikanData = <?= json_encode($summary); ?>;


    const kelompok_umurCounts = pendidikanData.reduce((acc, row) => {
        const kelompok_umur = row.kelompok_umur || 'Unknown';
        if (!acc[kelompok_umur]) {
            acc[kelompok_umur] = {
                jumlah: 0,
                laki_laki: 0,
                perempuan: 0
            };
        }
        acc[kelompok_umur].jumlah += row.jumlah;
        acc[kelompok_umur].laki_laki += row.laki_laki;
        acc[kelompok_umur].perempuan += row.perempuan;
        return acc;
    }, {});




    const labels = Object.keys(kelompok_umurCounts).filter(kelompok_umur => kelompok_umur !== 'TOTAL');
    const data = labels.map(kelompok_umur => kelompok_umurCounts[kelompok_umur].jumlah);


    const colorsLength = backgroundColors.length;
    const barBackgroundColors = labels.map((_, index) => backgroundColors[index % colorsLength]);
    const barBorderColors = labels.map((_, index) => borderColors[index % colorsLength]);

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Subjek',
                data: data,
                backgroundColor: barBackgroundColors,
                borderColor: barBorderColors,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Distribusi Pendidikan Berdasarkan Kelompok_umur'
                }
            }
        }
    });
</script>
<?= $this->endSection(); ?>