

$(document).ready(function() {
    $('#causa_raiz').prop('disabled', true);
    $('#subproceso').change(function() {
        var subproceso = $(this).val();
        $('#causa_raiz').prop('disabled', true);
        $('#causa_raiz').empty();

        if(subproceso && subproceso != 'Subproceso CNC'){
            $('#causa_raiz').prop('disabled', false);

        }
        if (subproceso == 'Laser') {
            $('#causa_raiz').append('<option value="Corte especificado fuera de las tolerancias del proceso">Corte especificado fuera de las tolerancias del proceso</option>');
            $('#causa_raiz').append('<option value="Bisel excesivo">Bisel excesivo</option>');
            $('#causa_raiz').append('<option value="Selección errada del gas de corte">Selección errada del gas de corte</option>');
            $('#causa_raiz').append('<option value="Daño de los consumibles por mala operación">Daño de los consumibles por mala operación</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');
        }
        else if (subproceso == 'Cizalla') {
            $('#causa_raiz').append('<option value="Corte en cizalla sin las medidas del plano">Corte en cizalla sin las medidas del plano</option>');
            $('#causa_raiz').append('<option value="Corte en plasma manual con mal acabado">Corte en plasma manual con mal acabado</option>');
            $('#causa_raiz').append('<option value=" Corte en plasma manual sin las medidas del plano"> Corte en plasma manual sin las medidas del plano</option>');
            $('#causa_raiz').append('<option value=" Proceso de corte erroneo">  Proceso de corte erróneo</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');
           
        } else if (subproceso == 'Pantografo') {
            $('#causa_raiz').append('<option value="Corte en pantografo sin escoriar">Corte en pantógrafo sin escoriar</option>');
            $('#causa_raiz').append('<option value="Corte en pantógrafo con angularidad">Corte en pantógrafo con angularidad</option>');
            $('#causa_raiz').append('<option value="Corte en sierra sin fin sin las medidas del plano">Corte en sierra sin fin sin las medidas del plano</option>');
            $('#causa_raiz').append('<option value="Corte en pantógrafo sin las medidas del plano">Corte en pantógrafo sin las medidas del plano</option>');
            $('#causa_raiz').append('<option value="Corte en tronzadora sin las medidas del plano">Corte en tronzadora sin las medidas del plano</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');
          
        }else if (subproceso == 'Doblez'){
            $('#causa_raiz').append('<option value="Doblez en sentido contrario">Doblez en sentido contrario</option>');
            $('#causa_raiz').append('<option value="Doblez sin las medidas del plano">Doblez sin las medidas del plano</option>');
            $('#causa_raiz').append('<option value="Falta de doblez">Falta de doblez</option>');
            $('#causa_raiz').append('<option value="Mal proceso de doblez">Mal proceso de doblez</option>');
            $('#causa_raiz').append('<option value="Pieza con doblez no requerido">Pieza con doblez no requerido</option>');
            $('#causa_raiz').append('<option value="Doblez en lado diferente">Doblez en lado diferente</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');

        }else if (subproceso == 'Cilindrado'){
            $('#causa_raiz').append('<option value="Cilindrado sin las medidas del plano">Cilindrado sin las medidas del plano</option>');
            $('#causa_raiz').append('<option value="Cilindrado en sentido contrario">Cilindrado en sentido contrario</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');

        
        }else if (subproceso == 'Rolado'){
            $('#causa_raiz').append('<option value="Rolado sin las medidas del plano">Rolado sin las medidas del plano</option>');
            $('#causa_raiz').append('<option value="Rolado en sentido contrario">Rolado en sentido contrario</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');
        
        }else if (subproceso == 'Geka'){
            $('#causa_raiz').append('<option value="Perforación con diámetro erróneo">Perforación con diámetro erróneo</option>');
            $('#causa_raiz').append('<option value="Perforaciones desplazadas">Perforaciones desplazadas</option>');
            $('#causa_raiz').append('<option value="Pieza con perforación de más">Pieza con perforación de más</option>');
            $('#causa_raiz').append('<option value="Pieza con perforación de menos">Pieza con perforación de menos</option>');
            $('#causa_raiz').append('<option value="Pieza con perforaciones no requeridas">Pieza con perforaciones no requeridas</option>');
            $('#causa_raiz').append('<option value="Pieza con perforación al lado contrario">Pieza con perforación al lado contrario</option>');
            $('#causa_raiz').append('<option value="Pieza con gramil al lado contrario">Pieza con gramil al lado contrario</option>');
            $('#causa_raiz').append('<option value="Pieza sin perforaciones">Pieza sin perforaciones</option>');
            $('#causa_raiz').append('<option value="Pieza con tipo de perforación diferente">Pieza con tipo de perforación diferente</option>');
            $('#causa_raiz').append('<option value="Pieza con perforación deformada">Pieza con perforación deformada</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');
           
        }else if (subproceso == 'Trumatic'){
            $('#causa_raiz').append('<option value="Perforación con diámetro erróneo">Perforación con diámetro erróneo</option>');
            $('#causa_raiz').append('<option value="Perforaciones desplazadas">Perforaciones desplazadas</option>');
            $('#causa_raiz').append('<option value="Pieza con perforación de más">Pieza con perforación de más</option>');
            $('#causa_raiz').append('<option value="Pieza con perforación de menos">Pieza con perforación de menos</option>');
            $('#causa_raiz').append('<option value="Pieza con perforaciones no requeridas">Pieza con perforaciones no requeridas</option>');
            $('#causa_raiz').append('<option value="Pieza con gramil al lado contrario">Pieza con gramil al lado contrario</option>');
            $('#causa_raiz').append('<option value="Pieza con gramil al lado contrario">Pieza con gramil al lado contrario</option>');
            $('#causa_raiz').append('<option value="Pieza sin perforaciones">Pieza sin perforaciones</option>');
            $('#causa_raiz').append('<option value="Pieza con tipo de perforación diferente">Pieza con tipo de perforación diferente</option>');
            $('#causa_raiz').append('<option value="Pieza con perforación deformada">Pieza con perforación deformada</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');      
    
        
        }
        else if (subproceso == 'Colillado'){
            $('#causa_raiz').append('<option value="Colillado de más">Colillado de más</option>');
            $('#causa_raiz').append('<option value="Pieza mal colillada">Pieza mal colillada</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');
    

        } else if (subproceso == 'Sierra Taladro'){
            $('#causa_raiz').append('<option value="Marcación erronea">Marcación erronea</option>');
            $('#causa_raiz').append('<option value="Mal acabado de cortes">Mal acabado de cortes</option>');
            $('#causa_raiz').append('<option value="Elemento erroneo">Elemento erroneo</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');

        } else if (subproceso == 'Granallado'){
            $('#causa_raiz').append('<option value="Perfil de rugosidad mayor a 2,5mils">Perfil de rugosidad mayor a 2,5mils</option>');
            $('#causa_raiz').append('<option value="Perfil de rugosidad menor a 1 mil">Perfil de rugosidad menor a 1 mil</option>');
            $('#causa_raiz').append('<option value="Avería de máquina por uso inadecuado">Avería de máquina por uso inadecuado</option>');
        
        }else if (subproceso == 'Soldadura'){
            $('#causa_raiz').append('<option value="Apariencia de la soldadura">Apariencia de la soldadura</option>');
            $('#causa_raiz').append('<option value="Distorsión de la soldadudura">Distorsión de la soldadudura</option>');
            $('#causa_raiz').append('<option value="Poros en soldadura">Poros en soldadura</option>');
            $('#causa_raiz').append('<option value="Soldadura no especificada en planta">Soldadura no especificada en planta</option>');
            $('#causa_raiz').append('<option value="Falta de material de aporte">Falta de material de aporte</option>');
            $('#causa_raiz').append('<option value="Falta de penetración">Falta de penetración</option>');
            $('#causa_raiz').append('<option value="Fundente atrapado">Fundente atrapado</option>');
            $('#causa_raiz').append('<option value="Destrozamiento de material">Destrozamiento de material</option>');
            $('#causa_raiz').append('<option value="Falta de fusión">Falta de fusión</option>');
            $('#causa_raiz').append('<option value="Socavado">Socavado</option>');
            $('#causa_raiz').append('<option value="Grietas">Grietas</option>');

        }else if (subproceso == 'Juntas de soldadura'){
            $('#causa_raiz').empty();
            $('#causa_raiz').append('<option value="Error en el angulo de los biseles>Error en el angulo de los biseles</option>');
            $('#causa_raiz').append('<option value="Junta mal nivelada">Junta mal nivelada</option>');
            $('#causa_raiz').append('<option value="Error en la preparación de la junta">Error en la preparación de la junta</option>');
 
        }else if (subproceso == 'Armado'){
            $('#causa_raiz').append('<option value="Ensamble erróneo de la pieza">Ensamble erróneo de la pieza</option>');
            $('#causa_raiz').append('<option value="Falta de posición en conjunto">Falta de posición en conjunto</option>');
     
        }else if (subproceso == 'Pintura'){
            $('#causa_raiz').append('<option value="Zona sin pintura">Zona sin pintura</option>');
            $('#causa_raiz').append('<option value="Espesores por debajo de especificación  (<20%)">Espesores por debajo de especificación  (<20%)</option>');
            $('#causa_raiz').append('<option value="Espesores por encima de especificación (>20%)">Espesores por encima de especificación (>20%)</option>');
            $('#causa_raiz').append('<option value="Limpieza inadecuada de superficie">Limpieza inadecuada de superficie</option>');
            $('#causa_raiz').append('<option value="Defectologia en capa seca ">Defectologia en capa seca </option>');
            $('#causa_raiz').append('<option value="Masilla mal aplicada ">Masilla mal aplicada </option>');
            $('#causa_raiz').append('<option value="Mala preparación de pintura">  Mala preparación de pintura</option>');
            $('#causa_raiz').append('<option value="Mala marcación">  Mala marcación</option>');
          
        }else if (subproceso == 'Transporte'){
            $('#causa_raiz').append('<option value="Daño de material, Despacho, Descargue y almacenamiento">Daño de material, Despacho, Descargue y almacenamiento</option>');
          $('#causa_raiz').append('<option value="Flete adicional">Flete adicional</option>');
          $('#causa_raiz').append('<option value="Material diferente al solicitado por el cliente">Material diferente al solicitado por el cliente</option>');
          $('#causa_raiz').append('<option value="Error de inventario">Error de inventario</option>');
          $('#causa_raiz').append('<option value="Descargue errado ">Descargue errado </option>');
          $('#causa_raiz').append('<option value="Error en cantidades despachada">Error en cantidades despachada</option>');
  
        }else if (subproceso == 'Descargue'){
            $('#causa_raiz').append('<option value="Daño de material, Despacho, Descargue y almacenamiento">Daño de material, Despacho, Descargue y almacenamiento</option>');
          $('#causa_raiz').append('<option value="Flete adicional">Flete adicional</option>');
          $('#causa_raiz').append('<option value="Material diferente al solicitado por el cliente">Material diferente al solicitado por el cliente</option>');
          $('#causa_raiz').append('<option value="Error de inventario">Error de inventario</option>');
          $('#causa_raiz').append('<option value="Descargue errado ">Descargue errado </option>');
          $('#causa_raiz').append('<option value="Error en cantidades despachada">Error en cantidades despachada</option>');
  
        }else if (subproceso == 'Proveedor'){
            $('#causa_raiz').append('<option value="Incumplimiento con las especificaciones del proyecto">Incumplimiento con las especificaciones del proyecto</option>');
        }else if (subproceso == 'Material'){
            $('#causa_raiz').append('<option value="Espesor de material erróneo">Espesor de material erróneo</option>');
          $('#causa_raiz').append('<option value="Diametro de material erróneo">Diametro de material erróneo</option>');
          $('#causa_raiz').append('<option value="Mala distribución del material">Mala distribución del material</option>');
          $('#causa_raiz').append('<option value="Error en las medidas del material">Error en las medidas del material</option>');
          $('#causa_raiz').append('<option value="Material entorchado">Material entorchado</option>');
          $('#causa_raiz').append('<option value="Material sin planitud">Material sin planitud</option>');
          $('#causa_raiz').append('<option value="Tipo de material erróneo">Tipo de material erróneo</option>');
          $('#causa_raiz').append('<option value="Material oxidado">Material oxidado</option>');
          $('#causa_raiz').append('<option value="Material con rebaba">Material con rebaba</option>');
          $('#causa_raiz').append('<option value="Materia prima con grietas">Materia prima con grietas</option>');
          $('#causa_raiz').append('<option value="Materia prima con delaminación">Materia prima con delaminación</option>');
        
        }else if (subproceso == 'Puente Grua'){
            $('#causa_raiz').append('<option value="Daño de material, Descargue y almacenamiento">Daño de material, Descargue y almacenamiento</option>');
            $('#causa_raiz').append('<option value="Material diferente al solicitado ">Material diferente al solicitado</option>');

        }else if (subproceso == 'Comercial'){
            $('#causa_raiz').append('<option value="Fabricación de más">Fabricación de más</option>');
            $('#causa_raiz').append('<option value="Fabricación de menos">Fabricación de menos</option>');
            $('#causa_raiz').append('<option value="Pieza sin fabricar">Pieza sin fabricar</option>');
            $('#causa_raiz').append('<option value="No uso del material del cliente">No uso del material del cliente</option>');
            $('#causa_raiz').append('<option value="Fabricación en sede errónea">Fabricación en sede errónea</option>');
            $('#causa_raiz').append('<option value="Cancelación de la orden de producción">Cancelación de la orden de producción</option>');
            $('#causa_raiz').append('<option value="Mal cobro por material">Mal cobro por material</option>');
            $('#causa_raiz').append('<option value="Mal cobro del servicio">Mal cobro del servicio</option>');
            $('#causa_raiz').append('<option value="No entrega de servicio al cliente">No entrega de servicio al cliente</option>');
            $('#causa_raiz').append('<option value="No entrega de material al cliente">No entrega de material al cliente</option>');
            $('#causa_raiz').append('<option value="Perforación por fuera de la pieza">Perforación por fuera de la pieza</option>');
            $('#causa_raiz').append('<option value="Servicio sin reclamar">Servicio sin reclamar</option>');
            $('#causa_raiz').append('<option value="Medidas mal especificadas">Medidas mal especificadas</option>');
            $('#causa_raiz').append('<option value="Especificación fuera de tolerancias de máquinas">Especificación fuera de tolerancias de máquinas</option>');
            $('#causa_raiz').append('<option value="Especificaciones diferente de necesidad del cliente">Especificaciones diferente de necesidad del cliente</option>');

        }else if (subproceso == 'Dibujo'){
            $('#causa_raiz').append('<option value="Mala programación de dibujo en pantografo">Mala programación de dibujo en pantografo</option>');
            $('#causa_raiz').append('<option value="Error en las medidas de la pieza">Error en las medidas de la pieza</option>');
            $('#causa_raiz').append('<option value="Error en el desarrollo de la pieza">Error en el desarrollo de la pieza</option>');
         
        }else if (subproceso == 'Montaje'){
            $('#causa_raiz').append('<option value="Pieza no instalada en obra">Pieza no instalada en obra</option>');
            $('#causa_raiz').append('<option value="Mala nivelación ">Mala nivelación </option>');
            $('#causa_raiz').append('<option value="Material no despachado a tiempo">Material no despachado a tiempo</option>');
            $('#causa_raiz').append('<option value="Material despachado erroneo">Material despachado erroneo</option>');
            $('#causa_raiz').append('<option value="Pernos de anclaje mal instalado">Pernos de anclaje mal instalado</option>');
            $('#causa_raiz').append('<option value="Daño de material">Daño de material</option>');
            $('#causa_raiz').append('<option value="Izaje errado">Izaje errado</option>');
            $('#causa_raiz').append('<option value="Retraso de entrega ">Retraso de entrega </option>');
            $('#causa_raiz').append('<option value="Mala toma de medidas al inciar proyecto">Mala toma de medidas al inciar proyecto</option>');
            $('#causa_raiz').append('<option value="Faltante de Herramienta">Faltante de Herramienta</option>');
          
        }else if (subproceso == 'Almacenamiento'){
            $('#causa_raiz').append('<option value="Daño de material, Despacho, Descargue y almacenamiento">Daño de material, Despacho, Descargue y almacenamiento</option>');
            $('#causa_raiz').append('<option value="Flete adicional">Flete adicional</option>');
            $('#causa_raiz').append('<option value="Material diferente al solicitado por el cliente">Material diferente al solicitado por el cliente</option>');
            $('#causa_raiz').append('<option value="Error de inventario">Error de inventario</option>');
            $('#causa_raiz').append('<option value="Descargue errado ">Descargue errado </option>');
            $('#causa_raiz').append('<option value="Error en cantidades despachada">Error en cantidades despachada</option>');
            $('#causa_raiz').append('<option value="Deformación por almacenamiento erroneo">Deformación por almacenamiento erroneo</option>');
            $('#causa_raiz').append('<option value="Oxidación por almacenamiento sin protección">Oxidación por almacenamiento sin protección</option>');
          
        }else if (subproceso == 'Mantenimiento'){
            $('#causa_raiz').append('<option value="Estado no operativo de la máquina">Estado no operativo de la máquina</option>'); 

        }else if (subproceso == 'Compras'){
            $('#causa_raiz').append('<option value="Material con medidas erradas">Material con medidas erradas</option>');
            $('#causa_raiz').append('<option value="Material con presencia de oxidación (corrosión)">Material con presencia de oxidación (corrosión)</option>');
            $('#causa_raiz').append('<option value="Material con calidad diferente a la solicitada">Material con calidad diferente a la solicitada</option>');
            $('#causa_raiz').append('<option value="Falta certificado de calidad">Falta certificado de calidad</option>');
            $('#causa_raiz').append('<option value="Lugar de entrega no acorde a la solicitada">Lugar de entrega no acorde a la solicitada</option>');
            $('#causa_raiz').append('<option value="Error en la orden de compra">Error en la orden de compra</option>');
            $('#causa_raiz').append('<option value="Cantidades en las entregas no acordes al documento">Cantidades en las entregas no acordes al documento</option>');
        }
        else if (subproceso == 'Varios'){
            $('#causa_raiz').append('<option value="Chatarrización de pieza conforme">Chatarrización de pieza conforme</option>');
            $('#causa_raiz').append('<option value="Falta de proceso en mesa de corte tecoi">Falta de proceso en mesa de corte tecoi</option>');
            $('#causa_raiz').append('<option value="Pieza con destrozamiento de material">Pieza con destrozamiento de material</option>');
            $('#causa_raiz').append('<option value="Pieza con grietas">Pieza con grietas</option>');
            $('#causa_raiz').append('<option value="Pieza biselada en otro lugar">Pieza biselada en otro lugar</option>');
            $('#causa_raiz').append('<option value="Pieza sin escuadra">Pieza sin escuadra</option>');
            $('#causa_raiz').append('<option value="Pieza rayada">Pieza rayada</option>');
            $('#causa_raiz').append('<option value="Pieza sin platitud">Pieza sin platitud</option>');
            $('#causa_raiz').append('<option value="Pieza sin linealidad">Pieza sin linealidad</option>');
            $('#causa_raiz').append('<option value="Pieza con deformidad">Pieza con deformidad</option>');
            $('#causa_raiz').append('<option value="Pieza con marcas">Pieza con marcas</option>');
            $('#causa_raiz').append('<option value="Pieza con rebaba">Pieza con rebaba</option>');
            $('#causa_raiz').append('<option value="Sentido del alfajor erróneo">Sentido del alfajor erróneo</option>');
            $('#causa_raiz').append('<option value="No entrega de despiece a planta">No entrega de despiece a planta</option>');
            $('#causa_raiz').append('<option value="Pieza mal identificada">Pieza mal identificada</option>');
            $('#causa_raiz').append('<option value="Falla de calidad del proveedor">Falla de calidad del proveedor</option>');
            $('#causa_raiz').append('<option value="Pieza con sentido contrario">Pieza con sentido contrario</option>');
            $('#causa_raiz').append('<option value="Perdida de elemento">Perdida de elemento</option>');
            $('#causa_raiz').append('<option value="Otra">Otra</option>');
        }else if (subproceso == 'Programacion'){
            $('#causa_raiz').append('<option value="Error en programacion">Error en programacion</option>');
        }
        else if (subproceso == 'Ingenieria'){
            $('#causa_raiz').append('<option value="Error en las medidas de la pieza ">Error en las medidas de la pieza </option>');
            $('#causa_raiz').append('<option value="Mala distribución del material">Mala distribución del material</option>');
            $('#causa_raiz').append('<option value="Falta de material en la distribución ">Falta de material en la distribución </option>');
            $('#causa_raiz').append('<option value="Elementos que se cortan de más">Elementos que se cortan de más</option>');
            $('#causa_raiz').append('<option value="Falta pedido de material">Falta pedido de material</option>');
            $('#causa_raiz').append('<option value="Material de más">Material de más</option>');

      
        }
        else if (subproceso == 'Calidad'){
            $('#causa_raiz').append('<option value="Error en la liberacion">Error en la liberacion</option>');
            $('#causa_raiz').append('<option value="Falta acompañamiento">Falta acompañamiento</option>');
            $('#causa_raiz').append('<option value="Falta de reportes">Falta de reportes  </option>');

      
        } else if (subproceso == 'Almacen'){
            $('#causa_raiz').append('<option value="Almacen">Almacen</option>');
        }
    });
});

function calculateTotal(){
    var costo = document.getElementById("costo").value;
    var saldo_recuperado = document.getElementById("saldo_recuperado").value;
    var total = costo - saldo_recuperado;
    document.getElementById("total").value = total;
  }
  

    $(document).ready(function() {
        $('#ResponsableCNC').select2();
    });

    $(document).ready(function() {
        $('#Analistareporto').select2();
    });
  
  

