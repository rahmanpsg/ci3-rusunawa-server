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
                    <div class="table-responsive table-responsive-data2 table-data">
                        <table id="table" class="table table-data2" data-toggle="table" data-url='<?= $TBL_URL ?>' data-pagination="true" data-search="true" data-detail-view="true" data-detail-formatter="detailFormatter" data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="no" data-formatter="indexFormatter" class="text-center">#</th>
                                    <th data-field="id">ID</th>
                                    <th data-field="ditambahkan_pada" data-formatter="tglFormatter" data-sortable="true">Tanggal</th>
                                    <th data-field="pembayaran">Pembayaran</th>
                                    <th data-field="nama" data-formatter="namaFormatter">Nama</th>
                                    <th data-field="status" data-cell-style="cellStyle" data-sortable="true">Status</th>
                                    <th data-field="total_bayar" data-sortable="true">Total</th>
                                    <th data-formatter="aksiFormatter" data-events="window.aksiEvents"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->

                    <!-- modal medium -->
                    <div class="modal fade" id="modalBukti" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mediumModalLabel">Bukti Pembayaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="buktiPembayaran"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                        <!-- end modal medium -->
                    </div>
                </div>
            </div>
    </section>
    <!-- END STATISTIC CHART-->

    <?php $this->load->view('admin/footer') ?>
    <script src="<?= base_url('/assets/vendor/moment/moment.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/sweetalert/sweetalert.min.js') ?>"></script>

    <script>
        function indexFormatter(val, row, index) {
            return index + 1;
        }

        function tglFormatter(val) {
            moment.locale('id')
            return moment(val).format('DD/MM/YYYY HH:mm')
        }

        function namaFormatter(val) {
            return (val + '')
                .replace(/^(.)|\s+(.)/g, function($1) {
                    return $1.toUpperCase()
                })
        }

        function detailFormatter(index, row) {
            moment.locale('id');

            let html = `<div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><b>Rusunawa</b></td>
                                    <td>${row.kategori.toUpperCase()}</td>
                                </tr>
                                <tr>
                                    <td><b>Nomor Kamar</b></td>
                                    <td>${row.nomor}</td>
                                </tr>
                                <tr>
                                    <td><b>Lantai</b></td>
                                    <td>${row.lantai}</td>
                                </tr>
                                <tr>
                                    <td><b>Tanggal Masuk</b></td>
                                    <td>${moment(row.tanggal_masuk).format('D MMMM YYYY')}</td>
                                </tr>
                                <tr>
                                    <td><b>Tanggal Keluar</b></td>
                                    <td>${moment(row.tanggal_keluar).format('D MMMM YYYY')}</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>`

            return html
        }

        function cellStyle(value, row, index) {
            let style = {
                css: {}
            };
            switch (value) {
                case 'Belum diupload':
                    style.css.color = '#f5f11d'
                    break;
                case 'Menunggu konfirmasi':
                    style.css.color = '#0ff2ee'
                    break;
                case 'Sukses':
                    style.css.color = '#00ad5f'
                    break;
                default:
                    style.css.color = '#fa4251'
                    break;
            }

            return style
        }

        function aksiFormatter(val, row) {
            let html = [`<a data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="more"><i class="zmdi zmdi-more-vert"></i></span>
                    </a>
                    <div class="dropdown-menu">`]

            switch (row.status) {
                case 'Menunggu konfirmasi':
                    html.push(`<button class="dropdown-item lihat"><i class="zmdi zmdi-eye"></i> Lihat bukti pembayaran</button>
                                <button class="dropdown-item konfirmasi"><i class="zmdi zmdi-check-all color-blue"></i> Konfirmasi</button>
                                <button class="dropdown-item tolak"><i class="zmdi zmdi-close color-orange"></i> Tolak</button>`)
                    break;
                case 'Sukses':
                    html.push(`<a class="dropdown-item">Selesai</a>`)
                    break;
                default:
                    html.push(`<a class="dropdown-item">Tidak ada aksi</a>`)
                    break;
            }

            return html.join(' ')
        }
        window.aksiEvents = {
            'click .lihat': function(e, value, row, index) {
                const URL = `<?= base_url('apiServer/buktiPembayaran?id=') ?>` + row.id
                const embed = "<embed src='" + URL + "' frameborder='1' width='100%' height='400px'>";

                $('#modalBukti').modal();
                $('#buktiPembayaran').empty();
                $('#buktiPembayaran').append(embed);
            },
            'click .konfirmasi': function(e, value, row, index) {
                setAksi('konfirmasi', row.id, row.nim)
            },
            'click .tolak': function(e, value, row, index) {
                setAksi('tolak', row.id, row.nim)
            }
        }

        function setAksi(status, id, nim) {
            const newStatus = (status == 'konfirmasi' ? 'Sukses' : 'Ditolak');

            swal({
                    text: `Pembayaran akan di${status}?`,
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Batal",
                            value: null,
                            visible: true
                        },
                        confirm: {
                            text: "OK",
                            closeModal: false
                        }
                    }
                })
                .then(simpan => {
                    if (simpan !== null) {
                        const send = {
                            id,
                            status: newStatus,
                            nim
                        }

                        $.ajax('<?= base_url('apiServer/konfirmasiPesanan') ?>', {
                            method: 'post',
                            data: send
                        }).then(res => {
                            swal(res.message, {
                                icon: res.error ? 'error' : 'success',
                                buttons: false,
                                timer: 1000,
                            });

                            if (res.error) return

                            $('#table').bootstrapTable('updateByUniqueId', {
                                id,
                                row: {
                                    status: newStatus
                                }
                            });

                        }).catch(err => {
                            console.log(err);
                            if (err) {
                                swal("Terjadi masalah di server", "The AJAX request failed!", "error");
                            } else {
                                swal.stopLoading();
                                swal.close();
                            }
                        });
                    }
                })
        }
    </script>
    </body>

    </html>
    <!-- end document-->