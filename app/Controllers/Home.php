<?php

namespace App\Controllers;
use App\Models\{KaryawanModel,DirektorateModel,JabatanModel,DivisiModel,DepartemenModel};
use CodeIgniter\Exceptions\PageNotFoundException;
class Home extends BaseController
{
    public $employee,$position,$session,$director;
    public function __construct() {
        $this->employee = new KaryawanModel();
        $this->position = new JabatanModel();
        $this->director = new DirektorateModel();
        $this->session = session();
    }
    public function index(): string
    {
        return view('welcome_message');
    }
    public function hierarchy(): string
    {
        $employees = ['directors','divisions','departements','sections','staff'];
        $directors = $this->employee->getAllDirector();
        $divisions = $this->employee->getAllDivision();
        $departements = $this->employee->getAllDepartement();
        $sections = $this->employee->getAllSection();
        $staff = $this->employee->getAllStaff();
        $data['countEmployee'] = 0;
        foreach ($employees as $employee) {
            $data[$employee] = $$employee->getResultArray();
            $data['countEmployee'] += $$employee->getNumRows();
        }
        // dd($data['staff'],$data['sections']); 
        return view('pages/hierarchy',$data);    
    }
    public function addHierarchy($segment){
        $page = strlen($segment);
        $divisiModel = new DivisiModel();
        $departemenModel = new DepartemenModel();
        // $directorModel = new DirektorateModel();
        $data = [
            'nama_direktorate' => $this->director->select('nama_direktorate')->findAll(),
            'nama_jabatan' => $this->position->select('nama_jabatan')->findAll(),
            'nama_divisi' => $divisiModel->select('nama_divisi')->findAll(),
            'nama_departemen' => $departemenModel->select('nama_departemen')->findAll(),
            'nama_bagian' => $this->position->where(['hirarki'=>'bagian'])->get()->getResultArray()
        ];
        $data['page'] = 1;
        if($page >=2){
            $query = $this->position->join('direktorate','direktorate.id = jabatan.direktorate_id');
            $data['page'] = 2;
        }
        if($page >=3){
            $query->join('divisi','divisi.id = jabatan.divisi_id');
            $data['page'] = 3;
        }
        if($page >=4){
            $query->join('departemen','departemen.id = jabatan.departemen_id');
            $data['page'] = 4;
        }
        if($page == 5){
            $query->join('section_head','section_head.id = jabatan.section_head_id');
            $data['page'] = 5;
        }
        if($page > 5){
            return throw PageNotFoundException::forPageNotFound('Hirarki yang ingin ditambahkan tidak ditemukan');
        }
        if($page != 1){
            $data['parent'] = $query->where(['jabatan.kode_jabatan'=>$segment])->first();
        }
        $hasFlash = $this->session->get('validation');
        if($hasFlash) $data['validation'] = $this->session->get('validation');
        else $data['validation'] = \Config\Services::validation();
        return view('pages/add_hierarchy',$data);
    }
    public function editHierarchy($segment){
        $query = $this->position->getWithCode($segment);
        $getPosition = $query->first();
        $hierarchy = $getPosition['hirarki'];
        $divisiModel = new DivisiModel();
        $departemenModel = new DepartemenModel();

        $data = [
            'hierarchy' => $hierarchy,
            'nama_bagian' => $this->position->where(['hirarki'=>'bagian'])->get()->getResultArray(),
            'nama_direktorate' => $this->director->select('nama_direktorate')->findAll(),
            'nama_divisi' => $divisiModel->select('nama_divisi')->findAll(),
            'nama_departemen' => $departemenModel->select('nama_departemen')->findAll(),
        ]; 

        // Cek Setiap hirarki
        if($hierarchy === 'direktur'){
            $data['employee'] = $getPosition;
        }
        else if($hierarchy == 'divisi'){
            $data['employee'] = $this->position->relation(1,0,0)->getWithCode($segment)->first();
        }
        else if($hierarchy == 'departemen'){
            $data['employee'] = $this->position->relation(1,1,0)->getWithCode($segment)->first();
        }
        else if($hierarchy == 'bagian'){
            $data['employee'] = $this->position->relation(1,1,1)->getWithCode($segment)->first();
        }
        else if($hierarchy == 'staf'){
            $data['employee'] = $this->position->relation(1,1,1)->getWithCode($segment)->first();
            $data['parent'] = $this->position->relation(0,0,1)->getWithHierarchy('bagian')->where(['kode_section_head' => $data['employee']['kode_section_head']])->first();
        }
        // dd($data['employee']);
        $hasFlash = $this->session->get('validation');
        if($hasFlash) $data['validation'] = $this->session->get('validation');
        else $data['validation'] = \Config\Services::validation();
        return view('pages/edit_hierarchy',$data);
    }
}
