
// select2 para los recursos 

$(document).ready(function() {
    $('#recurso-select').select2();
});





// // Este código actualiza dinámicamente la lista de calibres y los precios asociados basándose en la selección de lámina y calibre del usuario.
// tambien se permite agregar varias laminas en una tabla. y de cada fila que se agrega se esta sacando el total costo material para sumarlo en un total
$('#lamina-select').on('change', function() {
    var laminaId = $(this).val();
    $.ajax({
        url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/get-calibres/' + laminaId,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#calibre-select').empty();
            $('#calibre-select').append($('<option>').text('Seleccione un calibre'));
            $.each(data.calibres, function(key, value) {
                var precioEnPesos = new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP'
                }).format(value.precio).replace('COP', '');
                $('#calibre-select').append($('<option>').text(value.Calibre).attr('value',
                    value.Calibre).data('precio', value
                    .precio)); // Cambia el valor del option por el calibre
            });
            // Actualizar el precio al seleccionar un nuevo calibre
            $('#calibre-select').on('change', function() {
                var precioEnPesos = new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP'
                }).format($(this).find('option:selected').data('precio')).replace('COP',
                    '');
                $('input[name="Precio_Material"]').val(precioEnPesos);
            });
        }
    });
});

$('#calibre-select').on('change', function() {
    var calibre = $(this).val();
    var cantidadPiezas = $('input[name="Cantidad_Piezas"]').val();
    var desarrollo = $('input[name="desarrollo"]').val();
    var longitud = $('input[name="longitud"]').val();
    var costoMaterialKilo = $('input[name="Costo_Material_Kilo"]').val();
    var pesoKgInput = $('input[name="Peso_kg"]');
    var precioInput = $('input[name="Precio_Material"]');
    var costoMaterialInput = $('input[name="Costo_Material"]');
    var totalInput = $('input[name="Total"]');
    var totalCostoMaterialInput = $('input[name="TotalCostoMaterial"]');

    var pesoKg = (calibre * cantidadPiezas * desarrollo * longitud * 0.00000785).toFixed(2);

    if (calibre && cantidadPiezas && desarrollo && longitud) {
        var precio = $('#calibre-select option:selected').data('precio');
        precioInput.val(precio);

        pesoKgInput.val(pesoKg);

        var costoMaterial = (pesoKg * costoMaterialKilo).toFixed(2);
        costoMaterialInput.val(costoMaterial);

        var totalCostoMaterial = (precio * pesoKg).toLocaleString('es-CO', {
            style: 'currency',
            currency: 'COP'
        });
        totalCostoMaterialInput.val(totalCostoMaterial);

        var total = (costoMaterial * cantidadPiezas).toFixed(2);
        totalInput.val(total);
    } else {
        pesoKgInput.val('');
        precioInput.val('');
        costoMaterialInput.val('');
        totalCostoMaterialInput.val('');
        totalInput.val('');
    }
});

$('input[name="Costo_Material_Kilo"]').on('change keyup', function() {
    $('#calibre-select').trigger('change');
});

$('input[name="Cantidad_Piezas"], input[name="desarrollo"], input[name="longitud"]').on('keyup', function() {
    $('#calibre-select').trigger('change');
});

