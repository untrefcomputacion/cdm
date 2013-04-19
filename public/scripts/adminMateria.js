$(function(){
    $("dt#delete-label, dd#delete-element").hide();
    
    $("input#action").val('create');
    
    $("tr.materia").live('click', loadToEdit);
    $("input#submit").live('click', submitForm);
    $("input#delete").live('click', deleteMateria);
    $("button#reset").live('click', clearForm);
});

function loadToEdit() {
    $("input#action").val('update');
    var id = this.id;
    $("input#id").val(id);
    $("input#anio").val($("tr#" + id + " td.anio").html());
    $("input#cuatrimestre").val($("tr#" + id + " td.cuatrimestre").html());
    $("input#codigo").val($("tr#" + id + " td.codigo").html());
    $("input#nombre").val($("tr#" + id + " td.nombre").html());
    $("input#horas").val($("tr#" + id + " td.horas").html());
    $("select#correlativa").val($("tr#" + id + " td.correlativa").attr('id'));
    $("input#submit").val("Actualizar materia");
    
    $("dt#delete-label, dd#delete-element").show();
    $("input#id").attr('disabled', 'disabled');
    $(document).scrollTop(0);
}

function clearForm() {
    $("input#id").val('');
    $("input#anio").val('');
    $("input#cuatrimestre").val('');
    $("input#codigo").val('');
    $("input#nombre").val('');
    $("input#horas").val('');
    $("select#correlativa").val(0);
    
    console.log("se ejecuta");
    
    $("input#action").val('create');
    $("input#submit").val("Crear materia");
    $("input#id").attr('disabled', false);
    $("dt#delete-label, dd#delete-element").hide();
    $("ul.errors").remove();
}

function submitForm() {
    $("input#id").attr('disabled', false);
    return true;
 }

function deleteMateria() {
    if(confirm("¿Esta seguro de eliminar la materia '" + $("input#nombre").val() + "'?")) {
        $("input#action").val('delete');
        $("input#id").attr('disabled', false);
        return true;
    } else {
        return false;
    }
}
