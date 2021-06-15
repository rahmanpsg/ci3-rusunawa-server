<?php $this->load->view('admin/header') ?>
<link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-validator/bootstrapValidator.min.css') ?>">
<!-- PAGE CONTENT-->
<div class="page-content--bgf7" id="app">

    <!-- STATISTIC CHART-->
    <section class="statistic-chart">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-5 m-b-35">Pengaturan Kamar Rusunawa</h3>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-5">
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
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#lantai1" role="tab" aria-controls="lantai1" aria-expanded="false" @click="lantaiAktif = 1">
                                        Lantai 1
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#lantai2" role="tab" aria-controls="lantai2" aria-selected="false" @click="lantaiAktif = 2">Lantai 2</a>
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

                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <strong>Detail</strong>
                            <small> Form</small>
                        </div>
                        <div class="card-body card-block">
                            <div class="table-data__tool">
                                <div class="table-data__tool-right">
                                    <button class="au-btn au-btn-icon au-btn--blue2 au-btn--small" @click="tambahKamar" :disabled="kamarAktif" id="btnTambah">
                                        <i class="zmdi zmdi-plus"></i>Tambah Kamar</button>
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small" :disabled="!kamarAktif" @click="ubahKamar">
                                        <i class="zmdi zmdi-edit"></i>Ubah Kamar</button>
                                    <button class="au-btn au-btn-icon au-btn--red au-btn--small" @click="hapusKamar" :disabled="!kamarAktif">
                                        <i class="zmdi zmdi-delete"></i>Hapus Kamar</button>
                                    <button v-show="kamarAktif || onTambah" class="au-btn au-btn-icon au-btn--orange au-btn--small" @click="batalKlik">
                                        <i class="zmdi zmdi-block"></i>Batal</button>
                                </div>
                            </div>
                            <form id="detailKamar" onsubmit="return false">
                                <div class="form-group">
                                    <label for="nomor" class=" form-control-label">Nomor Kamar</label>
                                    <input type="number" name="nomor" placeholder="Masukkan nomor kamar" class="form-control" data-bv-notempty="true" data-bv-notempty-message="Nomor kamar tidak boleh kosong" :readonly="onTambah">
                                </div>
                                <div class="form-group">
                                    <label for="tipe" class=" form-control-label">Tipe</label>
                                    <select name="tipe" name="tipe" class="form-control" data-bv-notempty="true" data-bv-notempty-message="Tipe kamar belum dipilih" :readonly="onTambah">
                                        <option value="">Pilih tipe kamar</option>
                                        <option value="A">Tipe A</option>
                                        <option value="B">Tipe B</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="lantai" class=" form-control-label">Maksimal Penghuni</label>
                                    <input type="number" name="total" placeholder="Masukkan total penghuni" class="form-control" data-bv-notempty="true" data-bv-notempty-message="Data tidak boleh kosong" :readonly="onTambah">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END STATISTIC CHART-->

    <?php $this->load->view('admin/footer') ?>
    <script src="<?= base_url('/assets/js/fabric.js') ?>"></script>
    <!-- <script src="<?= base_url('/assets/vendor/vue/js/vue-dev.js') ?>"></script> -->
    <script src="<?= base_url('/assets/vendor/vue/js/vue.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/moment/moment.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/jquery.formHelper.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/bootstrap-validator/bootstrapValidator.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/sweetalert/sweetalert.min.js') ?>"></script>

    <script>
        new Vue({
            el: '#app',
            data: function() {
                return {
                    tag_kategori: 'Rusunawa Putra',
                    tag_active: 'putra',
                    lantaiAktif: 1,
                    kamarAktif: false,
                    idKamarAktif: '',
                    onTambah: false,
                    totalKamar: {
                        Total: 0,
                        Kosong: 0,
                        Terisi: 0,
                        Penuh: 0
                    }
                }
            },
            mounted() {
                this.lantai1 = new fabric.Canvas('canvas')
                this.lantai2 = new fabric.Canvas('canvas2')
                this.lantai1.observe('object:selected', this.klikKamar)
                this.lantai2.observe('object:selected', this.klikKamar)

                this.loadKamar()

                $('#detailKamar').bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'fas fa-exclamation-circle',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    excluded: ':disabled'
                })
            },
            created: function() {
                this.grid = 75
                this.backgroundColor = '#edebeb'
                this.lineStroke = '#ebebeb'
                this.kamarKosong = '#2196f3';
                this.kamarTipeA = '#009688'
                this.kamarTipeB = '#cddc39'
                this.kamarSelected = '#000'
                this.kamarShadow = 'rgba(0, 0, 0, 0.4) 3px 3px 7px'

            },
            methods: {
                generateID: function() {
                    return '_' + Math.random().toString(36).substr(2, 9);
                },
                submitFormDetailKamar: function() {
                    const $detailKamar = $('#detailKamar')

                    $detailKamar.submit()

                    const hasErr = $detailKamar.find(".has-error").length;

                    if (hasErr > 0) return

                    const data = $detailKamar.serializeArray();

                    let detailKamar = {}

                    data.map(v => {
                        detailKamar[v.name] = v.value
                    })

                    return detailKamar
                },
                getAttributKamar: function() {
                    let oCoords = this.activeObject.item(1).group.oCoords

                    switch (this.activeObject.getAngle()) {
                        case 0:
                            oCoords = oCoords.tl
                            break;
                        case 90:
                            oCoords = oCoords.bl
                            break;
                        case 270:
                            oCoords = oCoords.tr
                            break;
                        case 180:
                            oCoords = oCoords.br
                            break;
                    }

                    return JSON.stringify({
                        left: oCoords.x,
                        top: oCoords.y,
                        width: this.activeObject.get('width') * this.activeObject.scaleX,
                        height: this.activeObject.get('height') * this.activeObject.scaleY,
                        angle: this.activeObject.getAngle()
                    })
                },
                tambahKamar: function() {
                    let detailKamar = this.submitFormDetailKamar()

                    if (!detailKamar) return

                    if (!this.onTambah) {
                        const id = this.generateID()
                        this.idKamarAktif = id

                        this.addKamar(this.lantaiAktif, id,
                            detailKamar.total,
                            detailKamar.nomor,
                            detailKamar.tipe)

                        this.onTambah = true
                        $('#btnTambah').html('<i class="zmdi zmdi-save"></i>Simpan')
                        const canvas = this.lantaiAktif == 1 ? this.lantai1 : this.lantai2
                        canvas.setActiveObject(canvas.getItemById(this.idKamarAktif));
                        return
                    }

                    detailKamar['id'] = this.idKamarAktif
                    detailKamar['kategori'] = this.tag_active
                    detailKamar['lantai'] = this.lantaiAktif
                    detailKamar['attribut'] = this.getAttributKamar()

                    swal({
                            text: `Kamar akan disimpan?`,
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
                            if (simpan == null) return

                            $.ajax('<?= base_url('apiServer/kamar') ?>', {
                                method: 'post',
                                data: detailKamar
                            }).then(res => {
                                swal(res.message, {
                                    icon: res.error ? 'error' : 'success',
                                    buttons: false,
                                    timer: 1000,
                                });

                                if (res.error) return

                                $('#btnTambah').html('<i class="zmdi zmdi-plus"></i>Tambah Kamar')
                                this.onTambah = false
                                this.canvas.discardActiveObject().renderAll()
                                $('#detailKamar').trigger('reset')
                            })
                        })
                },
                ubahKamar: function() {
                    let detailKamar = this.submitFormDetailKamar()

                    if (!detailKamar) return

                    swal({
                        text: `Kamar nomor ${detailKamar.nomor} akan diubah?`,
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
                    }).then(update => {
                        if (update == null) return

                        detailKamar['id'] = this.activeObject.get('id')
                        detailKamar['attribut'] = this.getAttributKamar()

                        $.ajax('<?= base_url('apiServer/updateKamar') ?>', {
                            method: 'post',
                            data: detailKamar
                        }).then(res => {
                            swal(res.message, {
                                icon: res.error ? 'error' : 'success',
                                buttons: false,
                                timer: 1000,
                            });

                            if (res.error) return
                            this.activeObject.set({
                                number: detailKamar.nomor,
                                tipe: detailKamar.tipe,
                                total: detailKamar.total
                            })
                            this.activeObject.item(0).set({
                                stroke: (detailKamar.tipe == 'A' ? this.kamarTipeA : this.kamarTipeB),
                            })
                            this.activeObject.item(1).setText(detailKamar.nomor)

                            this.kamarAktif = false
                            this.canvas.discardActiveObject().renderAll()
                            $('#detailKamar').trigger('reset')
                        })
                    })
                },
                hapusKamar: function() {
                    if (!this.activeObject) return

                    swal({
                        text: `Yakin untuk menghapus kamar nomor ${this.activeObject.get('number')} ?`,
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
                    }).then(hapus => {
                        if (hapus == null) return

                        $.ajax('<?= base_url('apiServer/deleteKamar') ?>', {
                            method: 'post',
                            data: {
                                id: this.activeObject.get('id')
                            }
                        }).then(res => {
                            swal(res.message, {
                                icon: res.error ? 'error' : 'success',
                                buttons: false,
                                timer: 1000,
                            });

                            if (res.error) return

                            this.canvas.remove(this.activeObject);
                            this.kamarAktif = false
                            $('#detailKamar').trigger('reset')
                        })
                    })

                },
                batalKlik: function() {
                    this.kamarAktif = false
                    $('#detailKamar').bootstrapValidator('resetForm', true);

                    if (this.onTambah) {
                        this.canvas.remove(this.activeObject)
                        this.onTambah = false
                        $('#btnTambah').html('<i class="zmdi zmdi-plus"></i>Tambah Kamar')
                        return
                    }

                    this.canvas.discardActiveObject().renderAll()
                },
                dropdownRusunawaChange: function() {
                    const target = event.target
                    const name = $(target).data('name')
                    if (name == this.tag_active) return

                    this.kamarAktif = false
                    $('#detailKamar').trigger('reset')
                    this.tag_kategori = `Rusunawa ${name.charAt(0).toUpperCase() + name.slice(1)}`
                    this.tag_active = name
                    this.loadKamar()
                },
                klikKamar: function(e) {
                    this.canvas = this.lantaiAktif == 1 ? this.lantai1 : this.lantai2
                    this.activeObject = this.canvas.getActiveObject()

                    if (this.onTambah) return

                    const {
                        id,
                        number,
                        total,
                        tipe,
                    } = e.target;

                    const detailKamar = {
                        id,
                        nomor: number,
                        tipe,
                        total
                    }

                    $('#detailKamar').bootstrapValidator('resetForm', true);
                    $('#detailKamar').populateForm(detailKamar)

                    this.kamarAktif = true
                },
                addKamar: function(lantai, id, total, nomor, tipe, left = 100, top = 100, width = 68, height = 48, angle =
                    0) {
                    const canvas = lantai == 1 ? this.lantai1 : this.lantai2
                    const o = new fabric.Rect({
                        width,
                        height,
                        fill: this.kamarKosong,
                        stroke: (tipe == 'A' ? this.kamarTipeA : this.kamarTipeB),
                        strokeWidth: 4,
                        shadow: this.kamarShadow,
                        originX: 'center',
                        originY: 'center',
                        centeredRotation: true,
                        snapAngle: 90,
                        selectable: false,
                        angle
                    })

                    const t = new fabric.IText(nomor.toString(), {
                        fontFamily: 'Calibri',
                        fontSize: 14,
                        fill: '#fff',
                        textAlign: 'center',
                        originX: 'center',
                        originY: 'center'
                    })
                    const g = new fabric.Group([o, t], {
                        left,
                        top,
                        centeredRotation: true,
                        snapAngle: 90,
                        selectable: true,
                        type: 'table',
                        lantai,
                        id,
                        number: nomor,
                        tipe,
                        total,
                        hasControls: true,
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

                    this.lantai1.backgroundColor = this.backgroundColor
                    this.lantai2.backgroundColor = this.backgroundColor

                    const data = {
                        kategori: this.tag_active
                    }

                    $.ajax(`<?= base_url('api/loadKamar') ?>`, {
                        data
                    }).then(res => {
                        for (let item of res) {
                            const {
                                id,
                                lantai,
                                nomor,
                                tipe,
                                total
                            } = item;

                            const {
                                left,
                                top,
                                width,
                                height,
                                angle
                            } = JSON.parse(item.attribut);

                            this.addKamar(lantai, id,
                                total,
                                nomor,
                                tipe,
                                left,
                                top,
                                width,
                                height,
                                angle)
                        }

                        this.lantai1.selection = false
                        this.lantai1.hoverCursor = 'move'
                        this.lantai2.selection = false
                        this.lantai2.hoverCursor = 'move'
                    })
                }
            }
        })

        fabric.Canvas.prototype.getItemById = function(id) {
            var object = null,
                objects = this.getObjects();

            for (var i = 0, len = this.size(); i < len; i++) {
                if (objects[i].id && objects[i].id === id) {
                    object = objects[i];
                    break;
                }
            }

            return object;
        };
    </script>
    </body>

    </html>
    <!-- end document-->