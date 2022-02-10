<?php

class Mahasiswa extends Controller
{
    public function index()
    {
        $data['judul'] = 'Data Mahasiswa';
        $data['mhs'] = $this->model('Mahasiswa')->getAllMahasiswa();

        $this->view('templates/header', $data);
        $this->view('Mahasiswa/index', $data);
        $this->view('templates/footer');
    }
    public function detail($id)
    {
        $data['judul'] = 'Detail Mahasiswa';
        $data['mhs'] = $this->model('Mahasiswa')->getMahasiswaById($id);

        $this->view('templates/header', $data);
        $this->view('Mahasiswa/index', $data);
        $this->view('templates/footer');
    }
}
