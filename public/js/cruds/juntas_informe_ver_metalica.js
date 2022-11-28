//variables de controles del formulario
txtIdInforme =$('#id_informe');
txtId=$('#id');
txtId_columna=$('#id_columna');
txtTeorica=$('#teorica');
txtReal=$('#real'); 
txtDesviacion=$('#desviacion');
txtAltura_Columna=$('#altura_Columna');
txtTolerancia=$('#tolerancia');
txtNorte_1=$('#norte_1');
txtNorte_2=$('#norte_2');
txtSur_1=$('#sur_1');
txtSur_2=$('#sur_2');
txtOriente_1=$('#oriente_1');
txtOriente_2=$('#oriente_2');
txtOccidente_1=$('#occidente_1');
txtOccidente_2=$('#occidente_2');
txtResultado_inspeccion=$('#resultado_inspeccion');

btnSalvar = $('#btn_salvar_juntas');
btnEliminar=  $('.eliminar');
tablaJuntas = $('#tabla_juntas');
modalJuntas=$('#modal-juntas');

//variables de configuracion
// var nombreControlador = "juntas-informe-vert-metalica";
// var appDir = window.location.pathname.split('/')[1];

var currentUrl = window.location.pathname.replace("informe-vert-metalica", "juntas-informe-vert-metalica");

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

btnSalvar.click(function () {
    save();
});

btnEliminar.on('click', function() {
    $(this).closest('tr').remove();
});

function getByInformeId() {
    var IdInforme = txtIdInforme.val();

    $.ajax({
        //url: "/" + appDir + "/public/" + nombreControlador + "/api_getByInfVertMetalica/" + IdInforme,
        url: currentUrl + "/api_getByInfVertMetalica/" + IdInforme,
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
        //url: "/" + appDir + "/public/" + nombreControlador + "/api_add",
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
            //url: "/" + appDir + "/public/" + nombreControlador + "/api_delete/" + id,
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
    txtId_columna.val("");
    txtTeorica.val("");
    txtReal.val("");
    txtDesviacion.val("");
    txtAltura_Columna.val("");
    txtTolerancia.val("");
    txtNorte_1.val("");
    txtNorte_2.val("");;
    txtSur_1.val("");
    txtSur_2.val("");
    txtOriente_1.val("");
    txtOriente_2.val("");
    txtOccidente_1.val("");
    txtOccidente_2.val("");
    txtResultado_inspeccion.val("");
}

function getFormData() {
    var dataObj = {
        id:txtId.val(),
        id_columna:txtId_columna.val(),
        teorica:txtTeorica.val(),
        real: txtReal.val(),
        desviacion:txtDesviacion.val(),
        altura_Columna:txtAltura_Columna.val(),
        tolerancia:txtTolerancia.val(),
        norte_1:txtNorte_1.val(),
        norte_2:txtNorte_2.val(),
        sur_1:txtSur_1.val(),
        sur_2:txtSur_2.val(),
        oriente_1:txtOriente_1.val(),
        oriente_2:txtOriente_2.val(),
        occidente_1:txtOccidente_1.val(),
        occidente_2:txtOccidente_2.val(),
        resultado_inspeccion:txtResultado_inspeccion.val(),
        inf_vert_met_id:txtIdInforme.val(),
    };
    return dataObj;
}

function loadFormData(data) {
    txtId.val(data.id);
    txtIdInforme.val(data.inf_vert_met_id);
    txtId_columna.val(data.id_columna);
    txtTeorica.val(data.teorica);
    txtReal.val(data.real);
    txtDesviacion.val(data.desviacion);
    txtAltura_Columna.val(data.altura_Columna);
    txtTolerancia.val(data.tolerancia);
    txtNorte_1.val(data.norte_1);
    txtNorte_2.val(data.norte_2);
    txtSur_1.val(data.sur_1);
    txtSur_2.val(data.sur_2);
    txtOriente_1.val(data.oriente_1);
    txtOriente_2.val(data.oriente_2);
    txtOccidente_1.val(data.occidente_1);
    txtOccidente_2.val(data.occidente_2);
    txtResultado_inspeccion.val(data.resultado_inspeccion);
}

function addRowsTable(data) {
    var datosFilas = "";
    var fila = "";
    tablaJuntas.find("tbody").find("tr").remove();

    data=cambiarValoresNulos(data);
    
    for (let i = 0; i < data.length; i++) {
        datosFilas += "<td>" + data[i].id + "</td>";
        datosFilas += "<td>" + data[i].id_columna + "</td>";
        datosFilas += "<td>" + data[i].teorica + "</td>";
        datosFilas += "<td>" + data[i].real + "</td>";
        datosFilas += "<td>" + data[i].desviacion + "</td>";
        datosFilas += "<td>" + data[i].altura_Columna + "</td>";
        datosFilas += "<td>" + data[i].tolerancia + "</td>";
        datosFilas += "<td>" + data[i].norte_1 + "</td>";
        datosFilas += "<td>" + data[i].norte_2 + "</td>";
        datosFilas += "<td>" + data[i].sur_1 + "</td>";
        datosFilas += "<td>" + data[i].sur_2 + "</td>";
        datosFilas += "<td>" + data[i].oriente_1 + "</td>";
        datosFilas += "<td>" + data[i].oriente_2 + "</td>";
        datosFilas += "<td>" + data[i].occidente_1 + "</td>";
        datosFilas += "<td>" + data[i].occidente_2 + "</td>";
        datosFilas += "<td>" + data[i].resultado_inspeccion + "</td>";
        datosFilas += "<td> <a class='btn btn-sm btn-success'  onclick='edit("+data[i].id+")'><i class='fa fa-fw fa-edit'></i> </a>"   +
        "<button type='submit'  onclick='delele("+data[i].id+")' class='btn btn-danger btn-sm eliminar'><i class='fa fa-fw fa-trash'></i></button>"+
        "</td>";
        fila = "<tr>" + datosFilas + "</tr>";
        datosFilas = "";
        tablaJuntas.find("tbody").append(fila);
    }

}

function edit(id)
{
    modalJuntas.modal('toggle');
    txtId.val(id);
    getbyID(id);
}

function save()
{
    var id=txtId.val();

    if(id>=1)
    {
        update();
    }else{
        add();
    }
}