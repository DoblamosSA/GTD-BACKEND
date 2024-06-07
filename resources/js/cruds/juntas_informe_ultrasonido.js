//variables de controles del formulario

txtId = $('#id-junta');
txtFecha = $('#fecha');
txtIdentificacion_elemento = $('#identificacion_elemento');
txtJunta = $('#junta');
txtIdInforme = $('#id_informe');


btn_salvar_juntas = $('#btn_salvar_juntas');
btnEliminar = $('.eliminar');
tablaJuntas = $('#tabla_juntas');
modalJuntas = $('#modal-juntas');

//variables de configuracion
// var nombreControlador = "juntas-informe-ultrasonido";
// var appDir = window.location.pathname.split('/')[1];

var currentUrl = window.location.pathname.replace("informe-ultrasonido", "juntas-informe-ultrasonido");

var datosUrl = window.location.pathname.split("/");
elementoId = datosUrl[datosUrl.length - 1];
currentUrl = currentUrl.replace("/edit/" + elementoId, "");
console.log(currentUrl);


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//Load Data in Table when documents is ready
$(document).ready(function () {
    getByInformeId();
});

btn_salvar_juntas.click(function () {
    save();
});

btnEliminar.on('click', function () {
    $(this).closest('tr').remove();
});
var test;
function getByInformeId() {
    var IdInforme = txtIdInforme.val();

    $.ajax({
        url: currentUrl + "/api_getByInformeId/" + IdInforme,
        type: "GET",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (result) {
            console.log(result);
            addRowsTable(result);
            test=result;
        },
        error: function (errormessage) {
            console.log(errormessage.responseText);
        }
    });
}

function getbyID(ID) {
    $.ajax({
        //url: "/" + appDir + "/public/" + nombreControlador + "/api_getById/" + ID,
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
            getByInformeId();
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
        //url: "/" + appDir + "/public/" + nombreControlador + "/api_update",
        url: currentUrl + "/api_update",
        data: JSON.stringify(dataObj),
        type: "POST",
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function (result) {
            getByInformeId();
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
                getByInformeId();
            },
            error: function (errormessage) {
                console.log(errormessage.responseText);
            }
        });
    }
}

function clearForm() {
    txtId.val("");
    txtFecha.val("");
    txtIdentificacion_elemento.val("");
    txtJunta.val("");
}

function getFormData() {
    var dataObj = {
        id: txtId.val(),
        fecha: txtFecha.val(),
        identificacion_elemento: txtIdentificacion_elemento.val(),
        junta: txtJunta.val(),
        inf_ultrasonido_id: txtIdInforme.val(),
    };
    return dataObj;
}

function loadFormData(data) {
    txtId.val(data.id);
    txtFecha.val(data.fecha);
    txtIdentificacion_elemento.val(data.identificacion_elemento);
    txtJunta.val(data.junta);
    txtIdInforme.val(data.inf_ultrasonido_id);
}

function addRowsTable(data) {
    var datosFilas = "";
    var fila = "";
    tablaJuntas.find("tbody").find("tr").remove();

    data=cambiarValoresNulos(data);

    for (let i = 0; i < data.length; i++) { 
        datosFilas += "<td>" + data[i].id + "</td>";
        datosFilas += "<td>" + data[i].fecha + "</td>";
        datosFilas += "<td>" + data[i].identificacion_elemento + "</td>";
        datosFilas += "<td>" + data[i].junta  + "</td>";  
        datosFilas += "<td>" + " <a onclick='mostrarModalDatosJuntas("+data[i].id+")' class='btn btn-sm btn-success' data-toggle='modal' data-target='#modal-datos-juntas'>Detalle Juntas</a>" + "</td>";         
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
    txtId.val(id);
    getbyID(id);
}

function save() {
    var id = txtId.val();

    if (id >= 1) {
        update();
    } else {
        add();
    }
}