$(document).on('click', '.add-linea', function() {
    var laminaId = $('#lamina-select').val();
    var calibreId = $('#calibre-select').val();
    var cantidadPiezas = $('input[name="Cantidad_Piezas"]').val();
    var desarrollo = $('input[name="desarrollo"]').val();
    var longitud = $('input[name="longitud"]').val();
    var pesoKG = $('input[name="Peso_kg"]').val();
    var precioMaterial = $('input[name="Precio_Material"]').val();
    var totalCostoMaterial = $('input[name="TotalCostoMaterial"]').val();
    var laminaNombre = $('#lamina-select option:selected').text();

    var filaHTML = '<tr>' +
        '<td>' + laminaNombre + '</td>' +
        '<td>' + calibreId + '</td>' +
        '<td>' + cantidadPiezas + '</td>' +
        '<td>' + desarrollo + '</td>' +
        '<td>' + longitud + '</td>' +
        '<td>' + pesoKG + '</td>' +
        '<td>' + precioMaterial + '</td>' +
        '<td>' + totalCostoMaterial + '</td>' +
        '<td><button class="btn btn-danger eliminar-linea" type="button">Eliminar</button></td>' +
        '</tr>';

    $('#lineas-agregadas tbody').append(filaHTML);

    var sumaTotal = 0;
    $('#lineas-agregadas tbody tr').each(function() {
        var costoMaterial = $(this).find('td:nth-child(8)').text();
        costoMaterial = costoMaterial.replace('$', '').replace(/\./g, '');
        costoMaterial = parseFloat(costoMaterial);
        if (!isNaN(costoMaterial)) {
            sumaTotal += costoMaterial;
        }
    });

    var sumaTotalInput = $('#input-total-costo-material');
    var sumaTotalNumericInput = $('#input-total-costo-material-numeric');
    var sumaTotalFormateada = sumaTotal.toLocaleString('es-ES', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    sumaTotalInput.val(sumaTotalFormateada);
    sumaTotalNumericInput.val(sumaTotal);

    COSTOCNC();
});

$(document).on('click', '.eliminar-linea', function() {
    var fila = $(this).closest('tr');
    var costoMaterial = fila.find('td:nth-child(8)').text();
    costoMaterial = costoMaterial.replace('$', '').replace(/\./g, '');
    costoMaterial = parseFloat(costoMaterial);

    var sumaTotalInput = $('#input-total-costo-material');
    var sumaTotalNumericInput = $('#input-total-costo-material-numeric');
    var sumaTotal = parseFloat(sumaTotalNumericInput.val().replace(/\./g, ''));

    if (!isNaN(costoMaterial) && !isNaN(sumaTotal)) {
        sumaTotal -= costoMaterial;
        var sumaTotalFormateada = sumaTotal.toLocaleString('es-ES', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        sumaTotalInput.val(sumaTotalFormateada);
        sumaTotalNumericInput.val(sumaTotal);

        COSTOCNC();
        
        fila.remove();
    }
});




//fin de el primer codigo de material implicito en el costo


// ------------------------------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------------


//este es el manejador para los recursos

const cantidadInput = document.querySelector('.cantidad');
const horasInput = document.querySelector('.horas');
const costoInput = document.querySelector('.Cost1');
const sumaRecursoInput = document.querySelector('.SumaRecursoNivelLinea');
const sumaRecursoFormattedInput = document.querySelector('.SumaRecursoNivelLineaFormatted');

cantidadInput.addEventListener('input', calcularSumaRecurso);
horasInput.addEventListener('input', calcularSumaRecurso);
costoInput.addEventListener('input', calcularSumaRecurso);

function calcularSumaRecurso() {
    const cantidad = parseFloat(cantidadInput.value) || 0;
    const horas = parseFloat(horasInput.value) || 0;
    const costo = parseFloat(costoInput.value) || 0;

    const resultado = cantidad * horas * costo;

    const formatoPesos = {
        style: 'currency',
        currency: 'COP'
    };
    const resultadoFormateado = resultado.toLocaleString('es-CO', formatoPesos);

    sumaRecursoInput.value = resultado.toFixed(2);
    sumaRecursoFormattedInput.value = resultadoFormateado;

    COSTOCNC();
}

const recursoSelect = document.getElementById('recurso-select');
const unidadMedidaInput = document.querySelector('.unit-of-measure');

$('#recurso-select').on('select2:select', function (e) {
  const recursoId = e.params.data.id;

  fetch(`https://rdpd.sagerp.co:59881/gestioncalidad/public/recursos/${recursoId}`)
      .then(response => response.json())
      .then(data => {
          costoInput.value = data.Cost1;
          unidadMedidaInput.value = data.UnitOfMeasure;

          calcularSumaRecurso();
      })
      .catch(error => {
          console.log(error);
      });
});

const agregarBoton = document.querySelector('.add-recursos');
agregarBoton.addEventListener('click', agregarFila);

const recursosContainer = document.getElementById('recursos');

let totalSubtotales = 0;

recursosContainer.addEventListener('click', function(event) {
  if (event.target.classList.contains('delete-row')) {
      const recursoDiv = event.target.closest('.input-group');
      const subtotalEliminado = parseFloat(recursoDiv.querySelector('.subtotal').getAttribute('data-subtotal')) || 0;

      restarSubtotalEliminado(subtotalEliminado);
      
      recursosContainer.removeChild(recursoDiv);
  }
});

function restarSubtotalEliminado(subtotalEliminado) {
  totalSubtotales -= subtotalEliminado;
  calcularSumaTotalRecursos();
}

function agregarFila() {
  const recursoId = recursoSelect.value;
  const recursoNombre = recursoSelect.options[recursoSelect.selectedIndex].text;
  const cantidad = parseFloat(cantidadInput.value) || 0;
  const horas = parseFloat(horasInput.value) || 0;
  const costo = parseFloat(costoInput.value) || 0;
  const subtotal = cantidad * horas * costo;
  totalSubtotales += subtotal;

  if (recursoId && cantidad && horas && costo) {
      const recursoDiv = document.createElement('div');
      recursoDiv.classList.add('input-group', 'mb-3');

      const recursoTexto = document.createElement('input');
      recursoTexto.type = 'text';
      recursoTexto.classList.add('form-control');
      recursoTexto.value = recursoNombre;
      recursoTexto.readOnly = true;

      const cantidadTexto = document.createElement('input');
      cantidadTexto.type = 'text';
      cantidadTexto.classList.add('form-control', 'flex-fill');
      cantidadTexto.value = cantidad;
      cantidadTexto.readOnly = true;

      const horasTexto = document.createElement('input');
      horasTexto.type = 'text';
      horasTexto.classList.add('form-control');
      horasTexto.value = horas;
      horasTexto.readOnly = true;

      const subtotalTexto = document.createElement('input');
      subtotalTexto.type = 'text';
      subtotalTexto.classList.add('form-control', 'flex-fill', 'subtotal');
      subtotalTexto.value = subtotal.toLocaleString('es-CO', { style: 'currency', currency: 'COP' });
      subtotalTexto.setAttribute('data-subtotal', subtotal);
      subtotalTexto.readOnly = true;

      const eliminarBoton = document.createElement('button');
      eliminarBoton.type = 'button';
      eliminarBoton.classList.add('btn', 'btn-danger', 'delete-row');
      eliminarBoton.textContent = 'Eliminar';

      recursoDiv.appendChild(recursoTexto);
      recursoDiv.appendChild(cantidadTexto);
      recursoDiv.appendChild(horasTexto);
      recursoDiv.appendChild(subtotalTexto);
      recursoDiv.appendChild(eliminarBoton);

      recursosContainer.appendChild(recursoDiv);

      calcularSumaTotalRecursos();

      recursoSelect.value = '';
      cantidadInput.value = '';
      horasInput.value = '';
      costoInput.value = '';
      unidadMedidaInput.value = '';
  }
}

function calcularSumaTotalRecursos() {
    const totalRecursosInput = document.getElementById('total-recursos-form');
    totalRecursosInput.value = totalSubtotales.toFixed(2);
    const totalRecursosFormattedInput = document.getElementById('total-recursos-formatted');
    totalRecursosFormattedInput.value = totalSubtotales.toLocaleString('es-CO', { style: 'currency', currency: 'COP' });

    COSTOCNC();
}

//fin manejador de los recursos

//manejador transporte logistica 
$(document).ready(function() {
    $('#transporte-logistica').change(function() {
        var transporteId = $(this).val();
        var selectedOption = $(this).val();

        if (transporteId) {
            $.ajax({
                url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/get-transporte/' + transporteId,
                type: 'GET',
                success: function(response) {
                    var valorTransporte = response[0].valorTransporte;
                    $('#valor-transporte-form').val(valorTransporte); // Muestra el valor numérico para cálculos

                    // Formatear el valor del transporte a la moneda local con dos decimales
                    var valorFormateado = parseFloat(valorTransporte).toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    $('#valor-transporte-formatted').val(valorFormateado); // Muestra el valor formateado para la visualización del usuario

                    COSTOCNC(); // Llamar a COSTOCNC después de cambiar el valor del transporte
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#valor-transporte-form').val('');
            $('#valor-transporte-formatted').val('');

            COSTOCNC(); // Llamar a COSTOCNC después de cambiar el valor del transporte
        }

        if (selectedOption === 'otro') {
            $('#valor-transporte-form').val('');
            $('#valor-transporte-formatted').val('');
            $('#valor-transporte-formatted').prop('disabled', true);
            $('.otro-valor-transporte').show();
            $('.otro-valor-transporte').prop('disabled', false);
        } else {
            $('#valor-transporte-form').val('');
            $('#valor-transporte-formatted').val('');
            $('#valor-transporte-formatted').prop('disabled', false);
            $('.otro-valor-transporte').hide();
            $('.otro-valor-transporte').prop('disabled', true);
        }
    });
     // Agregar un evento de cambio para el campo 'otro-valor-transporte'
     $('#otro-valor-transporte').change(function() {
        var otroValorTransporte = $(this).val();
        $('#valor-transporte-form').val(otroValorTransporte);
         COSTOCNC();
     });
    

});


//otros costos capturar valor

$(document).ready(function() {
    

    // Actualiza la suma total del CNC cada vez que se cambia el valor de "Otros costos"
    $('#otros-costos').change(COSTOCNC);

});


//manejador de material recuperado chatarra
$(document).ready(function() {
    $('#recursos-recuperado').change(function() {
      var selectedOption = $(this).find('option:selected');
      var recursoId = selectedOption.val();
  
      // Realizar la solicitud AJAX
      $.ajax({
        url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/material-recuperado-chatarra/' + recursoId,
        type: 'GET',
        success: function(data) {
          // Actualizar el campo del precio de la chatarra con los datos recibidos
          var precio = data.Cost1;
          $('#precio-chatarra-form').val(precio); // Muestra el valor numérico para cálculos
  
          // Formatear el precio a pesos colombianos con dos decimales
          var precioFormateado = parseFloat(precio).toLocaleString('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });
  
          // Mostrar el precio formateado en el campo visible
          $('#precio-chatarra-formatted').val(precioFormateado);
  
          // Calcular el total al cambiar la cantidad
          calcularTotal();
        },
        error: function() {
          // Manejo de errores
          alert('Ocurrió un error al obtener el precio de la chatarra.');
        }
      });
    });
  
    $('#cantidad').keyup(function() {
      // Calcular el total al cambiar la cantidad
      calcularTotal();
    });
  
    function calcularTotal() {
      var cantidad = parseFloat($('#cantidad').val());
      var precio = parseFloat($('#precio-chatarra-form').val()); // Utiliza el valor numérico del precio
      var total = cantidad * precio;
  
      // Formatear el resultado a pesos colombianos con dos decimales
      var totalFormateado = total.toLocaleString('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
  
      // Mostrar el resultado en el campo correspondiente
      $('#total-recuperado-chatarra-form').val(total.toFixed(2)); // Muestra el valor numérico para cálculos
      $('#total-recuperado-chatarra-formatted').val(totalFormateado); // Muestra el valor formateado para la visualización del usuario
      sumavalorrecuperado();
    }
  
 
  });
  


//material recuperado materia prima laminas


// $('#materialrecuperadomateriaprima').on('change', function() {
//     var laminaId = $(this).val();
//     $.ajax({
//       url: '/get-calibres/' + laminaId,
//       type: 'GET',
//       dataType: 'json',
//       success: function(data) {
//         $('#calibre-select-mpmaterialrecuperado').empty();
//         $('#calibre-select-mpmaterialrecuperado').append($('<option>').text('Seleccione un calibre'));
//         $.each(data.calibres, function(key, value) {
//           var precioEnPesos = new Intl.NumberFormat('es-CO', {
//             style: 'currency',
//             currency: 'COP'
//           }).format(value.precio).replace('COP', '');
//           $('#calibre-select-mpmaterialrecuperado').append($('<option>').text(value.Calibre).attr('value', value.id).data('precio', value.precio));
//         });
  
//         $('#calibre-select-mpmaterialrecuperado').on('change', function() {
//           var precioEnPesos = new Intl.NumberFormat('es-CO', {
//             style: 'currency',
//             currency: 'COP'
//           }).format($(this).find('option:selected').data('precio')).replace('COP', '');
//           $('input[name="Precio_Material-recuperadomp"]').val(precioEnPesos);
//         });
//       }
//     });
//   });
  
//   $('#calibre-select-mpmaterialrecuperado').on('change', function() {
//     var calibre = $(this).val();
//     var cantidadPiezas = $('#cantidadpiezasmprecuperado').val();
//     var desarrollo = $('input[name="desarrollo-recuperadomp"]').val();
//     var longitud = $('input[name="longitud-recuperadomp"]').val();
//     var pesoKgInput = $('input[name="Peso_kg-recuperadomp"]');
//     var precioInput = $('input[name="Precio_Material-recuperadomp"]');
//     var totalInput = $('#total-costo-material-recuperado');
  
//     var pesoKg = (calibre * cantidadPiezas * desarrollo * longitud * 0.00000785).toFixed(2);
  
//     if (calibre && cantidadPiezas && desarrollo && longitud) {
//       var precio = $('#calibre-select-mpmaterialrecuperado option:selected').data('precio');
//       precioInput.val(precio);
  
//       pesoKgInput.val(pesoKg);
  
//       var totalCostoMaterial = (precio * pesoKg).toLocaleString('es-CO', {
//         style: 'currency',
//         currency: 'COP'
//       });
//       totalInput.val(totalCostoMaterial);
//     } else {
//       pesoKgInput.val('');
//       precioInput.val('');
//       totalInput.val('');
//     }
//   });
  
//   $('input[name="desarrollo-recuperadomp"], input[name="longitud-recuperadomp"], #cantidadpiezasmprecuperado').on('keyup', function() {
//     $('#calibre-select-mpmaterialrecuperado').trigger('change');
//   });
  
//   $(document).on('click', '.add-linea-materialrecuperadomp', function() {
//     var laminaId = $('#materialrecuperadomateriaprima').val();
//     var calibreId = $('#calibre-select-mpmaterialrecuperado').val();
//     var cantidadPiezas = $('#cantidadpiezasmprecuperado').val();
//     var desarrollo = $('input[name="desarrollo-recuperadomp"]').val();
//     var longitud = $('input[name="longitud-recuperadomp"]').val();
//     var pesoKg = $('input[name="Peso_kg-recuperadomp"]').val();
//     var precioMaterial = $('input[name="Precio_Material-recuperadomp"]').val();
//     var total = $('#total-costo-material-recuperado').val();
  
//     if (!laminaId || !calibreId || !cantidadPiezas || !desarrollo || !longitud || !pesoKg || !precioMaterial || !total) {
//       alert('Por favor complete todos los campos antes de agregar una nueva línea.');
//       return;
//     }
  
//     var filaHTML = '<tr><td>' + laminaId + '</td><td>' + calibreId + '</td><td>' + cantidadPiezas + '</td><td>' + desarrollo + '</td><td>' + longitud + '</td><td>' + pesoKg + '</td><td>' + precioMaterial + '</td><td>' + total + '</td><td><button class="btn btn-danger remove-linea-materialrecuperadomp" type="button">Eliminar</button></td></tr>';
//     $('#lineas-agregadas-matrecupemp tbody').append(filaHTML);
  
//     var sumaTotal = 0;
//     $('#lineas-agregadas-matrecupemp tbody tr').each(function() {
//       var costoMaterial = $(this).find('td:nth-child(8)').text();
//       costoMaterial = costoMaterial.replace('$', '').replace(/\./g, '');
//       costoMaterial = parseFloat(costoMaterial);
//       if (!isNaN(costoMaterial)) {
//         sumaTotal += costoMaterial;
//       }
//     });
  
//     var sumaTotalInput = $('#total-recuperado-chatarramp');
//     var sumaTotalFormateada = sumaTotal.toLocaleString('es-CO', {
//       style: 'currency',
//       currency: 'COP',
//       minimumFractionDigits: 2,
//       maximumFractionDigits: 2
//     });
  
//     sumaTotalInput.val(sumaTotalFormateada);
//     sumavalorrecuperado(sumaTotal);
//   });
  
//   $(document).on('click', '.remove-linea-materialrecuperadomp', function() {
//     $(this).closest('tr').remove();
  
//     var sumaTotal = 0;
//     $('#lineas-agregadas-matrecupemp tbody tr').each(function() {
//       var costoMaterial = $(this).find('td:nth-child(8)').text();
//       costoMaterial = costoMaterial.replace('$', '').replace(/\./g, '');
//       costoMaterial = parseFloat(costoMaterial);
//       if (!isNaN(costoMaterial)) {
//         sumaTotal += costoMaterial;
//       }
//     });
  
//     var sumaTotalInput = $('#total-recuperado-chatarramp');
//     var sumaTotalFormateada = sumaTotal.toLocaleString('es-CO', {
//       style: 'currency',
//       currency: 'COP',
//       minimumFractionDigits: 2,
//       maximumFractionDigits: 2
//     });
  
//     sumaTotalInput.val(sumaTotalFormateada);
//     sumavalorrecuperado(sumaTotal);

//   });
  
  // fin recuperado materia prima laminas



// prueba material recuperado

$('#lamina-selectmp').on('change', function() {
    var laminaId = $(this).val();
    $.ajax({
        url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/get-calibres/' + laminaId,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#calibre-selectmp').empty();
            $('#calibre-selectmp').append($('<option>').text('Seleccione un calibre'));
            $.each(data.calibres, function(key, value) {
                var precioEnPesos = new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP'
                }).format(value.precio).replace('COP', '');
                $('#calibre-selectmp').append($('<option>').text(value.Calibre).attr('value',
                    value.Calibre).data('precio', value
                    .precio)); // Cambia el valor del option por el calibre
            });
            // Actualizar el precio al seleccionar un nuevo calibre
            $('#calibre-selectmp').on('change', function() {
                var precioEnPesos = new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP'
                }).format($(this).find('option:selected').data('precio')).replace('COP',
                    '');
                $('input[name="Precio_Materialmp"]').val(precioEnPesos);
            });
        }
    });
});

$('#calibre-selectmp').on('change', function() {
    var calibre = $(this).val();
    var cantidadPiezas = $('input[name="Cantidad_Piezasmp"]').val();
    var desarrollo = $('input[name="desarrollomp"]').val();
    var longitud = $('input[name="longitudmp"]').val();
    var costoMaterialKilo = $('input[name="Costo_Material_Kilomp"]').val();
    var pesoKgInput = $('input[name="Peso_kgmp"]');
    var precioInput = $('input[name="Precio_Materialmp"]');
    var costoMaterialInput = $('input[name="Costo_Materialmp"]');
    var totalInput = $('input[name="Totalmp"]');
    var totalCostoMaterialInput = $('input[name="TotalCostoMaterialmp"]');

    var pesoKg = (calibre * cantidadPiezas * desarrollo * longitud * 0.00000785).toFixed(2);

    if (calibre && cantidadPiezas && desarrollo && longitud) {
        var precio = $('#calibre-selectmp option:selected').data('precio');
        precioInput.val(precio);

        pesoKgInput.val(pesoKg);

        var costoMaterial = (pesoKg * costoMaterialKilo).toFixed(2);
        costoMaterialInput.val(costoMaterial);

        var totalCostoMaterial = (precio * pesoKg).toLocaleString('es-CO', {
            style: 'currency',
            currency: 'COP'
        });
        totalCostoMaterialInput.val(totalCostoMaterial);

        var total = (costoMaterial * cantidadPiezas).toFixed(2);
        totalInput.val(total);
    } else {
        pesoKgInput.val('');
        precioInput.val('');
        costoMaterialInput.val('');
        totalCostoMaterialInput.val('');
        totalInput.val('');
    }
});

$('input[name="Costo_Material_Kilomp"]').on('change keyup', function() {
    $('#calibre-selectmp').trigger('change');
});

$('input[name="Cantidad_Piezasmp"], input[name="desarrollomp"], input[name="longitudmp"]').on('keyup', function() {
    $('#calibre-selectmp').trigger('change');
});

$(document).on('click', '.add-lineamp', function() {
    var laminaId = $('#lamina-selectmp').val();
    var calibreId = $('#calibre-selectmp').val();
    var cantidadPiezas = $('input[name="Cantidad_Piezasmp"]').val();
    var desarrollo = $('input[name="desarrollomp"]').val();
    var longitud = $('input[name="longitudmp"]').val();
    var pesoKG = $('input[name="Peso_kgmp"]').val();
    var precioMaterial = $('input[name="Precio_Materialmp"]').val();
    var totalCostoMaterial = $('input[name="TotalCostoMaterialmp"]').val();
    var laminaNombre = $('#lamina-selectmp option:selected').text();

    var filaHTML = '<tr>' +
        '<td>' + laminaNombre + '</td>' +
        '<td>' + calibreId + '</td>' +
        '<td>' + cantidadPiezas + '</td>' +
        '<td>' + desarrollo + '</td>' +
        '<td>' + longitud + '</td>' +
        '<td>' + pesoKG + '</td>' +
        '<td>' + precioMaterial + '</td>' +
        '<td>' + totalCostoMaterial + '</td>' +
        '<td><button class="btn btn-danger eliminar-lineamp" type="button">Eliminar</button></td>' +
        '</tr>';

    $('#lineas-agregadasmp tbody').append(filaHTML);

    var sumaTotal = 0;
    $('#lineas-agregadasmp tbody tr').each(function() {
        var costoMaterial = $(this).find('td:nth-child(8)').text();
        costoMaterial = costoMaterial.replace('$', '').replace(/\./g, '');
        costoMaterial = parseFloat(costoMaterial);
        if (!isNaN(costoMaterial)) {
            sumaTotal += costoMaterial;
        }
    });

    var sumaTotalInput = $('#input-total-costo-materialmp');
    var sumaTotalNumericInput = $('#input-total-costo-material-numericmp');
    var sumaTotalFormateada = sumaTotal.toLocaleString('es-ES', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    sumaTotalInput.val(sumaTotalFormateada);
    sumaTotalNumericInput.val(sumaTotal);

    sumavalorrecuperado(sumaTotal);
});

$(document).on('click', '.eliminar-lineamp', function() {
    var fila = $(this).closest('tr');
    var costoMaterial = fila.find('td:nth-child(8)').text();
    costoMaterial = costoMaterial.replace('$', '').replace(/\./g, '');
    costoMaterial = parseFloat(costoMaterial);

    var sumaTotalInput = $('#input-total-costo-materialmp');
    var sumaTotalNumericInput = $('#input-total-costo-material-numericmp');
    var sumaTotal = parseFloat(sumaTotalNumericInput.val().replace(/\./g, ''));

    if (!isNaN(costoMaterial) && !isNaN(sumaTotal)) {
        sumaTotal -= costoMaterial;
        var sumaTotalFormateada = sumaTotal.toLocaleString('es-ES', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        sumaTotalInput.val(sumaTotalFormateada);
        sumaTotalNumericInput.val(sumaTotal);

        sumavalorrecuperado(sumaTotal);
        
        fila.remove();
    }
});





  //inicio material estandar

  $(document).ready(function() {
    // Variables globales para almacenar los totales
    var totalSumatoria = 0;
    var sumatotalmaterialestandarInput = $('#sumatotalmaterialestandar');

    // Función para obtener el precio por material desde el servidor
    function obtenerPrecioPorMaterial(materialId) {
        $.ajax({
            url: 'https://rdpd.sagerp.co:59881/gestioncalidad/public/obtener-precio/' + materialId,
            type: 'GET',
            success: function(response) {
                // Actualizar el costo del material seleccionado
                $('#CostoMaterialEstandar').val(response.StandardAveragePrice);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    // Función para formatear el valor en pesos colombianos
    function formatearNumero(valor) {
        return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(valor);
    }

    // Inicializar Select2
    $('#materialestandarselect').select2();

    // Evento cuando se selecciona un material
    $('#materialestandarselect').change(function() {
        var materialId = $(this).val();
        obtenerPrecioPorMaterial(materialId);
    });

    // Evento para agregar una fila de material estándar
    $('.add-material-estandar').click(function() {
        var materialId = $('#materialestandarselect').val();
        var materialName = $('#materialestandarselect option:selected').text(); // Obtener el nombre del material seleccionado
        var cantidad = parseFloat($('#cantidad-Material-Estandar').val());
        var costo = parseFloat($('#CostoMaterialEstandar').val());
        var total = cantidad * costo;

        // Agregar la fila a la tabla
        var fila = '<tr>' +
            '<td>' + materialName + '</td>' + // Mostrar el nombre del material en lugar del ID
            '<td>' + cantidad + '</td>' +
            '<td>' + formatearNumero(costo) + '</td>' +
            '<td>' + formatearNumero(total) + '</td>' +
            '<td><button class="btn btn-danger btn-sm remove-material" type="button">Eliminar</button></td>' +
            '</tr>';
        $('#tabla-materiales tbody').append(fila);

        // Actualizar la suma total de materiales estándar
        totalSumatoria += total;
        sumatotalmaterialestandarInput.val(totalSumatoria);
        $('#sumatotalmaterialestandar-visible').val(formatearNumero(totalSumatoria));

        // Limpiar los campos de entrada
        $('#materialestandarselect').val('').trigger('change');
        $('#cantidad-Material-Estandar').val('');
        $('#CostoMaterialEstandar').val('');

        COSTOCNC(); // Llamar a la función COSTOCNC después de agregar una fila de material
    });

    // Evento para eliminar una fila de material
    $(document).on('click', '.remove-material', function() {
        $(this).closest('tr').remove(); // Elimina la fila actual del material
    
        // Recalcular la suma total de materiales estándar
        totalSumatoria = 0;
        $('#tabla-materiales tbody tr').each(function() {
            var totalColumnText = $(this).find('td:nth-child(4)').text().replace(/\$|\./g, '').replace(/,/g, '.');
            var totalColumn = parseFloat(totalColumnText);
    
            if(!isNaN(totalColumn)) { // Verificar si totalColumn no es NaN
                totalSumatoria += totalColumn;
            }
        });
    
        sumatotalmaterialestandarInput.val(totalSumatoria);
        
        $('#sumatotalmaterialestandar-visible').val(formatearNumero(totalSumatoria));
    
        COSTOCNC(); // Llamar a la función COSTOCNC después de eliminar una fila de material
    });
    

  });



//funcion para sumar el valor recuperado

 

//funcion para sumar el valor recuperado
function sumavalorrecuperado(sumaTotal) {
    var totalRecuperadochatarra = parseFloat($('#total-recuperado-chatarra-form').val());
    var totalvalorrecuperadomateriap = sumaTotal;
    var sumaTotalFinal = 0;
  


    if (!isNaN(totalRecuperadochatarra) && isNaN(totalvalorrecuperadomateriap)) {
      sumaTotalFinal = totalRecuperadochatarra;
    } else if (isNaN(totalRecuperadochatarra) && !isNaN(totalvalorrecuperadomateriap)) {
      sumaTotalFinal = totalvalorrecuperadomateriap;
    } else if (!isNaN(totalRecuperadochatarra) && !isNaN(totalvalorrecuperadomateriap)) {
      sumaTotalFinal = totalRecuperadochatarra + totalvalorrecuperadomateriap;
    }
  
    console.log("Total Recuperado Chatarra: " + totalRecuperadochatarra);
    console.log("Total Valorización Material Recuperado: " + totalvalorrecuperadomateriap);
    console.log("Suma Total: " + sumaTotalFinal);
  
    // Establecer el valor en el input
  
    $('#SaldoRecuperado').val(sumaTotalFinal);
    $('#SaldoRecuperadoHidden').val(sumaTotalFinal); // Actualiza el campo oculto

    var sumaTotalFinalFormateado = sumaTotalFinal.toLocaleString('es-CO',{
      style: 'currency',
      currency: 'COP',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    })
    $('#SaldoRecuperado-formateado').val(sumaTotalFinalFormateado);
    COSTOCNC(sumaTotalFinal);
    
  }


 

  function COSTOCNC(sumaTotalFinal) {
    var inputTotalCostoMaterialNumeric = parseFloat($('#input-total-costo-material-numeric').val());
    var totalRecursosForm = parseFloat(document.getElementById('total-recursos-form').value);
    var totalEstandar = parseFloat(document.getElementById('sumatotalmaterialestandar').value);
    var valorTransporte = parseFloat($('#valor-transporte-form').val());
    var otrosCostos = parseFloat(document.getElementById('otros-costos').value);
    var sumaTotalFinalrecuperado = sumaTotalFinal;
  
    if (isNaN(inputTotalCostoMaterialNumeric)) {
      inputTotalCostoMaterialNumeric = 0;
    }
    if (isNaN(totalRecursosForm)) {
      totalRecursosForm = 0;
    }
    if (isNaN(totalEstandar)) {
      totalEstandar = 0;
    }
    if (isNaN(valorTransporte)) {
      valorTransporte = 0;
    }
    if (isNaN(otrosCostos)) {
      otrosCostos = 0;
    }
    if (isNaN(sumaTotalFinalrecuperado)) {
      sumaTotalFinalrecuperado = 0;
    }
  
    var saldoFinalCNC = inputTotalCostoMaterialNumeric + totalRecursosForm + totalEstandar + valorTransporte + otrosCostos - sumaTotalFinalrecuperado;
    var CostoCNC = inputTotalCostoMaterialNumeric + totalRecursosForm + totalEstandar + valorTransporte + otrosCostos;
    var CostoCNCFormateado = CostoCNC.toLocaleString('es-CO', {
      style: 'currency',
      currency: 'COP',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
    var saldoFinalCNCFormateado = saldoFinalCNC.toLocaleString('es-CO', {
      style: 'currency',
      currency: 'COP',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });


    // Actualizar el valor del input con el resultado
    $('#SaldoFinalCNC').val(saldoFinalCNC);
    $('#SaldoFinalCNC-Recuperado').val(saldoFinalCNCFormateado);
    $('#CostoCNC').val(CostoCNC);
    $('#CostoCNC-formateado').val(CostoCNCFormateado);
  }
  
  