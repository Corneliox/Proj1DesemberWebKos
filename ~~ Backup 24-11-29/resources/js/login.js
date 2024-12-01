$(document).ready(function(){
	$('#form-login').on('submit', function(e){
		e.preventDefault();
		let cek = true;

		$('#form-login .required').each(function(){
			let value = $(this).val(),
			name = $(this).attr('placeholder');

			if(value == ''){
				$(this).focus();
				/* swal({
					title: 'Peringatan!',
					text: `Silahkan Masukkan ${name} Anda`,
					icon: 'warning'
				}); */
				cek = false;
				return false;
			}
		});

		if(cek == true){
			let data = $('#form-login').serialize();
			$.ajax({
				type: 'POST',
				url: 'config/authentication.php?auth=login',
				data: data,
				beforeSend: function(){
					$('#btn-login').addClass('btn-progress').closest('.card').addClass('card-progress');
				},
				success: function(data){
					$('#btn-login').removeClass('btn-progress').closest('.card').removeClass('card-progress');

					if(data === 'username'){
						swal({
							title: 'Peringatan!',
							text: 'Username yang Anda Masukkan Salah',
							icon: 'warning'
						});
					}else if(data === 'password'){
						swal({
							title: 'Peringatan!',
							text: 'Password yang Anda Masukkan Salah',
							icon: 'warning'
						});
					}else if(data === 'status'){
						swal({
							title: 'Peringatan!',
							text: 'Status Akun Non-Aktif',
							icon: 'warning'
						});
					}else if(data === 'success'){
						sessionStorage.setItem('message', 'welcome');
						setTimeout('window.location.replace("./")', 500);
					}
				},
				error: function(xhr, status){
					$('#btn-login').removeClass('btn-progress').closest('.card').removeClass('card-progress');
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

	if(sessionStorage.getItem('message') === 'login'){
		sessionStorage.removeItem('message');
		iziToast.error({
			title: 'Anda Belum Login!',
			message: 'Silahkan masuk untuk memulai sesi',
			position: 'topRight'
		});
	}else if(sessionStorage.getItem('message') === 'register'){
		sessionStorage.removeItem('message');
		iziToast.success({
			title: 'Registrasi Akun Berhasil!',
			message: 'Silahkan login dengan akun Anda',
			position: 'topRight'
		});
	}else if(sessionStorage.getItem('message') === 'password'){
		sessionStorage.removeItem('message');
		iziToast.info({
			title: 'Password Berhasil Diubah!',
			message: 'Silahkan login dengan password baru',
			position: 'topRight'
		});
	}else if(sessionStorage.getItem('message') === 'profile'){
		sessionStorage.removeItem('message');
		iziToast.success({
			title: 'Akun Anda Berhasil Dihapus!',
			message: 'Silahkan hubungi Administrator',
			position: 'topRight'
		});
	}else if(sessionStorage.getItem('message') === 'logout'){
		sessionStorage.removeItem('message');
		iziToast.success({
			title: 'Anda Berhasil Logout!',
			message: 'Silahkan masuk untuk memulai sesi',
			position: 'topRight'
		});
	}

	if(sessionStorage.getItem('message') !== null){

	}
});