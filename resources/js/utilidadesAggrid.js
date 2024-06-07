
function refrescarGrid(gridApi) {
    return gridApi.refreshCells();
}

function removeItemGrid(id, gridApi) {
    const itemsToProcess = [];

    var rowNode = gridApi.getRowNode(id);
    if (rowNode != null) {
        itemsToProcess.push(rowNode.data);
        gridApi.applyTransaction({ remove: itemsToProcess });
    }
    return gridApi;
}

function updateGrid(res, id, gridApi) {
    const itemsToProcess = [];

    var rowNode = gridApi.getRowNode(id);

    var params = {
        data: null
    };

    params.data = res;


    //Actualizar
    if (rowNode != null) {
        rowNode.data = res; 
        itemsToProcess.push(rowNode.data);
        gridApi.applyTransaction({ update: itemsToProcess });
    }
    //Agregar
    if (rowNode == null) {
        itemsToProcess.push(res);
        gridApi.applyTransaction({
            add: itemsToProcess,
        });
    }

    return gridApi;
}