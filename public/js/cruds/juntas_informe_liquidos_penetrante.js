//variables de controles del formulario
txtIdJuntas = $('#id_juntas');
txtIdLiquidosPenetrantes = $('#inf_liq_penetran_id');
txtElemento = $('#elemento');
txtJunta = $('#junta');
txtCalificacion = $('#calificacion');
txtIndicacion = $('#indicacion');
txtObservaciones = $('#observaciones');

btnSalvar = $('#btn_salvar_juntas_inf_magne');
btnEliminar = $('.eliminar');
tablaJuntas = $('#tabla_juntas');
modalJuntas = $('#modal-juntas');

//variables de configuracion
// var nombreControlador = "juntas-informe-liquidos-penetrantes";
// var appDir = window.location.pathname.split('/')[1];

var currentUrl = window.location.pathname.replace("informe-liquidos-penetrante", "juntas-informe-liquidos-penetrantes");

var datosUrl=window.location.pathname.split("/");
elementoId=datosUrl[datosUrl.length-1];
currentUrl = currentUrl.replace("/edit/"+elementoId, "");
console.log(currentUrl);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//Load Data in Table when documents is ready
$(document).ready(function () {
    getByInfLiquidosPenetranteId();
});

btnSalvar.click(function () {
    save();
});

btnEliminar.on('click', function () {
    $(this).closest('tr').remove();
});

function getByInfLiquidosPenetranteId() {
    var id = txtIdLiquidosPenetrantes.val();

    $.ajax({
        //  url: "/" + appDir + "/public/" + nombreControlador + "/api_getByInfLiquidosPenetrantes/" + id,
        url: currentUrl + "/api_getByInfLiquidosPenetrantes/" + id,
        type: "GET",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            console.log(result);
            addRowsTable(result);
        },
        error: function (errormessage) {
            console.log(errormessage.responseText);
        }
    });
}

function getbyID(ID) {
    $.ajax({
        // url: "/" + appDir + "/public/" + nombreControlador + "/api_getById/" + ID,
        url: currentUrl + "/api_getById/" + ID,
        typr: "GET",
        contentType: "application/json;charset=UTF-8",
        dataType: "json",
        success: function (result) {
            loadFormData(result);
        },
        error: function (errormessage) {
            console.log(errormessage.responseText);
        }
    });
    return false;
}

function add() {
    var dataObj = getFormData();
    $.ajax({
        // url: "/" + appDir + "/public/" + nombreControlador + "/api_add",
        url: currentUrl + "/api_add",
        data: JSON.stringify(dataObj),
        type: "POST",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function (result) {
            getByInfLiquidosPenetranteId();
            clearForm();
            modalJuntas.modal("toggle");
        },
        error: function (errormessage) {
            console.log(errormessage.responseText);
        }
    });
}

function update() {
    var dataObj = getFormData();
    $.ajax({
        // url: "/" + appDir + "/public/" + nombreControlador + "/api_update",
        url: currentUrl + "/api_update",
        data: JSON.stringify(dataObj),
        type: "POST",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function (result) {
            getByInfLiquidosPenetranteId();
            clearForm();
            modalJuntas.modal("toggle");
        },
        error: function (errormessage) {
            console.log(errormessage.responseText);
        }
    });
}

function delele(id) {
    if (id === "0") {
        alert("Debe seleccionar un registro");
        return false;
    }
    var ans = confirm("Estas seguro en borrar el registro?");
    if (ans) {
        $.ajax({
            // url: "/" + appDir + "/public/" + nombreControlador + "/api_delete/" + id,
            url: currentUrl + "/api_delete/" + id,
            type: "POST",
            contentType: "application/json;charset=UTF-8",
            dataType: "json",
            success: function (result) {
                getByInfLiquidosPenetranteId();
            },
            error: function (errormessage) {
                console.log(errormessage.responseText);
            }
        });
    }
}

function clearForm() {
    txtIdJuntas.val("");
    txtElemento.val("");
    txtJunta.val("");
    txtCalificacion.val("");
    txtIndicacion.val("");
    txtObservaciones.val("");
}

function getFormData() {
    var dataObj = {
        id: txtIdJuntas.val(),
        inf_liq_penetran_id: txtIdLiquidosPenetrantes.val(),
        elemento: txtElemento.val(),
        junta: txtJunta.val(),
        calificacion: txtCalificacion.val(),
        indicacion: txtIndicacion.val(),
        observaciones: txtObservaciones.val(),
    };
    return dataObj;
}

function loadFormData(data) {
    txtIdJuntas.val(data.id)
    txtIdLiquidosPenetrantes.val(data.inf_liq_penetran_id);
    txtElemento.val(data.elemento);
    txtJunta.val(data.junta);
    txtCalificacion.val(data.calificacion);
    txtIndicacion.val(data.indicacion);
    txtObservaciones.val(data.observaciones);
}

function addRowsTable(data) {
    var datosFilas = "";
    var fila = "";
    tablaJuntas.find("tbody").find("tr").remove();

    data=cambiarValoresNulos(data);
    
    for (let i = 0; i < data.length; i++) {
        datosFilas += "<td>" + data[i].id + "</td>";
        datosFilas += "<td>" + data[i].elemento + "</td>";
        datosFilas += "<td>" + data[i].junta + "</td>";
        datosFilas += "<td>" + data[i].indicacion + "</td>";
        datosFilas += "<td>" + data[i].calificacion + "</td>";
        datosFilas += "<td>" + data[i].observaciones + "</td>";
        datosFilas += "<td>  <a onclick='mostrarModalImagenes("+data[i].id+")' class='btn btn-sm btn-success' data-toggle='modal' data-target='#juntas-imagenes'>Ver imanges</a></td>";
        datosFilas += "<td> <a class='btn btn-sm btn-success'  onclick='edit(" + data[i].id + ")'><i class='fa fa-fw fa-edit'></i> </a>" +
            "<button type='submit'  onclick='delele(" + data[i].id + ")' class='btn btn-danger btn-sm eliminar'><i class='fa fa-fw fa-trash'></i></button>" +
            "</td>";
        fila = "<tr>" + datosFilas + "</tr>";
        datosFilas = "";
        tablaJuntas.find("tbody").append(fila);
    }

}

function edit(id) {
    modalJuntas.modal('toggle');
    txtIdJuntas.val(id);
    getbyID(id);
}

function save() {
    var id = txtIdJuntas.val();

    if (id >= 1) {
        update();
    } else {
        add();
    }
}

