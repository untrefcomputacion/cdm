$(function(){
    $("dt#delete-label, dd#delete-element").hide();
    
    $("input#bgcolor, input#fontcolor").ColorPicker({
        onSubmit: function(hsb, hex, rgb, element) {
            $(element).val("#" + hex);
            $(element).ColorPickerHide();
        },
        onBeforeShow: function () {
            $(this).ColorPickerSetColor(this.value);
        }
    })
    .live('keyup', function(){
        $(this).ColorPickerSetColor(this.value);
    });

    $("input#action").val('create');
    
    $("tr.estado").live('click', loadToEdit);
    $("input#delete").live('click', deleteEstado);
    $("button#reset").live('click', clearForm);
    $("select.estados").live('change', setEstado);
});

function loadToEdit() {
    $("input#action").val('update');
    var id = this.id;
    $("input#id").val(id);
    $("input#nombre").val($("tr#" + id + " td.nombre").html());
    $("input#class").val($("tr#" + id + " td.class").html());
    $("input#bgcolor").val($("tr#" + id + " td.bgcolor").html());
    $("input#fontcolor").val($("tr#" + id + " td.fontcolor").html());
    $("input#descripcion").val($("tr#" + id + " td.descripcion").html());
    $("input#submit").val("Actualizar estado");
    $("dt#delete-label, dd#delete-element").show();
}

function clearForm() {
    $("input#id").val('');
    $("input#nombre").val('');
    $("input#class").val('');
    $("input#bgcolor").val('');
    $("input#fontcolor").val('');
    $("input#descripcion").val('');
    
    $("input#action").val('create');
    $("input#submit").val("Crear estado");
    $("dt#delete-label, dd#delete-element").hide();
    $("ul.errors").remove();
}

function deleteEstado() {
    if(confirm("¿Esta seguro de eliminar el estado '" + $("input#nombre").val() + "'?")) {
        $("input#action").val('delete');
        return true;
    } else {
        return false;
    }
}

function setEstado() {
    var estadoId = $(this).val();
    var condicionId = this.id;
    
    if(estadoId != 0){
        $.ajax({
            url: 'admin/condicion/setestado',
            type: 'post',
            data: {
                'condicionId' : condicionId,
                'estadoId' : estadoId
            },
            dataType: 'json',
            success: function (response) {
                if(response.error){
                    console.log(response);
                }
            }
        });
    }
}
