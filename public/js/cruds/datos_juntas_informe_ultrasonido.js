//variables de controles del formulario
txtIdDetalleJunta = $('#id-dato-junta');
txtUbicacion_junta = $('#ubicacion_junta');
txtIndicacion_numero = $('#indicacion_numero');
txtDesde_cara = $('#desde_cara');
txtPierna = $('#pierna');
txtNivel_indicacion = $('#nivel_indicacion');
txtNivel_referencia = $('#nivel_referencia');
txtFactor_atenuacion = $('#factor_atenuacion');
txtValoracion_indicacion = $('#valoracion_indicacion');
txtLongitud_defecto = $('#longitud_defecto');
txtDistancia_angular = $('#distancia_angular');
txtProfundidad_desde = $('#profundidad_desde');
txtEvaluacion_discontinuidad_1 = $('#evaluacion_discontinuidad_1');
txtEvaluacion_discontinuidad_2 = $('#evaluacion_discontinuidad_2');
txtEvaluacion_discontinuidad_3 = $('#evaluacion_discontinuidad_3');
txtDistancia_desde_x = $('#distancia_desde_x');
txtDistancia_desde_y = $('#distancia_desde_y');
txtEstampe_soldador = $('#estampe_soldador');
txtObservaciones = $('#observaciones');
txtIdJunta= $('#id-junta');

btnSalvar = $('#btn_salvar_DetalleJunta');
btnAddEditDatosJuntas= $('#btnAddEditDatosJuntas');
btnEliminar = $('.eliminar_DetalleJunta');
btnCancelarJuntaDetalle=$('#btn-cancelar-dato-junta');
tablaDatosJuntas = $('#tabla-datos-juntas');
divFormularioDatosJuntas= $('#datos-junta-formulario');
modalDatosJuntas = $('#modal-datos-juntas');

//variables de configuracion
// var nombreControlador = "juntas-informe-ultrasonido";
// var appDir = window.location.pathname.split('/')[1];

var currentUrlDetalleJuntasDetalleJuntas = window.location.pathname.replace("informe-ultrasonido", "datos-juntas-informe-ultrasonido");

var datosUrl = window.location.pathname.split("/");
elementoId = datosUrl[datosUrl.length - 1];
currentUrlDetalleJuntasDetalleJuntas = currentUrlDetalleJuntasDetalleJuntas.replace("/edit/" + elementoId, "");
console.log(currentUrlDetalleJuntasDetalleJuntas);


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function getByIdJuntaDetalleJunta(id) {
    var IdJunta = txtIdJunta.val();

    $.ajax({
        url: currentUrlDetalleJuntasDetalleJuntas + "/api_getByJuntaId/" + IdJunta,
        type: "GET",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            console.log(result);
            addRowsTableDetalleJuntas(result);
        },
        error: function (errormessage) {
            console.log(errormessage.responseText);
        }
    });
}

function getbyIdDetalleJuntas(id) {
    $.ajax({
        url: currentUrlDetalleJuntasDetalleJuntas + "/api_getById/" + id,
        typr: "GET",
        contentType: "application/json;charset=UTF-8",
        dataType: "json",
        success: function (result) {
            loadFormDataDetalleJuntas(result);
            mostrarFormularioDetalleJuntas();
        },
        error: function (errormessage) {
            console.log(errormessage.responseText);
        }
    });
    return false;
}

function addDetalleJuntas() {
    var dataObj = getFormDataDetalleJuntas();
    $.ajax({
        url: currentUrlDetalleJuntasDetalleJuntas + "/api_add",
        data: JSON.stringify(dataObj),
        type: "POST",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function (result) {
            getByIdJuntaDetalleJunta();
            clearFormDetalleJuntas();
            mostrarListadoDatosDetalleJuntas();
        },
        error: function (errormessage) {
            console.log(errormessage.responseText);
        }
    });
}

