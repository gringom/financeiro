<script>
$('.datepicker').daterangepicker({
	"autoUpdateInput": false,
	"ranges": {
		'Hoje': [moment(), moment()],
		'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		'Últ. 7 dias': [moment().subtract(6, 'days'), moment()],
		'Últ. 30 dias': [moment().subtract(29, 'days'), moment()],
		'Esse mês': [moment().startOf('month'), moment().endOf('month')],
		'Mês passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	},
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Limpar",
        "customRangeLabel": "Personalizar",
        "daysOfWeek": ["Dom","Seg","Ter","Qua","Qui","Sex","Sab"],
        "monthNames": ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"]
    },
    "startDate": <?=$start_date;?>,
    "endDate": <?=$end_date;?>
});
$('#data_venc').on('apply.daterangepicker', function(ev, picker) {
	$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
});
$('#data_venc').on('cancel.daterangepicker', function(ev, picker) {
	$(this).val('');
});
$('#data_pag').on('apply.daterangepicker', function(ev, picker) {
	$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
});
$('#data_pag').on('cancel.daterangepicker', function(ev, picker) {
	$(this).val('');
});
</script>