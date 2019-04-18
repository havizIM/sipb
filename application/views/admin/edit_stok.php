<div class="container-fluid">
  <div class="row page-titles align-self-center text-right">
    <h4 class="text-themecolor" style="margin-left: 15px; margin-top: 8px;">Ubah Stok</h4>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form class="form-horizontal" method="post" id="form_edit" enctype="multipart/form-data">
            <div class="form-group">
              <div class="input-group">
                <input type="hidden" name="no_persediaan" id="edit_no_persediaan">
                <input type="text" class="form-control" name="nama_persediaan" id="nama_persediaan" placeholder="-- Pilih Persediaan --" readonly>
                <div class="input-group-append">
                  <span class="input-group-text bg-info text-white" id="modal_persediaan">Cari</span>
                </div>
              </div>
              <br>

              <div class="form-group">
                <input type="text" class="form-control" name="no_identifikasi" id="no_identifikasi" placeholder="Nomor Identifikasi">
              </div>

              <div class="form-group">
                <textarea class="form-control" id="keterangan" name="keterangan" rows="8" cols="80" placeholder="Keterangan"></textarea>
              </div>

              <div class="form-group">
                <input type="text" class="form-control" name="saldo_awal" id="saldo_awal" placeholder="Saldo Awal">
              </div>

              <button type="submit" id="submit_add" class="btn btn-info waves-effect">Tambah</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="lookup_persediaan" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">Pilih Persediaan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body form-group">
        <div class="table-responsive m-t-40">
          <table class="table table-striped table-hover" id="t_persediaan">
            <thead>
              <th>Nama Persediaan</th>
              <th>Satuan</th>
              <th>Warna</th>
              <th>Keterangan</th>
              <th>Foto</th>
              <th></th>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
