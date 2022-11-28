export const utilidades = {

    isEmpty(value) {
        return value == null || value.trim().length === 0;
    },

    limpiarDatos(datos) {
        for (var key in datos) {
            datos[key] = null;
        }
    },

    validarEmail(email) {
        const re = aaa;
        var resultado = re.test(String(email).toLowerCase());
        return resultado;
    },

    obtenerItemActual(id, options) {
        var id_seleccionado = null;
        var item = { value: "", text: "" };

        var indice = options.findIndex(function(objecto) {
            if (objecto.value == id) return true;
        });

        if (indice > -1) {
            item = options[indice];
        }

        return item;
    },

    convertirArrayCombo(data, keyIndice, keyTexto) {
        var resultadoArrray = [];
        var id = null;
        var texto = "";

        for (var i = 0; i < data.length; i++) {
            id = data[i][keyIndice];

            for (var x = 0; x < keyTexto.length; x++) {
                texto += data[i][keyTexto[x]] + ' ';
            }
            resultadoArrray.push({ value: id, text: texto, });
            texto = '';
        }

        return resultadoArrray;
    }
}