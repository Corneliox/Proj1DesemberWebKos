function viewProfile(){
	let id = $('#edit-id').val();

	$.getJSON(`api/profile/${id}`, function(data){
		$('#nav-photo').attr('src', `./images/photos/${data.photo}`);
		$('#nav-name').text(data.name);
		$('#nav-username').text(`Halo ${data.username}!`);
		$('#side-level').text(data.level);
		$('#profile-id').text(`#${data.id}`);
		$('#profile-photo').attr('src', `./images/photos/${data.photo}`);

		if(data.level == 'admin'){
			$('#profile-level').text(data.level);
		}else if(data.level == 'operator'){
			$('#profile-level').text(data.level);
		}

		if(data.status == 1){
			$('#profile-status').text('aktif').removeClass('text-danger').addClass('text-success');
		}else if(data.status == 0){
			$('#profile-status').text('nonaktif').removeClass('text-success').addClass('text-danger');
		}
		$('#profile-name').html(`${data.name} <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> ${data.username}</div>`);
		$('#profile-created').text(`${tanggal('full', data.created_at)} WIB`);
	}).fail(function(xhr, status){
		console.log(`viewProfile(${status}: ${xhr.status} ${xhr.statusText})`);
	});
}

$(document).ready(function(){
	viewProfile();

	$('#btn-password').on('click', function(e){
		$('#form-password').removeClass('was-validated');
		$('#form-password')[0].reset();
		$('#modal-password').on('shown.bs.modal', function(){
			$('#password-new').focus();
		});
	});

	$('#form-password').on('submit', function(e){
		e.preventDefault();
		let cek = true;

		$('#form-password .required').each(function(){
			let value = $(this).val(),
			name = $(this).closest('.form-group').find('label').text();

			if(value == ''){
				$(this).focus();
				/* swal({
					title: 'Peringatan!',
					text: `${name} Tidak Boleh Kosong`,
					icon: 'warning'
				}); */
				cek = false;
				return false;
			}
		});

		if(cek == true){
			let id = $('#password-id').val(),
			data = $('#form-password').serialize();
			$.ajax({
				type: 'POST',
				url	: `api/profile/${id}`,
				data: data,
				dataType: 'json',
				beforeSend: function(){
					$('#modal-password .btn-save').addClass('btn-progress').closest('.modal').addClass('modal-progress');
				},
				success: function(data){
					$('#modal-password .btn-save').removeClass('btn-progress').closest('.modal').removeClass('modal-progress');

					if(data.status == 'success'){
						$('#modal-password').modal('hide');
						swal({
							title: data.title,
							text: data.message,
							icon: data.type
						}).then((result) => {
							sessionStorage.setItem('message', 'password');
							setTimeout('window.location.replace("./login")', 500);
						});
					}else{
						swal({
							title: data.title,
							text: data.message,
							icon: data.type
						});
					}
				},
				error: function(xhr, status){
					$('#modal-password .btn-save').removeClass('btn-progress').closest('.modal').removeClass('modal-progress');
					swal({
						title: status,
						text: `${xhr.status} ${xhr.statusText}`,
						icon: 'error'
					});
				}
			});
			return false;
		}
	});

	$('#btn-delete').on('click', function(e){
		swal({
			title: 'Apakah Anda Yakin?',
			text: 'Akun Anda akan Terhapus Secara Permanen',
			icon: 'warning',
			buttons: [true, 'Ya, Hapus!'],
			dangerMode: true,
			closeOnClickOutside: false,
			closeOnEsc: false
		}).then((result) => {
			if(result){
				let id = $('#edit-id').val();
				$.ajax({
					type: 'POST',
					url: `api/profile/${id}`,
					dataType: 'json',
					success: function(data){
						if(data.status == 'success'){
							swal({
								title: data.title,
								text: data.message,
								icon: data.type
							}).then((result) => {
								sessionStorage.setItem('message', 'profile');
								setTimeout('window.location.replace("./login")', 500);
							});
						}else{
							swal({
								title: data.title,
								text: data.message,
								icon: data.type
							});
						}
					},
					error: function(xhr, status){
						swal({
							title: status,
							text: `${xhr.status} ${xhr.statusText}`,
							icon: 'error'
						});
					}
				});
			}
		});
	});

	$('#form-edit').on('submit', function(e){
		e.preventDefault();
		let cek = true;

		$('#form-edit .required').each(function(){
			let value = $(this).val(),
			name = $(this).closest('.form-group').find('label').text();

			if(value == ''){
				$(this).focus();
				/* swal({
					title: 'Peringatan!',
					text: `${name} Tidak Boleh Kosong`,
					icon: 'warning'
				}); */
				cek = false;
				return false;
			}
		});

		if(cek == true){
			// let data = $('#form-edit').serialize();
			let id = $('#edit-id').val(),
			data = new FormData($('#form-edit')[0]);
			$.ajax({
				type: 'POST',
				url: `api/profile/${id}`,
				data: data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$('#card-edit .btn-save').addClass('btn-progress').closest('.card').addClass('card-progress');
				},
				success: function(data){
					$('#card-edit .btn-save').removeClass('btn-progress').closest('.card').removeClass('card-progress');

					if(data.status == 'success' || data.status == 'photo'){
						swal({
							title: data.title,
							text: data.message,
							icon: data.type
						}).then((result) => {
							viewProfile();
						});
					}else{
						swal({
							title: data.title,
							text: data.message,
							icon: data.type
						});
					}
				},
				error: function(xhr, status){
					$('#card-edit .btn-save').removeClass('btn-progress').closest('.card').removeClass('card-progress');
					swal({
						title: status,
						text: `${xhr.status} ${xhr.statusText}`,
						icon: 'error'
					});
				}
			});
			return false;
		}
	});
});