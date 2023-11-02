<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="card">
      <div class="card-header fw-bold"><h3>Edit Karyawan</h3></div>
      <div class="card-body">
        <form action="<?= url_to('update-employee', $employee['id']) ?>" method="post">
          <?= csrf_field() ?>
          
          <div class="row d-flex justify-content-center my-3">
            <div class="col-6">
              <label for="hierarchy" class="form-label">Jabatan Saat Ini<span class="text-danger">*</span></label>
              <select class="form-select <?= ($validation->hasError('hirarki-karyawan')) ? 'is-invalid' : ''; ?>" id="hierarchy" name="hirarki-karyawan" aria-label="Default select example">
                <option value="direktor" <?= $hierarchy=='direktor' ? 'selected' : ''?>>Direktorate</option>
                <option value="divisi" <?= $hierarchy=='divisi' ? 'selected' : ''?>>Ketua Divisi</option>
                <option value="departemen" <?= $hierarchy=='departemen' ? 'selected' : ''?>>Ketua Departemen</option>
                <option value="bagian" <?= $hierarchy=='bagian' ? 'selected' : ''?>>Ketua Bagian</option>
                <option value="staf" <?= $hierarchy=='staf' ? 'selected' : ''?>>Staf</option>
              </select>
              <?php if($validation->hasError('hirarki-karyawan')): ?>
                <div class="invalid-feedback">
                  <?= $validation->getError('hirarki-karyawan') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="col-6">
              <label for="section" class="form-label">Pilih Jika Karyawan Adalah Staff</label>
              <select class="form-select <?= ($validation->hasError('bagian')) ? 'is-invalid' : ''; ?>" id="section" name="bagian" aria-label="Default select example">
                <option value="">Tidak Masuk di Section Manapun</option>
                <?php foreach($nama_bagian as $nama): ?>
                  <option <?= $hierarchy=='staf'&&$nama['section_head_id']==$parent['id'] ? 'selected' : '' ?> value="<?= $nama['section_head_id'] ?>"><?= $nama['nama_jabatan'] ?></option>
                <?php endforeach; ?>
              </select>
              <?php if($validation->hasError('hirarki-karyawan')): ?>
                <div class="invalid-feedback">
                  <?= $validation->getError('hirarki-karyawan') ?>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="row d-flex justify-content-center my-3">
            <div class="d-mb-3 col-6">
              <label for="employeeName" class="form-label">Nama Karyawan<span class="text-danger">*</span></label>
              <input type="text" class="form-control <?= ($validation->hasError('nama-karyawan')) ? 'is-invalid' : ''; ?>" value="<?= old('nama-karyawan') ?? $employee['nama']; ?>" id="employeeName" name="nama-karyawan" placeholder="Nama Karyawan"/>
              <?php if($validation->hasError('nama-karyawan')): ?>
                <div class="invalid-feedback">
                  <?= $validation->getError('nama-karyawan') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="d-mb-3 col-6">
              <label for="nik" class="form-label">NIK Karyawan<span class="text-danger">*</span></label>
              <input type="text" class="form-control <?= ($validation->hasError('nik-karyawan')) ? 'is-invalid' : ''; ?>" value="<?= old('nik-karyawan') ?? $employee['nik']; ?>" id="nik" name="nik-karyawan" placeholder="NIK"/>
              <?php if($validation->hasError('nik-karyawan')): ?>
                <div class="invalid-feedback">
                  <?= $validation->getError('nik-karyawan') ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
          
          <div class="row d-flex justify-content-center my-3">
            <div class="d-mb-3 col-6">
              <label for="directorName" class="form-label">Nama Direktor<span class="text-danger">*</span></label>
              <input class="form-control <?= $validation->hasError('nama-direktorate') ? 'is-invalid' : '' ?>" list="namaDirektorate" id="directorName" name="nama-direktorate" placeholder="Nama Direktor" value="<?= $employee['nama_direktorate'] ?? '' ?>">
                <datalist id="namaDirektorate">
                  <?php foreach($nama_direktorate as $nama): ?>
                    <option value="<?= $nama['nama_direktorate'] ?>">
                  <?php endforeach; ?>
                </datalist>
              <?php if($validation->hasError('nama-direktorate')): ?>
                <div class="invalid-feedback">
                  <?= $validation->getError('nama-direktorate') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="d-mb-3 col-6">
              <label for="directorName" class="form-label">Jabatan<span class="text-danger">*</span></label>
              <input type="text" class="form-control <?= ($validation->hasError('nama-jabatan')) ? 'is-invalid' : ''; ?>" value="<?= old('nama-jabatan') ?? $employee['nama_jabatan'] ?>" name="nama-jabatan" id="positionName" placeholder="Nama Jabatan"/>
              <?php if($validation->hasError('nama-jabatan')): ?>
                <div class="invalid-feedback">
                  <?= $validation->getError('nama-jabatan') ?>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="row d-flex justify-content-center my-3">
            <div class="d-mb-3 col-6">
              <label for="divisionName" class="form-label">Divisi</label>
              <input type="text" class="form-control <?= ($validation->hasError('nama-divisi')) ? 'is-invalid' : ''; ?>"  id="divisionName" name="nama-divisi" placeholder="Nama Divisi" list="namaDivisi" value="<?= $employee['nama_divisi'] ?? '' ?>"/>
              <datalist id="namaDivisi">
                  <?php foreach($nama_divisi as $nama): ?>
                    <option value="<?= $nama['nama_divisi'] ?>">
                  <?php endforeach; ?>
                </datalist>
              <?php if($validation->hasError('nama-divisi')): ?>
                <div class="invalid-feedback">
                  <?= $validation->getError('nama-divisi') ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="d-mb-3 col-6">
              <label for="directorName" class="form-label">Departemen</label>
              <input type="text" class="form-control <?= ($validation->hasError('nama-departemen')) ? 'is-invalid' : ''; ?>" value="<?= $employee['nama_departemen'] ?? '' ?>" id="departementName" name="nama-departemen" list="namaDepartemen" placeholder="Nama Departemen"/>
              <datalist id="namaDepartemen">
                  <?php foreach($nama_departemen as $nama): ?>
                    <option value="<?= $nama['nama_departemen'] ?>">
                  <?php endforeach; ?>
                </datalist>
              <?php if($validation->hasError('nama-departemen')): ?>
                <div class="invalid-feedback">
                  <?= $validation->getError('nama-departemen') ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="row d-flex justify-content-end">
            <!-- <button type="button" class="btn btn-warning col-2 mt-3 me-5">Turun Jabatan</button>
            <button type="button" class="btn btn-primary col-2 mt-3 me-5">Naik Jabatan</button> -->
            <button type="submit" class="btn btn-success col-2 mt-3 me-5">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?= $this->endsection() ?>