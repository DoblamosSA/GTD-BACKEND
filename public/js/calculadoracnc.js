$(document).ready(function() {
    $('#materiales').select2();
});

//select 2 de los materiales
  $(function() {
    $('#materiales').on('change', function() {
      var peso = $('option:selected', this).data('peso');
      $('#Peso_Material').val(peso);
    });
  });

  //select 2 de los recursos
  $(document).ready(function() {
    $('#Recursos').select2();
});

 

//select 3 de los costos de no calidad
$(document).ready(function() {
  $('#costo_no_calidad').select2();
});


$(document).ready(function() {
  // Agregamos el evento change al select de Recursos
  $('#Recursos').on('change', function() {
      // Obtenemos los datos del recurso seleccionado
      var costo = $('option:selected', this).data('costo');
      var unidad = $('option:selected', this).data('unidad');
      // Mostramos los datos en los campos correspondientes
      $('#Costo_Recurso').val(costo);
      $('#Unidad_Recurso').val(unidad);
  });
});





