<script>
$(function() {
    $( "#payment_date" ).datepicker({
      dateFormat: "dd/mm/yy",
      showButtonPanel: true,
      currentText: "Hoje",
      closeText: "X"
    });
    $( "#paid_date" ).datepicker({
      dateFormat: "dd/mm/yy",
      showButtonPanel: true,
      beforeShowDay: $.datepicker.noWeekends,
      currentText: "Hoje",
      closeText: "X"
    });
});
</script>