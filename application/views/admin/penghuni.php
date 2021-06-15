<?php $this->load->view('admin/header') ?>
<!-- PAGE CONTENT-->
<div class="page-content--bgf7" id="app">

    <!-- STATISTIC CHART-->
    <section class="statistic-chart">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35">Data Penghuni Rusunawa</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2" data-toggle="table" data-url='<?= $TBL_URL ?>' data-pagination="true" data-search="true" data-detail-view="true" data-detail-formatter="detailFormatter" data-unique-id="nim">
                            <thead>
                                <tr>
                                    <th data-field="no" data-formatter="indexFormatter" class="text-center">#</th>
                                    <th data-field="foto" data-formatter="fotoFormatter" class="text-center">Foto</th>
                                    <th data-field="nim">Nim</th>
                                    <th data-field="nama">Nama</th>
                                    <th data-field="telp">Nomor Telpon</th>
                                    <th data-field="jenis_kelamin">Jenis Kelamin</th>
                                    <th data-field="tgl_lahir">Tanggal Lahir</th>
                                    <th data-field="jurusan">Jurusan</th>
                                    <th data-field="detail.semester">Semester</th>
                                    <th data-field="detail.ayah">Ayah</th>
                                    <th data-field="detail.ibu">Ibu</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </section>
    <!-- END STATISTIC CHART-->

    <?php $this->load->view('admin/footer') ?>
    <script src="<?= base_url('/assets/vendor/moment/moment.min.js') ?>"></script>

    <script>
        function indexFormatter(val, row, index) {
            return index + 1;
        }

        function fotoFormatter(val, row) {
            const jk = row.jenis_kelamin == 'Laki-laki' ? 'man.png' : 'woman.png'
            const defaultFoto = `<?= base_url('/assets/img/') ?>${jk}`
            const foto = val

            return `<img src="${foto ? foto : defaultFoto}" style="max-height:100px;">`
        }

        function tglFormatter(val) {
            moment.locale('id')
            return moment(val).format('D MMMM YYYY')
        }

        function detailFormatter(index, row) {
            let tbl = `<h4 class="title-5 m-b-35">Tabel Histori Penghuni</h4>
            <div class="table-responsive table--no-card">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th style="height:30px; padding: 20px; color: white;">ID</th>
                                    <th style="height:30px; padding: 20px; color: white;">Nomor Kamar</th>
                                    <th style="height:30px; padding: 20px; color: white;">Lantai</th>
                                    <th style="height:30px; padding: 20px; color: white;">Tanggal Masuk</th>
                                    <th style="height:30px; padding: 20px; color: white;">Tanggal Keluar</th>
                                </tr>
                            </thead>
                            <tbody>`
            if (row.dataSewa.length == 0) tbl += `<tr><td colspan="5" class="text-center">Belum ada data</td></tr>`

            for (const item of row.dataSewa) {
                tbl += `<tr>
                            <td>${item.id}</td>
                            <td>${item.nomor}</td>
                            <td>${item.lantai}</td>
                            <td>${tglFormatter(item.tanggal_masuk)}</td>
                            <td>${tglFormatter(item.tanggal_keluar)}</td>
                        </tr>`
            }

            tbl += `</tbody>                   
                </table>
            </div>`

            return tbl
        }
    </script>
    </body>

    </html>
    <!-- end document-->