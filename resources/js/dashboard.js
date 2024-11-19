function viewInfo(){
	$.getJSON('api/dashboard/info', function(data){
		$('#total_classification').text(data.total_classification);
		$('#total_archive').text(data.total_archive);
		$('#total_admin').text(data.total_admin);
		$('#total_operator').text(data.total_operator);
	}).fail(function(xhr){
		console.log(`viewInfo(${xhr.status}: ${xhr.statusText})`)
	});
}
function viewArchive(){
	$.getJSON('api/dashboard/archive', function(data){
		let html = '';

		if(data.length){
			$.each(data, function(key, value){
				html += `<tr>
					<td>${key + 1}.</td>
					<td>${value.code}</td>
					<td><span class="badge badge-primary">${value.total}</span></td>
				</tr>`;
			});
		}else{
			html += '<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>';
		}
		$('#table-archives tbody').html(html);
	}).fail(function(xhr){
		console.log(`viewArchive(${xhr.status}: ${xhr.statusText})`)
	});
}
function viewStatistic(){
	$.getJSON('api/dashboard/statistic', function(data){
		let labels = [],
		total1 = [],
		total2 = [];

		for(let i in data){
			labels.push(data[i].labels);
			total1.push(data[i].total1);
			total2.push(data[i].total2);
		}

		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: labels,
				datasets: [{
					label: data[0].label1,
					data: total1,
					borderWidth: 2,
					backgroundColor: 'rgba(63,82,227,.8)',
					borderWidth: 0,
					borderColor: 'transparent',
					pointBorderWidth: 0,
					pointRadius: 3.5,
					pointBackgroundColor: 'transparent',
					pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
				},
				{
					label: data[1].label2,
					data: total2,
					borderWidth: 2,
					backgroundColor: 'rgba(254,86,83,.7)',
					borderWidth: 0,
					borderColor: 'transparent',
					pointBorderWidth: 0 ,
					pointRadius: 3.5,
					pointBackgroundColor: 'transparent',
					pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
				}]
			},
			options: {
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						gridLines: {
							// display: false,
							drawBorder: false,
							color: '#f2f2f2',
						},
						ticks: {
							beginAtZero: true,
							callback: function(value){
								if(!(value % 10)){
									return value
								}
							}
							/* stepSize: 50,
							callback: function(value, index, values) {
								return '$' + value;
							} */
						}
					}],
					xAxes: [{
						gridLines: {
							display: false,
							tickMarkLength: 15,
						}
					}]
				},
			}
		});
	}).fail(function(xhr){
		console.log(`viewStatistic(${xhr.status}: ${xhr.statusText})`)
	});
}

$(document).ready(function(){
	viewInfo();
	viewArchive();
	viewStatistic();

	$('#tanggal').text(`${tanggal('hari')} ${tanggal('bulan')}`);

	$('#year').on('click', function(e){
		$('#title').text('Berdasarkan Tahun');
		$('#bar_statistic').addClass('d-none');
		$('#line_statistic').removeClass('d-none');
	});

	$('#archive_types').on('click', function(e){
		$('#title').text(`Berdasarkan Jenis Arsip`);
		$('#line_statistic').addClass('d-none');
		$('#bar_statistic').removeClass('d-none');
	});

	let name = $('#nav-name').text();

	if(sessionStorage.getItem('message') === 'welcome'){
		sessionStorage.removeItem('message');
		iziToast.success({
			title: `Selamat Datang ${name}!`,
			message: 'Temu Balik Arsip Kepegawaian',
			position: 'topRight'
		});
	}else if(sessionStorage.getItem('message') === 'welcome-back'){
		sessionStorage.removeItem('message');
		iziToast.info({
			title: `Selamat Datang Kembali ${name}!`,
			message: 'Temu Balik Arsip Kepegawaian',
			position: 'topRight'
		});
	}

	if(sessionStorage.getItem('message') !== null){

	}
});