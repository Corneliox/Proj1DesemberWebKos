$(document).ready(function(){
	let table = $('#table-users').DataTable({
		processing: true,
		serverSide: false,
		deferRender: true,
		ajax: 'api/users',
		// responsive: true,
		lengthChange: false,
		autoWidth: false,
		order: [[0, 'asc']],
		columns: [
			{
				data: null,
				className: 'text-center',
				// orderable: false,
				searchable: false,
				render: function(data, type, row, meta){
					// return meta.row + meta.settings._iDisplayStart + 1;
					return meta.row + (meta.settings._iDisplayLength-meta.settings._iDisplayLength) + 1;
				}
			},
			{
				data: 'id',
				className: 'text-center',
				orderable: false,
				searchable: false,
				render: function(data, type, row){
					let html = '',
					name = $('#nav-name').text();

					if(row.name == name || row.name == 'Administrator'){
						html = `<div class="btn-group btn-group-sm" role="group">
							<button id="${data}" type="button" class="btn btn-info btn-icon btn-detail" title="" data-toggle="tooltip" data-original-title="Detail Akun">
								<i class="fas fa-eye"></i>
							</button>
							<button id="${data}" type="button" class="btn btn-success btn-icon btn-edit" title="" data-toggle="tooltip" data-original-title="Edit Akun" disabled>
								<i class="fas fa-edit"></i>
							</button>
							<button id="${data}" type="button" class="btn btn-danger btn-icon btn-delete" title="" data-toggle="tooltip" data-original-title="Hapus Akun" disabled>
								<i class="fas fa-trash"></i>
							</button>
						</div>`;
					}else{
						html = `<div class="btn-group btn-group-sm" role="group">
							<button id="${data}" type="button" class="btn btn-info btn-icon btn-detail" title="" data-toggle="tooltip" data-original-title="Detail Akun">
								<i class="fas fa-eye"></i>
							</button>
							<button id="${data}" type="button" class="btn btn-success btn-icon btn-edit" title="" data-toggle="tooltip" data-original-title="Edit Akun">
								<i class="fas fa-edit"></i>
							</button>
							<button id="${data}" type="button" class="btn btn-danger btn-icon btn-delete" title="" data-toggle="tooltip" data-original-title="Hapus Akun">
								<i class="fas fa-trash"></i>
							</button>
						</div>`;
					}
					return html;
				}
			},
			{data: 'name', className: 'text-left'},
			{data: 'username', className: 'text-left'},
			{data: 'password', className: 'text-left', visible: false},
			{
				data: 'level',
				className: 'text-center',
				render: function(data, type, row){
					if(data == 'admin'){
						return `<span class="badge badge-primary badge-pill">${data}</span>`;
					}else if(data == 'operator'){
						return `<span class="badge badge-secondary badge-pill">${data}</span>`;
					}
				}
			},
			{data: 'photo', className: 'text-center', visible: false},
			{
				data: 'status',
				className: 'text-left',
				render: function(data, type, row){
					if(data == 1){
						return '<div class="text-success text-small font-600-bold"><i class="fas fa-circle"></i> Aktif</div>';
					}else if(data == 0){
						return '<div class="text-danger text-small font-600-bold"><i class="fas fa-circle"></i> Nonaktif</div>';
					}
				}
			}
		],
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
		dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>"+
			"<'row'<'col-sm-12'tr>>"+
			"<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
		language: {
			url: 'resources/id.json'
		},
		initComplete: function(settings, json){
			let level = $('#side-level').text().toLowerCase();

			if(level != 'admin'){
				$('.buttons-copy, .buttons-excel, .buttons-pdf').prop('hidden', true);
			}
		},
		drawCallback: function(settings){
			$('[data-toggle="tooltip"]').tooltip({
				trigger: 'hover'
			});
		},
		buttons: [
			{
				className: 'btn-icon btn-primary',
				text: '<i class="fas fa-sync"></i>',
				// text: 'Refresh',
				titleAttr: 'Refresh Data',
				action: function(e, dt, node, config){
					dt.ajax.reload();
				}
			},
			{
				extend: 'copy',
				className: 'btn-icon btn-info',
				text: '<i class="fas fa-copy"></i>',
				titleAttr: 'Copy Data',
				title: 'Mulik Si Awan',
				messageTop: 'Laporan Data Akun',
				messageBottom: `Tanggal ${tanggal('short')}`,
				exportOptions: {
					columns: [0, 2, 3, 5, 7]
				}
			},
			{
				extend: 'excel',
				className: 'btn-icon btn-success',
				text: '<i class="fas fa-file-excel"></i>',
				titleAttr: 'Export Excel',
				title: 'Laporan Data Akun',
				messageTop: 'Mulik Si Awan',
				messageBottom: `Tanggal ${tanggal('short')}`,
				filename: `Laporan Data Akun ${tanggal('short')}`,
				autoFilter: true,
				sheetName: 'Data Akun',
				exportOptions: {
					columns: [0, 2, 3, 5, 7]
				},
				customize: function(xlsx){
					var sheet = xlsx.xl.worksheets['sheet1.xml'];
					$('row c', sheet).attr('s', '25');
					$('row[r="3"] c', sheet).attr('s', '27');
					$('row:eq(0) c', sheet).attr('s', '51');
					$('row:eq(1) c', sheet).attr('s', '51');
					$('row:last c', sheet).attr('s', '51');
				}
			},
			{
				extend: 'pageLength',
				className: 'btn-icon btn-secondary'
			}
		]
	});

	detailData('users');
	addData('users', 'name');
	editData('users', 'name');
	deleteData('users', 'username', 'Akun');
});