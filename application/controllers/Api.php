<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->db->query("SET sql_mode = '' ");
    }

    public function index_get()
    {
        $this->response(['message' => 'Halo Bosku'], 200);
    }
    // -----------------------------------------------------------------------------------------------------------
    public function login_post()
    {
        $nim = $this->post('nim');
        $password = $this->post('password');

        if ($nim === null || $password === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $where = ['nim' => $nim, 'password' => $password];

        $this->db->select('nama, jenis_kelamin');
        $cek = $this->db->get_where('tbl_user', $where);

        if ($cek->num_rows() > 0) {
            $res = $cek->result()[0];
            $nama = $res->nama;
            $kategori = $res->jenis_kelamin == 'Perempuan' ? 'putri' : 'putra';
            $this->response(['error' => false, 'message' => "Selamat datang $nama", 'kategori' => $kategori, 'nama' => $nama], 200);
        }

        $this->response(['error' => true, 'message' => 'Nim atau password salah'], 200);
    }
    // -----------------------------------------------------------------------------------------------------------
    public function registrasi_post()
    {
        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }

        //
        $data['nama'] = ucwords($data['nama']);
        $data['jurusan'] = ucwords($data['jurusan']);

        $data['ditambahkan_pada'] = $this->Model->getWaktu();

        $simpan = $this->db->insert('tbl_user', $data);

        if ($simpan) {
            $this->response(['error' => false, 'message' => 'Akun berhasil diregistrasi'], 200);
        }
        $this->response(['error' => true, 'message' => 'Akun gagal diregistrasi'], 200);
    }
    // -----------------------------------------------------------------------------------------------------------
    public function cekData_get()
    {
        $nim = $this->get('nim');

        if ($nim === null) {
            $this->response(['message' => 'Akses ditolak'], 502);
        }

        $cek = $this->Model->cekData('tbl_user', ['nim' => $nim]);

        if ($cek > 0) {
            $this->response(['error' => true, 'message' => 'Nim telah digunakan'], 200);
        }

        $this->response(['error' => false, 'message' => 'Nim belum digunakan'], 200);
    }
    // -----------------------------------------------------------------------------------------------------------    
    public function loadKamar_get()
    {
        $kategori = $this->get('kategori');

        if ($kategori === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $dataKamar = $this->db->get_where('tbl_kamar', ['kategori' => $kategori])->result();

        $data = array_map(function ($k) use ($kategori) {
            $id = $k->id;
            $dataSewa = $this->db->query("SELECT COUNT(a.id_kamar) jumlah, IF(COUNT(a.id_kamar) < b.total, 'Terisi', 'Penuh') status FROM tbl_sewa a RIGHT JOIN tbl_kamar b ON a.id_kamar = b.id WHERE a.tanggal_keluar >= NOW() AND a.status = 'Sukses' AND a.id_kamar = '$id' AND b.kategori = '$kategori' GROUP BY a.id_kamar");

            if ($dataSewa->num_rows() > 0) {
                $s = $dataSewa->result()[0];
                $k->status = $s->status;
                $k->jumlah = $s->jumlah;
            }

            return $k;
        }, $dataKamar);

        $this->response($data, 200);
    }
    // -----------------------------------------------------------------------------------------------------------  
    public function totalKamar_get()
    {
        $totalKamarPutra = $this->Model->cekData('tbl_kamar', ['kategori' => 'putra']);
        $totalKamarPutri = $this->Model->cekData('tbl_kamar', ['kategori' => 'putri']);

        $this->response(['totalKamarPutra' => $totalKamarPutra, 'totalKamarPutri' => $totalKamarPutri], 200);
    }
    // -----------------------------------------------------------------------------------------------------------  
    public function pembayaran_post()
    {
        $dataSewa = $this->post('dataSewa');
        $dataUser = $this->post('dataUser');

        $dataSewa['total_bayar'] += $this->Model->getRandomNumber(3); //Generate Code Unique
        $dataSewa['ditambahkan_pada'] = $this->Model->getWaktu();
        $dataSewa['diubah_pada'] = $this->Model->getWaktu();

        // Simpan data Sewa
        $simpan = $this->db->insert('tbl_sewa', $dataSewa);

        // Update data user
        $this->db->set('detail', json_encode($dataUser));
        $this->db->where('nim', $dataSewa['nim']);
        $update = $this->db->update('tbl_user');

        if (!$simpan || !$update) {
            $this->response(['error' => true, 'message' => 'Data gagal proses'], 200);
        }

        $this->response(['error' => false, 'message' => 'Pendaftaran berhasil'], 200);
    }
    public function pembayaran_get()
    {
        $id = $this->get('id');

        if ($id === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $this->db->select("id_kamar, CONCAT('Rp ', FORMAT(total_bayar, 0)) as total_bayar, DATE_ADD(ditambahkan_pada, INTERVAL 1 DAY) as waktuBerakhir, IF(DATE_ADD(ditambahkan_pada, INTERVAL 1 DAY) <= NOW(), 'Expired', status) as status");
        $dataPembayaran = $this->db->get_where('tbl_sewa', ['id' => $id])->result();
        $response['dataPembayaran'] = $dataPembayaran[0];

        $this->db->select('lantai, nomor, tipe');
        $dataKamar = $this->db->get_where('tbl_kamar', ['id' => $dataPembayaran[0]->id_kamar])->result();
        $response['dataKamar'] = $dataKamar[0];

        $this->response($response, 200);
    }
    // -----------------------------------------------------------------------------------------------------------  
    public function detailUser_get()
    {
        $nim = $this->get('nim');

        if ($nim === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $this->db->select('detail');
        $data = $this->db->get_where('tbl_user', ['nim' => $nim])->result();

        $this->response(json_decode($data[0]->detail), 200);
    }
    // -----------------------------------------------------------------------------------------------------------  
    public function pesanan_get()
    {
        $nim = $this->get('nim');

        if ($nim === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $this->db->select("id, CONCAT('Rp ', FORMAT(total_bayar, 0)) as total_bayar, IF(DATE_ADD(ditambahkan_pada, INTERVAL 1 DAY) <= NOW(), 'Expired', status) as status, ditambahkan_pada");
        $this->db->order_by('ditambahkan_pada', 'DESC');
        $data = $this->db->get_where('tbl_sewa', ['nim' => $nim, 'status <>' => 'Sukses'])->result();

        $this->response($data, 200);
    }
    // -----------------------------------------------------------------------------------------------------------  
    public function histori_get()
    {
        $nim = $this->get('nim');

        if ($nim === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $this->db->select("IF(a.tanggal_keluar >= NOW(), 'Aktif', 'Tidak Aktif') status, DATE_FORMAT(a.tanggal_masuk, '%d/%c/%Y') tanggal_masuk, DATE_FORMAT(a.tanggal_keluar, '%d/%c/%Y') tanggal_keluar, CONCAT('Rp ', FORMAT(a.total_bayar, 0)) as total_bayar, a.ditambahkan_pada, b.nomor, b.lantai, b.tipe");
        $this->db->from('tbl_sewa a');
        $this->db->join('tbl_kamar b', 'a.id_kamar = b.id', 'left');
        $this->db->where('nim', $nim);
        $this->db->where('status', 'Sukses');
        $this->db->order_by('a.diubah_pada', 'DESC');
        $data = $this->db->get()->result();

        $this->response($data, 200);
    }
    // -----------------------------------------------------------------------------------------------------------  
    public function buktiPembayaran_post()
    {
        $id = $this->post('id');
        $file = $this->post('file');

        $this->db->set('file', $file);
        $this->db->set('status', 'Menunggu konfirmasi');
        $this->db->set('diubah_pada', $this->Model->getWaktu());
        $this->db->where('id', $id);
        $update = $this->db->update('tbl_sewa');

        if ($update) {
            $this->response(['error' => false, 'message' => 'File bukti pembayaran berhasil disimpan'], 200);
        }
        $this->response(['error' => true, 'message' => 'File bukti pembayaran gagal disimpan'], 200);
    }
    // -----------------------------------------------------------------------------------------------------------  
    public function token_post()
    {
        $nim = $this->post('nim');
        $token = $this->post('token');

        if ($nim === null || $token === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $this->db->set('token', $token);
        $this->db->where('nim', $nim);
        $update = $this->db->update('tbl_user');

        $this->response(['success' => $update], 200);
    }
    // -----------------------------------------------------------------------------------------------------------  
}
