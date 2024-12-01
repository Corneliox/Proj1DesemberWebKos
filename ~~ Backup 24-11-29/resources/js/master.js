/* const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000,
	timerProgressBar: true,
	didOpen: (toast) => {
		toast.addEventListener('mouseenter', Swal.stopTimer);
		toast.addEventListener('mouseleave', Swal.resumeTimer);
	}
}); */
const rupiah = (number) => {
	return new Intl.NumberFormat('id-ID', {
		style: 'currency',
		currency: 'IDR'
	}).format(number);
}
function jam(){
	let time = new Date(), hours = time.getHours(), minutes = time.getMinutes(), seconds = time.getSeconds();
	$('#jam').html(`${harold(hours)}:${harold(minutes)}:${harold(seconds)} WIB`);

	function harold(standIn){
		if(standIn < 10){
			standIn = '0' + standIn;
		}
		return standIn;
	}
}
function tanggal(format = 'short', waktu = new Date()){
	let time = new Date(waktu),
	hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
	bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
	day = time.getDay(),
	date = time.getDate(),
	month = time.getMonth(),
	year = time.getFullYear(),
	hours = time.getHours(),
	minutes = time.getMinutes(),
	seconds = time.getSeconds();

	function harold(standIn){
		if(standIn < 10){
			standIn = '0' + standIn;
		}
		return standIn;
	}

	switch(format){
		case 'hari':
			return `Hari ${hari[day]},`;
		break;
		case 'bulan':
			return `${harold(date)} ${bulan[month]} ${year}`;
		break;
		case 'short':
			return `${harold(date)}-${harold(month + 1)}-${year}`;
		break;
		case 'full':
			return `${harold(date)}-${harold(month + 1)}-${year} ${harold(hours)}:${harold(minutes)}:${harold(seconds)}`;
		break;
	}
}
function activePage(){
	let url = window.location.href.split('#')[0];

	$('ul.sidebar-menu a').filter(function(){
		return this.href == url;
	}).closest('li').addClass('active');
	$('ul.dropdown-menu a').filter(function(){
		return this.href == url;
	}).closest('li').addClass('active').parents('li.dropdown').addClass('active');
}
function detailData(variable){
	$(`#table-${variable} tbody`).on('click', '.btn-detail', function(e){
		let id = $(this).attr('id');

		$.getJSON(`api/${variable}/${id}`, function(data){
			$('#modal-detail').modal({
				backdrop: 'static',
				keyboard: false
			});

			for(let x in data){
				if(x == 'level'){
					if(data[x] == 'admin'){
						$(`#detail-${x}`).html(`<span class="badge badge-primary badge-pill">${data[x]}</span>`);
					}else if(data[x] == 'operator'){
						$(`#detail-${x}`).html(`<span class="badge badge-secondary badge-pill">${data[x]}</span>`);
					}
				}else if(x == 'status'){
					if(data[x] == 1){
						$(`#detail-${x}`).html(`<div class="text-success text-small font-600-bold"><i class="fas fa-circle"></i> Aktif</div>`);
					}else{
						$(`#detail-${x}`).html(`<div class="text-danger text-small font-600-bold"><i class="fas fa-circle"></i> Nonaktif</div>`);
					}
				}else if(x == 'total'){
					$(`#detail-${x}`).html(`<span class="badge badge-primary badge-pill">${data[x]}</span>`);
				}else if(x == 'photo'){
					$(`#detail-${x}`).attr('src', `images/photos/${data[x]}`);
				}else if(x == 'created_at' || x == 'updated_at'){
					$(`#detail-${x}`).html(`${tanggal('full', data[x])} WIB`);
				}else{
					$(`#detail-${x}`).html(data[x]);
				}
			}
		}).fail(function(xhr, status){
			swal({
				title: status,
				text: `${xhr.status} ${xhr.statusText}`,
				icon: 'error'
			});
		});
	});
}
function addData(variable, column){
	$('#btn-add').on('click', function(e){
		$('#form-add').removeClass('was-validated');
		$('#form-add')[0].reset();
		$('#modal-add').on('shown.bs.modal', function(){
			$(`#add-${column}`).focus();
		});
	});

	$('#form-add').on('submit', function(e){
		e.preventDefault();
		let cek = true;

		$('#form-add .required').each(function(){
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
			let data = $('#form-add').serialize();
			$.ajax({
				type: 'POST',
				url: `api/${variable}`,
				data: data,
				dataType: 'json',
				beforeSend: function(){
					$('#modal-add .btn-save').addClass('btn-progress').closest('.modal').addClass('modal-progress');
				},
				success: function(data){
					$('#modal-add .btn-save').removeClass('btn-progress').closest('.modal').removeClass('modal-progress');

					if(data.status == 'success'){
						$('#modal-add').modal('hide');
						swal({
							title: data.title,
							text: data.message,
							icon: data.type
						}).then((result) => {
							let table = $(`#table-${variable}`).DataTable();
							table.ajax.reload(null, false);
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
					$('#modal-add .btn-save').removeClass('btn-progress').closest('.modal').removeClass('modal-progress');
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
}
function editData(variable, column){
	$(`#table-${variable} tbody`).on('click', '.btn-edit', function(e){
		let id = $(this).attr('id');

		$.getJSON(`api/${variable}/${id}`, function(data){
			$('#modal-edit').modal({
				backdrop: 'static',
				keyboard: false
			});
			$('#form-edit').removeClass('was-validated');
			$('#form-edit')[0].reset();

			for(let x in data){
				if(x != 'password'){
					$(`#edit-${x}`).val(data[x]);
				}
			}
			$('#modal-edit').on('shown.bs.modal', function(){
				$(`#edit-${column}`).focus();
			});
		}).fail(function(xhr, status){
			swal({
				title: status,
				text: `${xhr.status} ${xhr.statusText}`,
				icon: 'error'
			});
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
			let id = $('#edit-id').val(),
			data = $('#form-edit').serialize();
			$.ajax({
				type: 'POST',
				url: `api/${variable}/${id}`,
				data: data,
				dataType: 'json',
				beforeSend: function(){
					$('#modal-edit .btn-save').addClass('btn-progress').closest('.modal').addClass('modal-progress');
				},
				success: function(data){
					$('#modal-edit .btn-save').removeClass('btn-progress').closest('.modal').removeClass('modal-progress');

					if(data.status == 'success'){
						$('#modal-edit').modal('hide');
						swal({
							title: data.title,
							text: data.message,
							icon: data.type
						}).then((result) => {
							let table = $(`#table-${variable}`).DataTable();
							table.ajax.reload(null, false);
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
					$('#modal-edit .btn-save').removeClass('btn-progress').closest('.modal').removeClass('modal-progress');
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
}
function deleteData(variable, column, page){
	$(`#table-${variable} tbody`).on('click', '.btn-delete', function(e){
		let table = $(`#table-${variable}`).DataTable(),
		row = table.row($(this).parents('tr')).data();
		swal({
			title: 'Apakah Anda Yakin?',
			text: `Hapus "${row[column]}" dari Data ${page}`,
			icon: 'warning',
			buttons: [true, 'Ya, Hapus!'],
			dangerMode: true,
			closeOnClickOutside: false,
			closeOnEsc: false
		}).then((result) => {
			if(result){
				let id = $(this).attr('id');
				$.ajax({
					type: 'POST',
					url: `api/${variable}/${id}`,
					dataType: 'json',
					success: function(data){
						if(data.status == 'success'){
							swal({
								title: data.title,
								text: data.message,
								icon: data.type
							}).then((result) => {
								// let table = $(`#table-${variable}`).DataTable();
								table.ajax.reload(null, false);
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
}
/* $('.number').inputmask({
	alias: 'numeric',
	digits: 0,
	allowMinus: false,
	rightAlign: false
});
$('.year').datepicker({
	format: 'yyyy',
	language: 'id',
	autoclose: true,
	clearBtn: true,
	minViewMode: 2,
	maxViewMode: 2,
	todayHighlight: true,
	disableTouchKeyboard: true
}); */

$(function(){
	activePage();
	setInterval(jam, 1000);

	$('#btn-setelan').on('click', function(e){
		$.getJSON('api/settings/1', function(data){
			$('#form-setelan').removeClass('was-validated');
			$('#form-setelan')[0].reset();

			for(let x in data){
				$(`#setelan-${x}`).val(data[x]);
			}
			$('#modal-setelan').on('shown.bs.modal', function(){
				$('#setelan-mode').focus();
			});
		}).fail(function(xhr, status){
			swal({
				title: status,
				text: `${xhr.status} ${xhr.statusText}`,
				icon: 'error'
			});
		});
	});

	$('#form-setelan').on('submit', function(e){
		e.preventDefault();
		let cek = true;

		$('#form-setelan .required').each(function(){
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
			let data = $('#form-setelan').serialize();
			$.ajax({
				type: 'POST',
				url	: 'api/settings/1',
				data: data,
				dataType: 'json',
				beforeSend: function(){
					$('#modal-setelan .btn-save').addClass('btn-progress').closest('.modal').addClass('modal-progress');
				},
				success: function(data){
					$('#modal-setelan .btn-save').removeClass('btn-progress').closest('.modal').removeClass('modal-progress');

					if(data.status == 'success'){
						$('#modal-setelan').modal('hide');
						swal({
							title: data.title,
							text: data.message,
							icon: data.type
						}).then((result) => {
							setTimeout('window.location.reload()', 500);
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
					$('#modal-setelan .btn-save').removeClass('btn-progress').closest('.modal').removeClass('modal-progress');
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

	$('.logout').on('click', function(e){
		swal({
			title: 'Apakah Anda Yakin?',
			text: 'Anda akan Keluar dari Mulik Si Awan',
			icon: 'warning',
			buttons: [true, 'Ya, Keluar!'],
			dangerMode: true,
			closeOnClickOutside: false,
			closeOnEsc: false
		}).then((result) => {
			if(result){
				$.get('config/authentication.php?auth=logout', function(data){
					if(data === 'success'){
						sessionStorage.setItem('message', 'logout');
						setTimeout('window.location.replace("./login")', 500);
					}else{
						swal({
							title: 'Error!',
							text: 'Anda Gagal Logout',
							icon: 'error'
						});
					}
				}).fail(function(xhr, status){
					swal({
						title: status,
						text: `${xhr.status} ${xhr.statusText}`,
						icon: 'error'
					});
				});
			}else{

			}
		});
	});
});