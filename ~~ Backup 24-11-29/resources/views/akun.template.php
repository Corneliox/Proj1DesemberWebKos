<?php
	function modal($modal, $title = 'Akun'){
		switch($modal){
			case 'info' :
				echo '<div class="modal fade" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="modal-info" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Informasi</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body pt-4">
						<ul class="list-group">
							<li class="list-group-item">Data Akun mempunyai dua level: <mark>Admin</mark> dan <mark>Operator</mark></li>
							<li class="list-group-item">Catatan: Setiap level mempunyai hak aksesnya masing-masing</li>
						</ul>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>
';
			break;

			case 'add' :
				echo '<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content overlay-wrapper">
					<div class="modal-header">
						<h5 class="modal-title">Tambah Data ' . $title . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="form-add" class="needs-validation" novalidate="">
					<div class="modal-body">
						<div class="form-group mb-2">
							<label for="add-name">Nama Lengkap</label>
							<input type="text" class="form-control required" id="add-name" name="name" placeholder="Nama Lengkap" value="" autocomplete="off" required autofocus>
							<div class="invalid-feedback">
								nama tidak boleh kosong
							</div>
						</div>
						<div class="form-group mb-2">
							<label for="add-username">Username</label>
							<input type="text" class="form-control required" id="add-username" name="username" placeholder="Username" value="" autocomplete="off" required>
							<div class="invalid-feedback">
								username tidak boleh kosong
							</div>
						</div>
						<div class="form-group mb-2">
							<label for="add-password">Password</label>
							<input type="password" class="form-control required" id="add-password" name="password" placeholder="Password" value="" autocomplete="off" required>
							<div class="invalid-feedback">
								password tidak boleh kosong
							</div>
						</div>
						<div class="form-group mb-2">
							<label for="add-confirmation">Konfirmasi Password</label>
							<input type="password" class="form-control required" id="add-confirmation" name="confirmation" placeholder="Konfirmasi Password" value="" autocomplete="off" required>
							<div class="invalid-feedback">
								konfirmasi password tidak boleh kosong
							</div>
						</div>
						<div class="form-group mb-0">
							<label for="add-level">Level</label>
							<select class="form-control required" id="add-level" name="level" required>
								<option value="" selected hidden>― Pilih Level ―</option>
								<option value="admin">Admin</option>
								<option value="operator">Operator (Pegawai)</option>
							</select>
							<div class="invalid-feedback">
								level tidak boleh kosong
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary btn-save">Simpan</button>
					</div>
					</form>
				</div>
			</div>
		</div>
';
			break;

			case 'edit' :
				echo '<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content overlay-wrapper">
					<div class="modal-header">
						<h5 class="modal-title">Edit Data ' . $title . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="form-edit" class="needs-validation" novalidate="">
					<div class="modal-body pt-4">
						<div class="form-group mb-2">
							<input type="hidden" class="form-control" id="edit-id" name="id" placeholder="ID" value="" required>
							<label for="edit-name">Nama Lengkap</label>
							<input type="text" class="form-control required" id="edit-name" name="name" placeholder="Nama Lengkap" value="" autocomplete="off" required autofocus>
							<div class="invalid-feedback">
								nama tidak boleh kosong
							</div>
						</div>
						<div class="form-group mb-2">
							<label for="edit-username">Username</label>
							<input type="text" class="form-control required" id="edit-username" name="username" placeholder="Username" value="" autocomplete="off" required>
							<div class="invalid-feedback">
								username tidak boleh kosong
							</div>
						</div>
						<div class="form-group mb-2">
							<label for="edit-password">Password</label>
							<input type="password" class="form-control required" id="edit-password" name="password" placeholder="Password" value="" autocomplete="off" required>
							<div class="invalid-feedback">
								password tidak boleh kosong
							</div>
						</div>
						<div class="form-group mb-2">
							<label for="edit-confirmation">Konfirmasi Password</label>
							<input type="password" class="form-control required" id="edit-confirmation" name="confirmation" placeholder="Konfirmasi Password" value="" autocomplete="off" required>
							<div class="invalid-feedback">
								konfirmasi password tidak boleh kosong
							</div>
						</div>
						<div class="form-group mb-2">
							<label for="edit-level">Level</label>
							<select class="form-control required" id="edit-level" name="level" required>
								<option value="" selected hidden>― Pilih Level ―</option>
								<option value="admin">Admin</option>
								<option value="operator">Operator (Pegawai)</option>
							</select>
							<div class="invalid-feedback">
								level tidak boleh kosong
							</div>
						</div>
						<div class="form-group mb-0">
							<label for="edit-status">Status</label>
							<select class="form-control required" id="edit-status" name="status" required>
								<option value="" selected hidden>― Ubah Status ―</option>
								<option value="0">Nonaktif</option>
								<option value="1">Aktif</option>
							</select>
							<div class="invalid-feedback">
								status tidak boleh kosong
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-success btn-save">Simpan</button>
					</div>
					</form>
				</div>
			</div>
		</div>
';
			break;

			case 'detail' :
				echo '<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Detail ' . $title . ' #<span id="detail-id"></span></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body pt-4">
						<div class="user-item">
							<img alt="image" src="./images/photos/user.png" class="img-fluid" width="150px" id="detail-photo">
							<div class="user-details">
								<div class="user-name" id="detail-name"></div>
								<div class="text-job text-muted" id="detail-username"></div>
								<div class="user-cta" id="detail-level">

								</div>
							</div>
						</div>
						<!-- List group -->
						<ul class="list-group list-group-flush mt-4">
							<li class="list-group-item d-flex justify-content-between align-items-center">Status<span id="detail-status" class="text-right"></span></li>
							<li class="list-group-item d-flex justify-content-between align-items-center">Dibuat<span id="detail-created_at" class="text-right"></span></li>
							<li class="list-group-item d-flex justify-content-between align-items-center">Diubah<span id="detail-updated_at" class="text-right"></span></li>
						</ul>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>
';
			break;
		}
	}
?>