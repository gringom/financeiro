<script>
$("#value_range").bootstrapSlider({
  reversed: false,
  scale: 'logarithmic',
  formatter: function(value) {
    return 'R$' + $.number( value[0], 2, ',', '.' ) + ' : R$' + $.number( value[1], 2, ',', '.' ) ;
  }
});
</script>