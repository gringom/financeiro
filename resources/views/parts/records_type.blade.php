<script>
$(function() {
  var entrada = {
    <?php
    foreach( $records['categories']['entrada'] as $id => $cat ) {
      echo $id . ": '" . $cat . "',";
    }
    ?>
  };
  var saida = {
    <?php
    foreach( $records['categories']['saida'] as $id => $cat ) {
      echo $id . ": '" . $cat . "',";
    }
    ?>
  };

  $( "#type" ).change(function() {
    /*
      Esse if é para verificar se o campo tipo está sendo alterado para uma categoria "similar".
      Ele só altera os options SE for alterado entre um valor de entrada (entrada ou a receber) e valor de saída (saida ou a pagar)
    */
    if( !( $( this ).val() == 'saida' && $('#old_type').val() == 'a_pagar' ) && !( $( this ).val() == 'a_pagar' && $('#old_type').val() == 'saida' ) && !( $( this ).val() == 'entrada' && $('#old_type').val() == 'a_receber' ) && !( $( this ).val() == 'a_receber' && $('#old_type').val() == 'entrada' ) ){
      // limpa o select e adiciona o option padrão
      $('#category_id').empty();
      $('#category_id').append('<option value>Selecionar Categoria...</option>');

      // adiciona os options corretos, de acordo com o tipo informado
      if( $( this ).val() == "entrada" || $( this ).val() == 'a_receber' ){
        $.each( entrada, function( key, value ) {
          $('#category_id').append('<option value="' + key + '">' + value + '</option>');
        });
      }
      else if( $( this ).val() == "saida" || $( this ).val() == 'a_pagar' ){
        $.each( saida, function( key, value ) {
          $('#category_id').append('<option value="' + key + '">' + value + '</option>');
        });
      }

      // habilitar o select
      $( "#category_id" ).prop( "disabled", false );
    }

    // atualizar o valor antigo
    $('#old_type').val( $( this ).val() ) ;
  });
});
</script>