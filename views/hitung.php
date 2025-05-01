<?php
 include '../config/database.php';
 $totalData = 0;
$selected_ids = isset($_GET['id_anggota']) ? $_GET['id_anggota'] : null;

$totalBobotQuery = "SELECT SUM(bobot_kriteria) AS total_bobot FROM kriteria";
$totalBobotResult = mysqli_query($conn, $totalBobotQuery);
$totalBobotData = mysqli_fetch_assoc($totalBobotResult);
$totalBobot = round($totalBobotData['total_bobot'], 2); // Round to 2 decimal places

if ($selected_ids) {
    $query = "SELECT COUNT(*) AS total FROM handphone WHERE id_handphone IN ($selected_ids)";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalData = $row['total'];
}
$get_data = mysqli_query($conn, "select * from handphone where id_handphone IN ($selected_ids)");
// $get_data = mysqli_query($conn, "select * from handphone");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">
    <title>Hitung</title>
    <!-- vendor css -->
    <link href="../assets/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../assets/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="../assets/lib/rickshaw/rickshaw.min.css" rel="stylesheet">
    <link href="../assets/lib/select2/css/select2.min.css" rel="stylesheet">

    <link href="../assets/lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../assets/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="../assets/css/bracket.css">
</head>

<body>
    <?php include 'partials/sidebar.php' ?>

    <?php include 'partials/header.php' ?>
    <div class="br-mainpanel">
       
        <?php if ($totalData > 1) { ?>
        <div class="br-pagetitle">
            <div>
                <h4>Handphone</h4>
            </div>
        </div>
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <h6 class="br-section-label">Data Handphone</h6>

                <div class="table-wrapper">
                    <table id="datatable1" class="table display responsive nowrap">
                        <thead>
                            <tr>
                                <th class="wd-10p">No</th>
                                <th class="wd-15p">Nama Handphone</th>
                                <th class="wd-10p">Harga</th>
                                <th class="wd-10p">RAM</th>
                                <th class="wd-10p">ROM</th>
                                <th class="wd-10p">Kamera Depan</th>
                                <th class="wd-10p">Kamera Belakang</th>
                                <th class="wd-10p">Jaringan</th>
                                <th class="wd-10p">Baterai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php 
                $no = 1;
                $get_data = mysqli_query($conn, "select * from handphone where id_handphone IN ($selected_ids)");
                while($display = mysqli_fetch_array($get_data)) {
                    $id = $display['id_handphone'];
                    $nama = $display['nama_handphone'];
                    $c1 = ($display['c1']);
                    $c2 = ($display['c2']);
                    $c3 = ($display['c3']);
                    $c4 = ($display['c4']);
                    $c5 = ($display['c5']);
                    $c6 = ($display['c6']);
                    $c7 = ($display['c7']);
                ?>
                                <td><?php echo $no ?></td>
                                <td><?php echo $nama ?></td>
                                <td><?php echo $c1 ?></td>
                                <td><?php echo $c2 ?></td>
                                <td><?php echo $c3 ?></td>
                                <td><?php echo $c4 ?></td>
                                <td><?php echo $c5 ?></td>
                                <td><?php echo $c6 ?></td>
                                <td><?php echo $c7 ?></td>
                            </tr>
                            <?php
              $no++;
                }
              ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <h6 class="br-section-label">Data Handphone</h6>

                <div class="table-wrapper">
                    <table id="datatable2" class="table table-striped table-bordered display responsive nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Handphone</th>
                                <th>Harga (Normalized)</th>
                                <th>RAM (Normalized)</th>
                                <th>ROM (Normalized)</th>
                                <th>Kamera Depan (Normalized)</th>
                                <th>Kamera Belakang (Normalized)</th>
                                <th>Jaringan (Normalized)</th>
                                <th>Baterai (Normalized)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                    // Fetch data from the database
                    $get_data = mysqli_query($conn, "select * from handphone where id_handphone IN ($selected_ids)");

                    // Initialize arrays to store values of each criterion for finding min and max
                    $criteria_values = [
                        'c1' => [],
                        'c2' => [],
                        'c3' => [],
                        'c4' => [],
                        'c5' => [],
                        'c6' => [],
                        'c7' => []
                    ];

                    // Collect all values of each criterion
                    while ($row = mysqli_fetch_array($get_data)) {
                        $criteria_values['c1'][] = $row['c1'];
                        $criteria_values['c2'][] = $row['c2'];
                        $criteria_values['c3'][] = $row['c3'];
                        $criteria_values['c4'][] = $row['c4'];
                        $criteria_values['c5'][] = $row['c5'];
                        $criteria_values['c6'][] = $row['c6'];
                        $criteria_values['c7'][] = $row['c7'];
                    }

                    // Calculate min and max for each criterion
                    $min_values = [
                        'c1' => min($criteria_values['c1']),
                        'c2' => min($criteria_values['c2']),
                        'c3' => min($criteria_values['c3']),
                        'c4' => min($criteria_values['c4']),
                        'c5' => min($criteria_values['c5']),
                        'c6' => min($criteria_values['c6']),
                        'c7' => min($criteria_values['c7'])
                    ];

                    $max_values = [
                        'c1' => max($criteria_values['c1']),
                        'c2' => max($criteria_values['c2']),
                        'c3' => max($criteria_values['c3']),
                        'c4' => max($criteria_values['c4']),
                        'c5' => max($criteria_values['c5']),
                        'c6' => max($criteria_values['c6']),
                        'c7' => max($criteria_values['c7'])
                    ];

                    // Re-fetch data for the table and normalization process
                    $no = 1;
                    $get_data = mysqli_query($conn, "select * from handphone where id_handphone IN ($selected_ids)");

                    // Start rendering the table
                    while ($display = mysqli_fetch_array($get_data)) {
                        $id = $display['id_handphone'];
                        $nama = $display['nama_handphone'];

                        // Normalize each criterion
                        $c1_normalized = ($max_values['c1'] - $min_values['c1']) > 0 ? ($display['c1'] - $min_values['c1']) / ($max_values['c1'] - $min_values['c1']) : 0;
                        $c2_normalized = ($max_values['c2'] - $min_values['c2']) > 0 ? ($display['c2'] - $min_values['c2']) / ($max_values['c2'] - $min_values['c2']) : 0;
                        $c3_normalized = ($max_values['c3'] - $min_values['c3']) > 0 ? ($display['c3'] - $min_values['c3']) / ($max_values['c3'] - $min_values['c3']) : 0;
                        $c4_normalized = ($max_values['c4'] - $min_values['c4']) > 0 ? ($display['c4'] - $min_values['c4']) / ($max_values['c4'] - $min_values['c4']) : 0;
                        $c5_normalized = ($max_values['c5'] - $min_values['c5']) > 0 ? ($display['c5'] - $min_values['c5']) / ($max_values['c5'] - $min_values['c5']) : 0;
                        $c6_normalized = ($max_values['c6'] - $min_values['c6']) > 0 ? ($display['c6'] - $min_values['c6']) / ($max_values['c6'] - $min_values['c6']) : 0;
                        $c7_normalized = ($max_values['c7'] - $min_values['c7']) > 0 ? ($display['c7'] - $min_values['c7']) / ($max_values['c7'] - $min_values['c7']) : 0;
                        // Display the data in the table
                        echo "
                        <tr>
                            <td>{$no}</td>
                            <td>{$nama}</td>
                            <td>" . number_format($c1_normalized, 2) . "</td>
                            <td>" . number_format($c2_normalized, 2) . "</td>
                            <td>" . number_format($c3_normalized, 2) . "</td>
                            <td>" . number_format($c4_normalized, 2) . "</td>
                            <td>" . number_format($c5_normalized, 2) . "</td>
                            <td>" . number_format($c6_normalized, 2) . "</td>
                            <td>" . number_format($c7_normalized, 2) . "</td>
                        </tr>";
                        $no++;
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <h6 class="br-section-label">Data Handphone (Normalized and Utility)</h6>
                <div class="table-wrapper">
                    <table id="datatable3" class="table display responsive nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Handphone</th>
                                <th>C1 (Harga)</th>
                                <th>C2 (RAM)</th>
                                <th>C3 (ROM)</th>
                                <th>C4 (Kamera Depan)</th>
                                <th>C5 (Kamera Belakang)</th>
                                <th>C6 (Jaringan)</th>
                                <th>C7 (Baterai)</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                    $weights = [];
                    $get_weights = mysqli_query($conn, "SELECT nama_kriteria, bobot_kriteria FROM kriteria");
                    while ($row = mysqli_fetch_assoc($get_weights)) {
                        $weights[$row['nama_kriteria']] = $row['bobot_kriteria'];
                    }

                    $get_data = mysqli_query($conn, "select * from handphone where id_handphone IN ($selected_ids)");
                    $no = 1;

                    while ($display = mysqli_fetch_array($get_data)) {
                        // Ekstrak data
                        $nama = $display['nama_handphone'];
                        $c1 = $display['c1'];
                        $c2 = $display['c2'];
                        $c3 = $display['c3'];
                        $c4 = $display['c4'];
                        $c5 = $display['c5'];
                        $c6 = $display['c6'];
                        $c7 = $display['c7'];

                        // Hitung normalisasi untuk masing-masing kriteria
                        $c1_normalized = ($max_values['c1'] - $min_values['c1']) > 0 ? ($c1 - $min_values['c1']) / ($max_values['c1'] - $min_values['c1']) : 0;
                        $c2_normalized = ($max_values['c2'] - $min_values['c2']) > 0 ? ($c2 - $min_values['c2']) / ($max_values['c2'] - $min_values['c2']) : 0;
                        $c3_normalized = ($max_values['c3'] - $min_values['c3']) > 0 ? ($c3 - $min_values['c3']) / ($max_values['c3'] - $min_values['c3']) : 0;
                        $c4_normalized = ($max_values['c4'] - $min_values['c4']) > 0 ? ($c4 - $min_values['c4']) / ($max_values['c4'] - $min_values['c4']) : 0;
                        $c5_normalized = ($max_values['c5'] - $min_values['c5']) > 0 ? ($c5 - $min_values['c5']) / ($max_values['c5'] - $min_values['c5']) : 0;
                        $c6_normalized = ($max_values['c6'] - $min_values['c6']) > 0 ? ($c6 - $min_values['c6']) / ($max_values['c6'] - $min_values['c6']) : 0;
                        $c7_normalized = ($max_values['c7'] - $min_values['c7']) > 0 ? ($c7 - $min_values['c7']) / ($max_values['c7'] - $min_values['c7']) : 0;


                        // Hitung nilai utility berdasarkan nilai normalisasi dan bobot kriteria
                        $utilityC1 = $c1_normalized / $weights['Harga'];
                        $utilityC2 = $c2_normalized / $weights['RAM'];
                        $utilityC3 = $c3_normalized / $weights['ROM'];
                        $utilityC4 = $c4_normalized / $weights['Kamera Depan'];
                        $utilityC5 = $c5_normalized / $weights['Kamera Belakang'];
                        $utilityC6 = $c6_normalized / $weights['Jaringan'];
                        $utilityC7 = $c7_normalized / $weights['Baterai'];

                                            // Menghitung nilai akhir
                        $nilai_akhir = (
                        $utilityC1 + $utilityC2 + $utilityC3 + $utilityC4 + $utilityC5 + $utilityC6 + $utilityC7
                        );
                        // Simpan data untuk ranking
                        $rankings[] = [
                            'nama' => $nama,
                            'nilai_akhir' => $nilai_akhir
                        ];


                        // Tampilkan data dalam tabel
                        echo "<tr>";
                        echo "<td class='text-truncate'>$no</td>";
                        echo "<td class='text-truncate'>$nama</td>";
                        echo "<td class='text-truncate'>" . round($utilityC1, 2) . "</td>";
                        echo "<td class='text-truncate'>" . round($utilityC2, 2) . "</td>";
                        echo "<td class='text-truncate'>" . round($utilityC3, 2) . "</td>";
                        echo "<td class='text-truncate'>" . round($utilityC4, 2) . "</td>";
                        echo "<td class='text-truncate'>" . round($utilityC5, 2) . "</td>";
                        echo "<td class='text-truncate'>" . round($utilityC6, 2) . "</td>";
                        echo "<td class='text-truncate'>" . round($utilityC7, 2) . "</td>";
                        echo "<td class='text-truncate'>" . round($nilai_akhir, 2) . "</td>";
                        echo "</tr>";

                        $no++;
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <h6 class="br-section-label">Ranking Handphone Berdasarkan Nilai Akhir</h6>
                <div class="table-wrapper">
                    <table id="datatable4" class="table display responsive nowrap">
                        <thead>
                            <tr>
                                <th>Ranking</th>
                                <th>Nama Handphone</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                    // Urutkan array ranking berdasarkan nilai akhir (desc)
                    usort($rankings, function($a, $b) {
                        return $b['nilai_akhir'] <=> $a['nilai_akhir'];
                    });

                    $alternatif_nilai_akhir_encoded = [];

                    // Tampilkan tabel ranking
                    $rank = 1;
foreach ($rankings as $rank_data) {
    $nilai_akhir_scaled = $rank_data['nilai_akhir'] * 100;

    // Warna baris: #1 warna emas, sisanya selang-seling abu dan putih
    $row_class = ($rank == 1) ? 'table-warning' : (($rank % 2 == 0) ? 'table-secondary' : 'table-light');

    echo "<tr class='$row_class'>";
    echo "<td class='text-truncate font-weight-bold'>$rank</td>"; // Kolom ranking ditebalkan
    echo "<td class='text-truncate'>{$rank_data['nama']}</td>";
    echo "<td class='text-truncate'>" . round($rank_data['nilai_akhir'], 3) . "</td>";
    echo "</tr>";

    $item = [
        'nama' => $rank_data['nama'],
        'nilai_akhir' => $nilai_akhir_scaled,
        'ranking' => $rank,
    ];

    $alternatif_nilai_akhir_encoded[] = $item;
    $rank++;
}


                    ?>
                        </tbody>
                    </table>
                    <script>
                    var hasilhitungjson = <?php echo json_encode($alternatif_nilai_akhir_encoded); ?>;
                    console.log(hasilhitungjson);
                    </script>
                    <button id="saveButton" style="color: white;" class="btn btn-success mb-4"
                        onclick="saveData()">Save</button>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
            <span>Pilih lebih dari satu handphone untuk melakukan perhitungan.</span>
            <a href="prehitung.php" class="btn btn-primary btn-sm">Kembali</a>
        </div>
        <?php } ?>
        <?php include 'partials/footer.php' ?>
    </div>

    <script src="../assets/lib/jquery/jquery.min.js"></script>
    <script src="../assets/lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="../assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/lib/moment/min/moment.min.js"></script>
    <script src="../assets/lib/peity/jquery.peity.min.js"></script>
    <script src="../assets/lib/rickshaw/vendor/d3.min.js"></script>
    <script src="../assets/lib/rickshaw/vendor/d3.layout.min.js"></script>
    <script src="../assets/lib/rickshaw/rickshaw.min.js"></script>
    <script src="../assets/lib/jquery.flot/jquery.flot.js"></script>
    <script src="../assets/lib/jquery.flot/jquery.flot.resize.js"></script>
    <script src="../assets/lib/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../assets/lib/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="../assets/lib/echarts/echarts.min.js"></script>
    <script src="../assets/lib/select2/js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.dataTables.min.js"></script>
    <script src="../assets/js/ResizeSensor.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <!-- Tambahkan pustaka SweetAlert dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(function() {
        'use strict';

        function initializeDataTable(selector) {
            $(selector).DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });
        }

        // Initialize all DataTables
        initializeDataTable('#datatable1');
        initializeDataTable('#datatable2');
        initializeDataTable('#datatable3');
        initializeDataTable('#datatable4');

        // Select2
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity
        });

    });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var hasilhitung = [];
        const saveButton = document.getElementById('saveButton');
        if (saveButton) {
            console.log('Button Disabled:', saveButton.disabled);
        }

        document.addEventListener("submit", function(event) {
            event.preventDefault();
            saveData(); //Pass hasilhitung
        });

    });

    async function saveData() {
        const date = new Date();
        date.setUTCHours(date.getUTCHours() + 7);
        var data = {
            tanggal: date
        };
        try {
            const response = await fetch('save_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            if (!response.ok) {
                throw new Error('Network response wasn\'t ok');
            }

            const textData = await response.text();
            console.log('Data hasil dari server: ', textData);

            if (textData.trim() == '') {
                console.error('Empty response from server.');
                return;
            }

            // Ensure textData is valid JSON
            let parsedData;
            try {
                parsedData = JSON.parse(textData);
                console.log('Data hasil berhasil di-parse:', parsedData);
            } catch (parseError) {
                console.error('Parsing error:', parseError);
                Swal.fire("Error!", "Response from server is not valid JSON.", "error");
                return;
            }

            var hasilhitung = hasilhitungjson || [];
            document.getElementById('saveButton').disabled = true;
            saveDataDetail(parsedData.last_id, hasilhitung);

            Swal.fire("Success!", "Data berhasil disimpan.", "success");

        } catch (error) {
            console.error('Error:', error);
            Swal.fire("Error!", "Terjadi kesalahan saat menyimpan data.", "error");
        }
    }

    function saveDataDetail(idHasil, hasilhitung) {
        var detailDataArray = [];

        hasilhitung.forEach(rule => {
            var detailData = {
                id_hasil: idHasil,
                nama_alternatif: rule.nama,
                number: rule.nilai_akhir,
                rank: rule.ranking,
            };
            detailDataArray.push(detailData);

        })
        console.log(detailDataArray);

        fetch('save_data_detail.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    detailDataArray
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Data detail hasil successfully saved:', data);
                setTimeout(function() {
                    document.getElementById('saveButton').disabled = true;
                }, 100);
            })
            .catch(error => {
                console.error('Error:', error);
            })
    }
    </script>
</body>

</html>