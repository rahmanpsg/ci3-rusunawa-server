<?php
class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('Pdf');
        $this->db->query("SET sql_mode = '' ");
    }

    public function penghuni()
    {
        $this->db->select('a.nim, a.nama, a.jurusan, a.telp, a.jenis_kelamin, a.tgl_lahir, a.detail');
        $get = $this->db->get('tbl_user a')->result();

        $data = array_map(
            function ($v) {
                $v->detail = json_decode($v->detail);
                return $v;
            },
            $get
        );

        $pdf = new Pdf('L', 'mm', 'LEGAL');

        $this->createHeader($pdf, 'LAPORAN DAFTAR PENGHUNI');

        $pdf->cell(1);
        $pdf->Cell(10, 11, 'NO', 1, 0, 'C');
        $pdf->Cell(40, 11, 'NIM', 1, 0, 'C');
        $pdf->cell(60, 11, 'NAMA', 1, 0, 'C');
        $pdf->cell(45, 11, 'NOMOR TELPON', 1, 0, 'C');
        $pdf->Cell(45, 11, 'TANGGAL LAHIR', 1, 0, 'C');
        $pdf->Cell(45, 11, 'JENIS KELAMIN', 1, 0, 'C');
        $pdf->Cell(50, 11, 'JURUSAN', 1, 0, 'C');
        $pdf->Cell(30, 11, 'SEMESTER', 1, 1, 'C');

        $pdf->SetFont('Times', '', 12);

        $no = 1;

        foreach ($data as  $val) {
            $pdf->cell(1);
            $pdf->Cell(10, 11, $no++, 1, 0, 'C');
            $pdf->Cell(40, 11, $val->nim, 1, 0, 'C');
            $pdf->cell(60, 11, ucwords($val->nama), 1, 0);
            $pdf->cell(45, 11, $val->telp, 1, 0, 'C');
            $pdf->Cell(45, 11, $val->tgl_lahir, 1, 0, 'C');
            $pdf->Cell(45, 11, $val->jenis_kelamin, 1, 0, 'C');
            $pdf->Cell(50, 11, ucwords($val->jurusan), 1, 0, 'C');
            $pdf->Cell(30, 11, empty($val->detail) ? '-' : $val->detail->semester, 1, 1, 'C');
        }

        $pdf->Output("Daftar Penghuni", 'I');
    }

    public function kamar()
    {
        $this->db->select('id, nomor, lantai, total, tipe, kategori');
        $this->db->order_by('kategori');
        $this->db->order_by('lantai');
        $this->db->order_by('nomor');
        $get = $this->db->get('tbl_kamar')->result();

        $data = array_map(
            function ($k) {
                $id = $k->id;
                $dataSewa = $this->db->query("SELECT COUNT(a.id_kamar) jumlah, IF(COUNT(a.id_kamar) < b.total, 'Terisi', 'Penuh') status FROM tbl_sewa a RIGHT JOIN tbl_kamar b ON a.id_kamar = b.id WHERE a.tanggal_keluar >= NOW() AND a.status = 'Sukses' AND a.id_kamar = '$id' GROUP BY a.id_kamar");

                $k->keterangan = 'Kosong';

                if ($dataSewa->num_rows() > 0) {
                    $s = $dataSewa->result()[0];
                    $k->status = $s->status;
                    $k->jumlah = $s->jumlah;
                    $k->keterangan = $s->status == 'Terisi' ? "{$s->status} {$k->jumlah} orang" : $s->status;
                }

                return $k;
            },
            $get
        );

        // print_r($data);

        $pdf = new Pdf('L', 'mm', 'LEGAL');

        $this->createHeader($pdf, 'LAPORAN DAFTAR KAMAR');

        $pdf->cell(50);
        $pdf->Cell(10, 11, 'NO', 1, 0, 'C');
        $pdf->cell(60, 11, 'RUSUNAWA', 1, 0, 'C');
        $pdf->Cell(40, 11, 'NOMOR KAMAR', 1, 0, 'C');
        $pdf->Cell(40, 11, 'LANTAI', 1, 0, 'C');
        $pdf->Cell(40, 11, 'TIPE', 1, 0, 'C');
        $pdf->Cell(40, 11, 'KETERANGAN', 1, 1, 'C');

        $pdf->SetFont('Times', '', 12);

        $no = 1;

        foreach ($data as $val) {
            $pdf->cell(50);
            $pdf->Cell(10, 11, $no++, 1, 0, 'C');
            $pdf->cell(60, 11, ucfirst($val->kategori), 1, 0, 'C');
            $pdf->Cell(40, 11, $val->nomor, 1, 0, 'C');
            $pdf->Cell(40, 11, $val->lantai, 1, 0, 'C');
            $pdf->Cell(40, 11, $val->tipe, 1, 0, 'C');
            $pdf->Cell(40, 11, $val->keterangan, 1, 1, 'C');
        }

        $pdf->Output("Daftar Kamar", 'I');
    }

    public function transaksi()
    {
        $this->db->select("a.nim, DATE_FORMAT(a.tanggal_masuk, '%d/%c/%Y') tanggal_masuk, DATE_FORMAT(a.tanggal_keluar, '%d/%c/%Y') tanggal_keluar, a.pembayaran, a.status, b.nama, c.nomor, c.lantai");
        $this->db->from('tbl_sewa a');
        $this->db->join('tbl_user b', 'a.nim = b.nim', 'left');
        $this->db->join('tbl_kamar c', 'a.id_kamar = c.id', 'left');
        $this->db->order_by('a.ditambahkan_pada', 'DESC');
        $data = $this->db->get()->result();

        $pdf = new Pdf('L', 'mm', 'LEGAL');

        $this->createHeader($pdf, 'LAPORAN DAFTAR TRANSAKSI');

        $pdf->cell(1);
        $pdf->Cell(10, 11, 'NO', 1, 0, 'C');
        $pdf->Cell(35, 11, 'NIM', 1, 0, 'C');
        $pdf->cell(50, 11, 'NAMA', 1, 0, 'C');
        $pdf->cell(40, 11, 'NOMOR KAMAR', 1, 0, 'C');
        $pdf->Cell(30, 11, 'LANTAI', 1, 0, 'C');
        $pdf->Cell(40, 11, 'PEMBAYARAN', 1, 0, 'C');
        $pdf->Cell(45, 11, 'TANGGAL MASUK', 1, 0, 'C');
        $pdf->Cell(45, 11, 'TANGGAL KELUAR', 1, 0, 'C');
        $pdf->Cell(40, 11, 'STATUS', 1, 1, 'C');

        $pdf->SetFont('Times', '', 12);

        $no = 1;

        foreach ($data as $val) {
            $pdf->cell(1);
            $pdf->Cell(10, 11, $no++, 1, 0, 'C');
            $pdf->Cell(35, 11, $val->nim, 1, 0, 'C');
            $pdf->cell(50, 11, ucwords($val->nama), 1, 0, 'C');
            $pdf->cell(40, 11, $val->nomor, 1, 0, 'C');
            $pdf->Cell(30, 11, $val->lantai, 1, 0, 'C');
            $pdf->Cell(40, 11, $val->pembayaran, 1, 0, 'C');
            $pdf->Cell(45, 11, $val->tanggal_masuk, 1, 0, 'C');
            $pdf->Cell(45, 11, $val->tanggal_keluar, 1, 0, 'C');
            $pdf->Cell(40, 11, $val->status, 1, 1, 'C');
        }

        $pdf->Output("Daftar Transaksi", 'I');
    }

    function createHeader($pdf, $text)
    {
        $pdf->setFontSubsetting(true);

        $pdf->AddPage();

        $image_file = base_url('assets/images/logo.png');

        $pdf->Image($image_file, 45, 6, 20, 20, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
        // Set font
        $pdf->SetFont('helvetica', 'B', 25);
        // Title
        $pdf->SetXY(0, 0);
        $pdf->Cell(0, 25, 'Rusunawa Universitas Muhammadiyah Parepare', 0, false, 'C', 0);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetXY(0, 0);
        $pdf->Cell(0, 40, 'Lapadde, Kec. Ujung, Kota Pare-Pare, Sulawesi Selatan 91112, Indonesia', 0, false, 'C', 0);

        $pdf->SetDrawColor(150, 150, 150);
        $pdf->SetLineWidth(1);
        $pdf->Line(5, 31, 350, 31);
        $pdf->SetLineWidth(0);
        $pdf->Line(5, 32, 350, 32);

        $pdf->ln(35);

        $pdf->SetFont('helvetica', 'B', 12, '', true);
        $pdf->cell(0, 0, $text, 0, 1, 'C');

        $pdf->ln();

        $pdf->SetFont('Times', 'B', 12);
    }
}