function updateDetalleJuntas(){
    var dataObj = getFormDataDetalleJuntas();
    $.ajax({
        url: currentUrlDetalleJuntasDetalleJuntas + "/api_update",
        data: JSON.stringify(dataObj),
        type: "POST",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function (result) {
            getByIdJuntaDetalleJunta();
            clearFormDetalleJuntas();
            mostrarListadoDatosDetalleJuntas();
        },
        error: function (errormessage) {
            console.log(errormessage.responseText);
        }
    });
}

function deleleDetalleJuntas(id) {
    if (id === "0") {
        alert("Debe seleccionar un registro");
        return false;
    }
    var ans = confirm("Estas seguro en borrar el registro?");
    if (ans) {
        $.ajax({
            url: currentUrlDetalleJuntasDetalleJuntas + "/api_delete/" + id,
            type: "POST",
            contentType: "application/json;charset=UTF-8",
            dataType: "json",
            success: function (result) {
                getByIdJuntaDetalleJunta();
            },
            error: function (errormessage) {
                console.log(errormessage.responseText);
            }
        });
    }
}

function clearFormDetalleJuntas() {
    txtIdDetalleJunta.val("");
    txtUbicacion_junta.val("");
    txtIndicacion_numero.val("");
    txtDesde_cara.val("");
    txtPierna.val("");
    txtNivel_indicacion.val("");
    txtNivel_referencia.val("");
    txtFactor_atenuacion.val("");
    txtValoracion_indicacion.val("");
    txtLongitud_defecto.val("");
    txtDistancia_angular.val("");
    txtProfundidad_desde.val("");
    txtEvaluacion_discontinuidad_1.val("");
    txtEvaluacion_discontinuidad_2.val("");;
    txtEvaluacion_discontinuidad_3.val("");
    txtDistancia_desde_x.val("");
    txtDistancia_desde_y.val("");
    txtEstampe_soldador.val("");
    txtObservaciones.val("");
    txtIdJunta.val("");
}

function getFormDataDetalleJuntas() {
    var dataObj = {
        id: txtIdDetalleJunta.val(),
        ubicacion_junta: txtUbicacion_junta.val(),
        indicacion_numero: txtIndicacion_numero.val(),
        desde_cara: txtDesde_cara.val(),
        pierna: txtPierna.val(),
        nivel_indicacion: txtNivel_indicacion.val(),
        nivel_referencia: txtNivel_referencia.val(),
        factor_atenuacion: txtFactor_atenuacion.val(),
        valoracion_indicacion: txtValoracion_indicacion.val(),
        longitud_defecto: txtLongitud_defecto.val(),
        distancia_angular: txtDistancia_angular.val(),
        profundidad_desde: txtProfundidad_desde.val(),
        evaluacion_discontinuidad_1: txtEvaluacion_discontinuidad_1.val(),
        evaluacion_discontinuidad_2: txtEvaluacion_discontinuidad_2.val(),
        evaluacion_discontinuidad_3: txtEvaluacion_discontinuidad_3.val(),
        distancia_desde_x: txtDistancia_desde_x.val(),
        distancia_desde_y: txtDistancia_desde_y.val(),
        estampe_soldador: txtEstampe_soldador.val(),
        observaciones: txtObservaciones.val(),
        jun_inf_ult_id: txtIdJunta.val(),
    };
    return dataObj;
}

function loadFormDataDetalleJuntas(data) {
    txtIdDetalleJunta.val(data.id);
    txtUbicacion_junta.val(data.ubicacion_junta==null?"":data.ubicacion_junta);
    txtIndicacion_numero.val(data.indicacion_numero);
    txtDesde_cara.val(data.desde_cara);
    txtPierna.val(data.pierna);
    txtNivel_indicacion.val(data.nivel_indicacion);
    txtNivel_referencia.val(data.nivel_referencia);
    txtFactor_atenuacion.val(data.factor_atenuacion);
    txtValoracion_indicacion.val(data.valoracion_indicacion);
    txtLongitud_defecto.val(data.longitud_defecto);
    txtDistancia_angular.val(data.distancia_angular);
    txtProfundidad_desde.val(data.profundidad_desde);
    txtEvaluacion_discontinuidad_1.val(data.evaluacion_discontinuidad_1);
    txtEvaluacion_discontinuidad_2.val(data.evaluacion_discontinuidad_2);;
    txtEvaluacion_discontinuidad_3.val(data.evaluacion_discontinuidad_3);
    txtDistancia_desde_x.val(data.distancia_desde_x);
    txtDistancia_desde_y.val(data.distancia_desde_y);
    txtEstampe_soldador.val(data.estampe_soldador);
    txtObservaciones.val(data.observaciones);
    txtIdJunta.val(data.jun_inf_ult_id);
}

