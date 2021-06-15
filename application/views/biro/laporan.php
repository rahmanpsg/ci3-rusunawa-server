<?php $this->load->view('biro/header') ?>
<!-- PAGE CONTENT-->
<div class="page-content--bgf7" id="app">
    <section class="statistic-chart">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35">{{tag}}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="mr-2 fa fa-book"></i>
                            <strong class="card-title">Laporan</strong>
                        </div>
                        <div class="card-body">
                            <form id="formLaporan" :model="formLaporan" @submit="cetakLaporan">
                                <!-- <input type="hidden" name="id"> -->
                                <div class="form-group row">
                                    <label for="jenis_laporan" class="col-sm-3 col-form-label">Jenis Laporan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="jenis_laporan" data-bv-notempty="true" data-bv-notempty-message="Jenis laporan belum dipilih" v-model="formLaporan.jenis">
                                            <option value="" selected="selected">- Pilih Jenis Laporan -</option>
                                            <option value="penghuni">Daftar Penghuni</option>
                                            <option value="kamar">Daftar Kamar</option>
                                            <option value="transaksi">Daftar Transaksi</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary col-md-12">
                                    <div>
                                        <i class="fa fa-print"></i>
                                        <span>Cetak Laporan</span>
                                    </div>
                                </button>
                            </form>

                            <!-- modal medium -->
                            <div class="modal fade" id="modalCetak" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mediumModalLabel">Cetak Laporan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="laporan"></div>
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
                </div>
            </div>
    </section>

    <?php $this->load->view('biro/footer') ?>
    <script src="<?= base_url('/assets/vendor/moment/moment.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/bootstrap-validator/bootstrapValidator.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/sweetalert/sweetalert.min.js') ?>"></script>
    <!-- <script src="<?= base_url('/assets/vendor/vue/js/vue-dev.js') ?>"></script> -->
    <script src="<?= base_url('/assets/vendor/vue/js/vue.js') ?>"></script>

    <script>
        // Vue.component('v-select', VueSelect.VueSelect)
        new Vue({
            el: '#app',
            data: function() {
                return {
                    tag: 'Daftar Laporan',
                    formLaporan: {
                        jenis: ''
                    }
                }
            },
            mounted() {
                $('#formLaporan').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'fas fa-exclamation-circle',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    excluded: ':disabled'
                })
            },
            methods: {
                cetakLaporan: function() {
                    if (!this.formLaporan.jenis) return

                    const URL = `<?= base_url('laporan/') ?>` + this.formLaporan.jenis
                    const embed = "<embed src='" + URL + "' frameborder='1' width='100%' height='400px'>";

                    $('#modalCetak').modal();
                    $('#laporan').empty();
                    $('#laporan').append(embed);
                }
            }
        })
    </script>
    </body>

    </html>
    <!-- end document-->