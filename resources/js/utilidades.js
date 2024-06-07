function cambiarValoresNulos(datos)
{
    for (var key in datos) {
        // skip loop if the property is from prototype
        if (!datos.hasOwnProperty(key)) continue;
    
        var obj = datos[key];
        for (var prop in obj) {
            // skip loop if the property is from prototype
            if (!obj.hasOwnProperty(prop)) continue;
    
            // your code
            if(obj[prop]==null)
            {
                console.log(prop);
                obj[prop]=""
            }
            //alert(prop + " = " + obj[prop]);
        }
    }

    return datos;
}