function addRowsTableDetalleJuntas(data) {
    var datosFilas = "";
    var fila = "";
    tablaDatosJuntas.find("tbody").find("tr").remove();
    
    data=cambiarValoresNulos(data);

    for (let i = 0; i < data.length; i++) {
        datosFilas += "<td>" + data[i].id + "</td>";
        datosFilas += "<td>" + data[i].ubicacion_junta + "</td>";
        datosFilas += "<td>" + data[i].indicacion_numero + "</td>";
        datosFilas += "<td>" + data[i].desde_cara + "</td>";
        datosFilas += "<td>" + data[i].pierna + "</td>";
        datosFilas += "<td>" + data[i].nivel_indicacion + "</td>";
        datosFilas += "<td>" + data[i].nivel_referencia + "</td>";
        datosFilas += "<td>" + data[i].factor_atenuacion + "</td>";
        datosFilas += "<td>" + data[i].valoracion_indicacion + "</td>";
        datosFilas += "<td>" + data[i].longitud_defecto + "</td>";
        datosFilas += "<td>" + data[i].distancia_angular + "</td>";
        datosFilas += "<td>" + data[i].profundidad_desde + "</td>";
        datosFilas += "<td>" + data[i].evaluacion_discontinuidad_1 + "</td>";
        datosFilas += "<td>" + data[i].evaluacion_discontinuidad_2 + "</td>";
        datosFilas += "<td>" + data[i].evaluacion_discontinuidad_3 + "</td>";
        datosFilas += "<td>" + data[i].distancia_desde_x + "</td>";
        datosFilas += "<td>" + data[i].distancia_desde_y + "</td>";
        datosFilas += "<td>" + data[i].estampe_soldador + "</td>";
        datosFilas += "<td>" + data[i].observaciones + "</td>";
        datosFilas += "<td> <button class='btn btn-sm btn-success btn-editar-dato-junta'   onclick='editDetalleJuntas(" + data[i].id + ")'  value='" + data[i].id + "'><i class='fa fa-fw fa-edit'></i> </button>" +
            "<button type='submit'  value='" + data[i].id + "'  onclick='deleleDetalleJuntas(" + data[i].id + ")' class='btn btn-danger btn-sm eliminar btn-eliminar-dato-junta'><i class='fa fa-fw fa-trash'></i></button>" +
            "</td>";
        fila = "<tr>" + datosFilas + "</tr>";
        datosFilas = "";
        tablaDatosJuntas.find("tbody").append(fila);
    }

}

function editDetalleJuntas(id) {
    
    txtIdDetalleJunta.val(id);
    getbyIdDetalleJuntas(id);
}

function saveDetalleJuntas() {
    var id = txtIdDetalleJunta.val();

    if (id >= 1) {
        updateDetalleJuntas();
    } else {
        addDetalleJuntas();
    }
}

function mostrarFormularioDetalleJuntas() {
    tablaDatosJuntas.css({"display": "none"});
    divFormularioDatosJuntas.css({"display": "block"});
    btnAddEditDatosJuntas.css({"display": "none"});    
}

function mostrarListadoDatosDetalleJuntas() {
    tablaDatosJuntas.css({"display": "block"});
    divFormularioDatosJuntas.css({"display": "none"});
    btnAddEditDatosJuntas.css({"display": "block"});
    getByIdJuntaDetalleJunta();
}

function mostrarModalDatosJuntas(id)
{
    txtIdJunta.val(id);
    mostrarListadoDatosDetalleJuntas();
}

