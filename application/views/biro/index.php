<?php $this->load->view('biro/header') ?>
<!-- PAGE CONTENT-->
<div class="page-content--bgf7" id="app">
    <!-- WELCOME-->
    <section class="welcome p-t-10">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-4">Selamat Datang di Aplikasi Pengelolaan Rusunawa UM Parepare
                    </h1>
                    <hr class="line-seprate">
                </div>
            </div>
        </div>
    </section>
    <!-- END WELCOME-->

    <!-- STATISTIC-->
    <section class="statistic statistic2">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-male-female"></i>
                                </div>
                                <div class="text">
                                    <h2><?= $totalPenghuni ?></h2>
                                    <span>Total Penghuni</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <img src="<?= base_url('/assets/images/monkey.png') ?>" width="50px">
                                </div>
                                <div class="text">
                                    <h2><?= empty($totalKategori['putra']) ? 0 : $totalKategori['putra'] ?></h2>
                                    <span>Penghuni Putra</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c4">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <img src="<?= base_url('/assets/images/flower.png') ?>" width="45px">
                                </div>
                                <div class="text">
                                    <h2><?= empty($totalKategori['putri']) ? 0 : $totalKategori['putri'] ?></h2>
                                    <span>Penghuni Putri</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c3">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-local-hotel"></i>
                                </div>
                                <div class="text">
                                    <h2><?= $totalKamar ?></h2>
                                    <span>Total Kamar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END STATISTIC-->

    <!-- STATISTIC CHART-->
    <section class="statistic-chart">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35">Data Kamar Rusunawa UM Parepare</h3>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    {{tag_kategori}}
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item" data-name="putra" @click="dropdownRusunawaChange"><i class="zmdi zmdi-male-alt color-green"></i> Rusunawa Putra</button>
                                    <button class="dropdown-item" data-name="putri" @click="dropdownRusunawaChange"><i class="zmdi zmdi-female color-orange"></i> Rusunawa Putri</button>
                                </div>
                            </h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted m-b-15">
                                <div class="row">
                                    <div class="col-3">
                                        Total Kamar :
                                    </div>
                                    <div class="col">
                                        {{totalKamar.Total}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        Keterangan :
                                    </div>
                                    <div class="col">
                                        <span class="badge badge-kosong">Kosong <span class="badge badge-light">{{totalKamar.Kosong}}</span></span>
                                        <span class="badge badge-terisi">Terisi <span class="badge badge-light">{{totalKamar.Terisi}}</span></span>
                                        <span class="badge badge-penuh">Penuh <span class="badge badge-light">{{totalKamar.Penuh}}</span></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col">
                                        <span class="badge badge-tipeA badge-outlined">Tipe A</span>
                                        <span class="badge badge-tipeB badge-outlined">Tipe B</span>
                                    </div>
                                </div>
                            </p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#lantai1" role="tab" aria-controls="lantai1" aria-expanded="false">
                                        Lantai 1
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#lantai2" role="tab" aria-controls="lantai2" aria-selected="false">Lantai 2</a>
                                </li>
                            </ul>
                            <div class="tab-content pl-3 p-1" id="myTabContent">
                                <div class="tab-pane fade show active" id="lantai1" role="tabpanel" aria-labelledby="lantai1-tab">
                                    <center>
                                        <canvas id="canvas" width="auto" height="812px"></canvas>
                                    </center>
                                </div>
                                <div class="tab-pane fade" id="lantai2" role="tabpanel" aria-labelledby="lantai2-tab">
                                    <center>
                                        <canvas id="canvas2" width="auto" height="812px"></canvas>
                                    </center>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            Detail Kamar
                        </div>
                        <div class="card-body">
                            <div v-if="kamarAktif">
                                <div v-for="(value, name) in detailKamar" class="au-task__item au-task__item--primary">
                                    <div class="au-task__item-inner">
                                        <h5 class="task">
                                            <p class="text-muted m-b-15">
                                                {{name}}
                                            </p>
                                        </h5>
                                        <span class="time">{{value}}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <p class="text-muted m-b-15">
                                    Silahkan klik pada salah satu kamar untuk melihat data
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Histori Penghuni Kamar
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush" id="table" data-toggle="table" data-unique-id="id">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th data-field="no" data-formatter="indexFormatter" class="font-14 text-center">#</th>
                                            <th data-field="nim">Nim</th>
                                            <th data-field="nama">Nama</th>
                                            <th data-field="tanggal_masuk" data-formatter="tglFormatter">Tanggal Masuk</th>
                                            <th data-field="tanggal_keluar" data-formatter="tglFormatter">Tanggal Keluar</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END STATISTIC CHART-->

    <?php $this->load->view('biro/footer') ?>
    <script src="<?= base_url('/assets/js/fabric.js') ?>"></script>
    <!-- <script src="<?= base_url('/assets/vendor/vue/js/vue-dev.js') ?>"></script> -->
    <script src="<?= base_url('/assets/vendor/vue/js/vue.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/moment/moment.min.js') ?>"></script>

    <script>
        function indexFormatter(val, row, index) {
            return index + 1;
        }

        function tglFormatter(val) {
            moment.locale('id')
            return moment(val).format('D MMMM YYYY')
        }
    </script>
    <script>
        new Vue({
            el: '#app',
            data: function() {
                return {
                    tag_kategori: 'Rusunawa Putra',
                    tag_active: 'putra',
                    kamarAktif: false,
                    totalKamar: {
                        Total: 0,
                        Kosong: 0,
                        Terisi: 0,
                        Penuh: 0
                    },
                    detailKamar: {}
                }
            },
            mounted() {
                this.lantai1 = new fabric.Canvas('canvas')
                this.lantai2 = new fabric.Canvas('canvas2')

                this.loadKamar()

                // $table.bootstrapTable()
            },
            created: function() {
                this.grid = 75
                this.backgroundColor = '#edebeb'
                this.lineStroke = '#ebebeb'
                this.kamarKosong = '#2196f3';
                this.kamarTerisi = '#4cd964';
                this.kamarPenuh = '#ff3b30';
                this.kamarTipeA = '#009688'
                this.kamarTipeB = '#cddc39'
                this.kamarSelected = '#000'
                this.kamarShadow = 'rgba(0, 0, 0, 0.4) 3px 3px 7px'

            },
            methods: {
                dropdownRusunawaChange: function() {
                    const target = event.target
                    const name = $(target).data('name')
                    if (name == this.tag_active) return

                    this.kamarAktif = false
                    this.tag_kategori = `Rusunawa ${name.charAt(0).toUpperCase() + name.slice(1)}`
                    this.tag_active = name
                    this.loadKamar()
                    $('#table').bootstrapTable('removeAll')
                },
                initCanvas: function(canvas) {
                    canvas.backgroundColor = this.backgroundColor
                    canvas.observe('object:selected', this.klikKamar)
                },
                klikKamar: function(e) {
                    const {
                        id,
                        number,
                        jumlah,
                        total,
                        status,
                        tipe
                    } = e.target;

                    const detailKamar = {
                        Nomor: number,
                        Tipe: tipe,
                        Keterangan: status ? status : 'Kosong'
                    }

                    if (jumlah > 0 && jumlah < total) {
                        detailKamar['Keterangan'] += ` ${jumlah} orang`
                        detailKamar[`Informasi`] = `Kamar masih bisa diisi ${total - jumlah} orang`
                    }

                    this.detailKamar = detailKamar
                    this.kamarAktif = true

                    $('#table').bootstrapTable('refreshOptions', {
                        url: '<?= base_url('apiServer/penghuniKamar?id=') ?>' + id
                    })

                },
                tambahKamar: function(canvas, id, status, jumlah, total, nomor, tipe, left, top, width, height, angle =
                    0) {
                    const o = new fabric.Rect({
                        width: width,
                        height: height,
                        // fill: (!reserved ? this.tableFill : this.tableFillReserv),
                        fill: (status == 'Terisi' ? this.kamarTerisi : status == 'Penuh' ? this.kamarPenuh :
                            this.kamarKosong),
                        stroke: (tipe == 'A' ? this.kamarTipeA : this.kamarTipeB),
                        strokeWidth: 4,
                        shadow: this.kamarShadow,
                        originX: 'center',
                        originY: 'center',
                        centeredRotation: true,
                        snapAngle: 45,
                        selectable: false
                    })

                    o.set('angle', angle);

                    const t = new fabric.IText(nomor.toString(), {
                        fontFamily: 'Calibri',
                        fontSize: 14,
                        fill: '#fff',
                        textAlign: 'center',
                        originX: 'center',
                        originY: 'center'
                    })
                    const g = new fabric.Group([o, t], {
                        left: left,
                        top: top,
                        centeredRotation: true,
                        snapAngle: 45,
                        selectable: true,
                        type: 'table',
                        id: id,
                        number: nomor,
                        tipe,
                        jumlah,
                        total,
                        status,
                        hasControls: false,
                        lockMovementX: true,
                        lockMovementY: true,
                        borderColor: this.kamarSelected,
                        borderScaleFactor: 2.5
                    })

                    canvas.add(g)
                    return g
                },
                sendLinesToBack: function(canvas) {
                    canvas.getObjects().map(o => {
                        if (o.type === 'line') {
                            canvas.sendToBack(o)
                        }
                    })
                },
                loadKamar: function() {
                    this.lantai1.clear()
                    this.lantai2.clear()

                    this.initCanvas(this.lantai1)
                    this.initCanvas(this.lantai2)

                    const data = {
                        kategori: this.tag_active
                    }

                    $.ajax(`<?= base_url('api/loadKamar') ?>`, {
                        data
                    }).then(res => {
                        const totalKamar = {
                            Total: res.length,
                            Kosong: res.length,
                            Terisi: 0,
                            Penuh: 0
                        }

                        for (let item of res) {
                            const {
                                id,
                                lantai,
                                nomor,
                                tipe,
                                jumlah,
                                status,
                                total
                            } = item;

                            if (status) {
                                totalKamar[status]++
                                totalKamar['Kosong']--
                            }

                            const {
                                left,
                                top,
                                width,
                                height,
                                angle
                            } = JSON.parse(item.attribut);

                            this.tambahKamar(lantai == 1 ? this.lantai1 : this.lantai2, id, status, jumlah,
                                total,
                                nomor,
                                tipe,
                                left,
                                top,
                                width,
                                height,
                                angle)
                        }

                        this.totalKamar = totalKamar

                        this.lantai1.selection = false
                        this.lantai1.hoverCursor = 'move'
                        this.lantai2.selection = false
                        this.lantai2.hoverCursor = 'move'
                    })
                }
            }
        })
    </script>
    </body>

    </html>
    <!-- end document-->