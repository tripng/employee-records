<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\{KaryawanModel,JabatanModel,DirektorateModel,DivisiModel,DepartemenModel,SectionModel};
use CodeIgniter\Database\Exceptions\DatabaseException;
use PhpParser\Node\Stmt\TryCatch;

class Employee extends BaseController
{
    public $employee,$position,$director,$division,$departement,$section;
    public function __construct() {
        $this->employee = new KaryawanModel();
        $this->position = new JabatanModel();
        $this->director = new DirektorateModel();
        $this->division = new DivisiModel();
        $this->departement = new DepartemenModel();
        $this->section = new SectionModel();
    }
    public function storeEmployee(){
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama-direktorate' => 'required',
            'nama-jabatan' => 'required',
            'nik-karyawan' => 'required',
            'nama-karyawan' => 'required',
            'hirarki-karyawan' => 'required'
        ]);
        // if(!$validate) return redirect()->back()->withInput()->with('validation',$valida);
        // $validation->withRequest($this->request)->run()
        $isDataValid = $validation->withRequest($this->request)->run();
        if(!$isDataValid) return redirect()->back()->withInput()->with('validation',$validation);
        $hasDirector = $this->director->where(['nama_direktorate'=>$this->request->getPost('nama-direktorate')])->first();
        $hasDivision = $this->division->where(['nama_divisi'=>$this->request->getPost('nama-divisi')])->first();
        $family = $this->position->where(['hirarki'=>$this->request->getPost('hirarki-karyawan')])->get()->getResultArray();
        // dd($hasDivision);
        $hasDepartement = $this->departement->where(['nama_departemen'=>$this->request->getPost('nama-departemen')])->first();
        // dd($hasDepartement);
        $kode_bagian=null;
        if($this->request->getPost('bagian')!=null){
            $kode_bagian = $this->section->where(['id'=>$this->request->getPost('bagian')])->first();
        }
        try{
            // Transaksi Direktor
            if(!$hasDirector){
                $this->director->transException(true)->transStart();
                    $data_director = [
                        'kode_direktorate' => $this->generateCode($this->director,'kode_direktorate',null),
                        'nama_direktorate' => $this->request->getPost('nama-direktorate'),
                    ];
                    $this->director->save($data_director);
                    // if ($this->director->transStatus() === false) return false;
                $this->director->transComplete();
            }
            // dd($data_director['kode_direktorate']);
            $id_direktor = $hasDirector['id'] ?? $this->director->getInsertID();
            $kode_direktor = $hasDirector['kode_direktorate'] ?? $data_director['kode_direktorate'];
            // dd($kode_direktor);
            // Transaksi Divisi
            // dd( $this->request->getPost('nama-divisi')==null );
            if($this->request->getPost('nama-divisi')!=null && !$hasDivision){
                $this->division->transException(true)->transStart();
                    $data_divisi = [
                        'direktorate_id' => $id_direktor,
                        'kode_divisi' => $this->generateCode($this->division,'kode_divisi',null),
                        'nama_divisi' => $this->request->getPost('nama-divisi')
                    ];
                    $this->division->save($data_divisi);
                    // if ($this->division->transStatus() === false) return false;
                $this->division->transComplete();
            }
            // dd($data_divisi['kode_divisi']);
            $id_divisi = $this->request->getPost('nama-divisi')==null 
                            ? null
                                : ($hasDivision
                                    ? $hasDivision['id']
                                    : $this->division->getInsertID());
            $kode_divisi = $this->request->getPost('nama-divisi')==null 
                            ? null
                                : ($hasDivision
                                    ? $hasDivision['kode_divisi']
                                    : $data_divisi['kode_divisi']);
            // Transaksi Departemen
            if($this->request->getPost('nama-departemen')!=null && !$hasDepartement){
                $this->departement->transException(true)->transStart();
                    $data_departemen = [
                        'divisi_id' => $id_divisi,
                        'kode_departemen' => $this->generateCode($this->departement,'kode_departemen',null),
                        'nama_departemen' => $this->request->getPost('nama-departemen')
                    ];
                    $this->departement->save($data_departemen);
                $this->departement->transComplete();
            }
            $id_departemen = $this->request->getPost('nama-departemen')==null 
                            ? null
                                : ($hasDepartement
                                    ? $hasDepartement['id']
                                    : $this->departement->getInsertID());
            $kode_departemen = $this->request->getPost('nama-departemen')==null 
                            ? null
                                : ($hasDepartement
                                    ? $hasDepartement['kode_departemen']
                                    : $data_departemen['kode_departemen']);            
            // dd($kode_bagian);

            if($this->request->getPost('hirarki-karyawan')=='direktor') $kode_jabatan = "$kode_direktor";
            else if($this->request->getPost('hirarki-karyawan')=='divisi') $kode_jabatan = "$kode_direktor{$this->generateCode($this->division,'kode_divisi',null)}";
            else if($this->request->getPost('hirarki-karyawan')=='departemen') $kode_jabatan = "$kode_direktor$kode_divisi{$this->generateCode($this->departement,'kode_departemen',null)}";
            else if($this->request->getPost('hirarki-karyawan')=='bagian' || $this->request->getPost('hirarki-karyawan')=='staf') {
                if($this->request->getPost('bagian') == null){
                    $this->section->transException(true)->transStart();
                    $data_section = [
                        'departemen_id' => $id_departemen,
                        'kode_section_head' => $this->generateCode($this->section,'kode_section_head','bagian'),
                        'kode_staff' => null,
                    ];
                    $this->section->save($data_section);
                    $this->section->transComplete();
                    $kode_jabatan = "$kode_direktor$kode_divisi$kode_departemen{$data_section['kode_section_head']}";
                    $id_bagian = $this->section->getInsertID();
                }
                if($this->request->getPost('hirarki-karyawan')=='staf'){
                    $this->section->transException(true)->transStart();
                    $data_staff = [
                        'departemen_id' => $id_departemen,
                        'kode_section_head' => $kode_bagian['kode_section_head'] ?? $data_section['kode_section_head'],
                        'kode_staff' => $this->generateCode($this->section,'kode_staff','staf'),
                    ];
                        $this->section->save($data_staff);
                    $this->section->transComplete();
                    $kode_jabatan = "$kode_direktor$kode_divisi$kode_departemen{$data_staff['kode_section_head']}{$data_staff['kode_staff']}";
                    $id_bagian = $this->section->getInsertID();
                };
            }
            else $kode_jabatan = null;
            // Transaksi Jabatan
            // dd($kode_jabatan,$this->generateCode($departemenModel,'kode_departemen'));
            $this->position->transException(true)->transStart();
                $data_position = [
                    'direktorate_id' => $id_direktor,
                    'divisi_id' => $id_divisi,
                    'departemen_id' => $id_departemen,
                    'section_head_id' => $id_bagian ?? null,
                    'kode_jabatan' => $kode_jabatan,
                    'hirarki' => $this->request->getPost('hirarki-karyawan'),
                    'nama_jabatan' => $this->request->getPost('nama-jabatan'),
                ];
                $this->position->save($data_position);
            $this->position->transComplete();
                // dd($data_position['kode_jabatan']);
            // Transaksi Karyawan 
            $this->employee->transException(true)->transStart();
                $data_karyawan = [
                    'jabatan_id' => $this->position->getInsertID(),
                    'nik' => $this->request->getPost('nik-karyawan'),
                    'nama' => $this->request->getPost('nama-karyawan'),
                ];
                $this->employee->save($data_karyawan);
            $this->employee->transComplete();
        }catch(DatabaseException $e){
            dd($e);
        }
        session()->setFlashdata('success',"Nama:{$data_karyawan['nama']} | Jabatan:{$data_position['nama_jabatan']} | Berhasil Ditambahkan");
        return redirect()->to('/hierarchy');
    }
    public function generateCode($query,$kode,$hirarki){
        if($hirarki!='bagian'&&$hirarki!='staf')$allCode = $query->select($kode)->get()->getResultArray();
        else {
            $allCode = $this->position->select($kode)->join('section_head','section_head.id = jabatan.section_head_id')->where(['jabatan.hirarki'=>$hirarki])->get()->getResultArray();
        }
        // dd($allCode);
        $letters = range('A','Z');
        foreach ($letters as $letter) {
            if (!in_array($letter, array_column($allCode,$kode))) {
                return $letter;
            }
        }
    }
    public function deleteEmployee($kode){
        // JANGAN LUPA TAMBAH TRANSAKSI
        $this->position->where(['kode_jabatan'=>$kode])->delete();
        session()->setFlashdata('success',"Data Berhasil Dihapus");
        return redirect()->back();
    }
    public function updateEmployee($id){
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama-direktorate' => 'required',
            'nama-jabatan' => 'required',
            'nik-karyawan' => 'required',
            'nama-karyawan' => 'required',
            'hirarki-karyawan' => 'required'
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();
        if(!$isDataValid) return redirect()->back()->withInput()->with('validation',$validation);

        $hierarchy = $this->request->getPost('hirarki-karyawan');
        $oldData = $this->position->getWithId($id)->first();

        $data_director = [
            'id' => $oldData['direktorate_id'],
            'nama_direktorate' => $this->request->getPost('nama-direktorate'),
        ];
        $data_position = [
            'id' => $id,
            'divisi_id' => null,
            'departemen_id' => null,
            'section_head_id' => null,
            // --------------jika hirarki berubah maka kode jabatan diupdate
            'hirarki' => $hierarchy,
            'nama_jabatan' => $this->request->getPost('nama-jabatan')
        ];
        $data_employee = [
            'id' => $oldData['id'],
            'nik' => $this->request->getPost('nik-karyawan'),
            'nama' => $this->request->getPost('nama-karyawan'),
            // -------------Jabatan id Berubah jika hirarki diupdate 
        ];
        if($hierarchy == 'direktor'){
            
        }else if($hierarchy == 'divisi'){
            $data_division = [
                'id' => $oldData['divisi_id'],
                'nama_divisi' => $this->request->getPost('nama-divisi'),
                // -------------Direktorate Id Berubah jika direktor di update 
            ];
            $data_position['divisi_id'] = $data_division['id'];
            $this->division->save($data_division);
        }else if($hierarchy == 'departemen'){
            $data_departemen = [
              'id' => $oldData['departemen_id'],
              'nama_departemen' => $this->request->getPost('nama-departemen'),  
            ];
            $data_position['departemen_id'] = $data_departemen['id'];
            $this->division->save($data_departemen);
        }else if($hierarchy == 'bagian'){

        }else if($hierarchy == 'staf'){

        }else{
            dd('jabatan tidak ditemukan');
        }
        $this->director->save($data_director);
        $this->position->save($data_position);
        $this->employee->save($data_employee);

        session()->setFlashdata('success',"Data Berhasil Diupdate");
        return redirect()->to('/hierarchy');
    }
}
