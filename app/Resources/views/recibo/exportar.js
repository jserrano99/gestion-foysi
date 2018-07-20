$(function () {
    $('#appbundle_filtroFecha_startDate').val('');
    $('#appbundle_filtroFecha_endDate').val('');

    $("#tabs").tabs();
    $(".selec").checkboxradio();

    $(".selec").change(function () {
        var campo = $(this).attr('id');
        $("#divejercicio").css("display", 'none');
        $("#divrango").css("display", 'none');
        $("#divtrimestre").css("display", 'none');
        $("#divcontainer").css("display", 'block');
        $('#appbundle_filtroFecha_startDate').val('');
        $('#appbundle_filtroFecha_endDate').val('');
        switch (campo) {
            case 'iejercicio':
                $("#divejercicio").css("display", 'block');
                break;
            case 'itrimestre':
                $("#divtrimestre").css("display", 'block');
                break;
            case 'irango':
                $("#divrango").css("display", 'block');
                break;
        }
    });

    $('#appbundle_filtroFecha_rangoFecha').daterangepicker({
        'locale': {'format': 'DD/MM/YYYY',
            'applyLabel': 'Aplicar',
            'cancelLabel': 'Cancelar'
        }
    });

    $('#appbundle_filtroFecha_rangoFecha').on('apply.daterangepicker', function (ev, picker) {
        $('#appbundle_filtroFecha_startDate').val(picker.startDate.format('YYYY-MM-DD'));
        $('#appbundle_filtroFecha_endDate').val(picker.endDate.format('YYYY-MM-DD'));
    });

    $('#appbundle_filtroFecha_ejercicio').change(function () {
        var ejercicio = $('#appbundle_filtroFecha_ejercicio').val();
        var recurso = Routing.generate("ajaxEjercicio", {"id": ejercicio}, true);
        $.ajax({
            type: "POST",
            url: recurso,
            success: function (data, status, xhr) {

                $('#appbundle_filtroFecha_startDate').val(data.fcInicio);
                $('#appbundle_filtroFecha_endDate').val(data.fcFin);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
            }
        });
    });


    $('#appbundle_filtroFecha_ejercicio2').change(function () {
        var ejercicio = $('#appbundle_filtroFecha_ejercicio2').val();
        var recurso = Routing.generate("ajaxSelectTrimestre", {"ejercicio_id": ejercicio}, true);
        $.ajax({
            type: "POST",
            url: recurso,
            success: function (data, status, xhr) {
                $('#appbundle_filtroFecha_trimestre').html('<option>Seleccione Trimestre...</option>');
                $.each(data, function (key, value) {
                    $('#appbundle_filtroFecha_trimestre').append('<option value="' + value.id + '">' + value.descripcion + '</option>');
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
            }
        });

    });

    $('#appbundle_filtroFecha_trimestre').change(function () {
        var trimestre = $('#appbundle_filtroFecha_trimestre').val();
        var recurso = Routing.generate("ajaxTrimestre", {"id": trimestre}, true);
        $.ajax({
            type: "POST",
            url: recurso,
            success: function (data, status, xhr) {
                $('#appbundle_filtroFecha_startDate').val(data.fcInicio);
                $('#appbundle_filtroFecha_endDate').val(data.fcFin);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
            }
        });
    });

    $('#appbundle_filtroFecha_Guardar').click(function () {
        var startDate = $('#appbundle_filtroFecha_startDate').val();
        var endDate = $('#appbundle_filtroFecha_endDate').val();

        if (startDate != '' && endDate != '') {
            var recurso = Routing.generate("ajaxExportarRecibo", {"fcini": startDate, "fcfin": endDate}, true);
            $('#procesando').modal('show');
            $.ajax({
                type: "POST",
                url: recurso,
                success: function (data, status, xhr) {
                    $('.modal-backdrop').remove();
                    $('#procesando').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert('error en ajax=' + xhr.status);
                }
            });
        } 
    });

});
