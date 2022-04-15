require('./bootstrap');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Cancella i dati del form quando chiuto il modale
$('#modalePresenze').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
    $('.importo').attr('placeholder', 'Importo');
});

$(".datiPresenza").click(function(){
    let dataSelezionata = $(this).data('data-cella');
    let idCollaboratoreSelezionato =  $(this).data('id-collaboratore-cella');

    $('#aggiungiData').attr('value', dataSelezionata);
    $('#fino_a').attr('value', dataSelezionata);
    $('#aggiungiDataSpan').text(dataSelezionata);

    $.ajax({
        url: "/datiPresenza",
        method: 'GET',
        data: {
            dataSel: dataSelezionata,
            idColl: idCollaboratoreSelezionato
        },
        success: function (data) {
            $('#tipo_di_presenza').val(data.tipo_di_presenza);
            $('#importo').attr('value', data.importo);
            $('#luogo').attr('value', data.luogo);
            $('#descrizione').val(data.descrizione);
            $('#spese_rimborso').attr('value', data.spese_rimborso);
            $('#bonus').attr('value', data.bonus);
           // $('#modalePresenze').modal('hide').trigger("reset");

            if (!data.importo == '' ) {
                $('.bottone-elimina').html("Elimina");
                $('.bottone-modifica').html("Modifica");
                $('.bottone-elimina').removeClass("d-none").addClass("d-inline");
            }

            if (data.importo == '') {
                $('.bottone-elimina').html("Elimina");
                $('.bottone-modifica').html("Salva");
                $('.bottone-elimina').removeClass("d-inline").addClass("d-none");
            }
        }
    });
});

$('.datiCollaboratore').click(function() {
    let idCollaboratoreSelezionato =  $(this).data('id-collaboratore-cella');

    $('#nomeCollaboratore').text($(this).data('nome'));
    $('#idCollaboratore').attr('value', idCollaboratoreSelezionato);

    $.ajax({
        url: "/datiCollaboratore",
        method: 'GET',
        data: {
            idColl: idCollaboratoreSelezionato
        },
        success: function (data) {
            $('.intera').attr('data-tariffa', data.intera_giornata);
            $('.mezza').attr('data-tariffa', data.mezza_giornata);
            $('.estera').attr('data-tariffa', data.giornata_estero);
            $('.formazione').attr('data-tariffa', data.giornata_formazione);
            //$('#modalePresenze').modal('hide').trigger("reset");
            // $('.concordato').attr('data-tariffa', 'Importo');
        }
    });
});

$( "#creaAggiornaPresenza" ).submit(function(event) {

    event.preventDefault();

    let imp = 0;
    if ($('#tipo_di_presenza').find(":selected").data('tariffa')) {
        imp = $('#tipo_di_presenza').find(":selected").data('tariffa')
    } else {
        imp = $('#importo').val()
    }

    $.ajax({
        url: "/crea_aggiorna_presenza",
        type: "POST",
        data:{
            idColl: $('#idCollaboratore').val(),
            data: $('#aggiungiData').val(),
            tipoPresenza: $('#tipo_di_presenza').val(),
            importo: imp,
            luogo: $('#luogo').val(),
            descrizione: $('#descrizione').val(),
            speseRimborso: $('#spese_rimborso').val(),
            bonus: $('#bonus').val(),
            finoA: $('#fino_a').val(),
        },

        success:function(response){
            console.log(response[1]);
            // Se il record non è stato creato
            if (response.status == 400) {
                // messaggio di errore con validate
                $('#StampaErrori').html("");
                $('#StampaErrori').addClass("alert alert-danger");
                $.each(response.errors, function($key, err_value){
                    $('#StampaErrori').append('<li>' + err_value + '</li>');
                });
                // Non chiude il modale
                $('#modalePresenze').modal('show');

                // Rimuove il messaggio di errore quando chiudo il modale
                $('#modalePresenze').on('hidden.bs.modal', function(){
                    $("#StampaErrori").removeClass("alert alert-danger");
                    $("#StampaErrori").html("");
                });

            // Se la chiamata ha successo
            }else {
                // Messaggio che dice che il record e stato creato
                $('#messaggioSuccesso').html("");
                $('#messaggioSuccesso').addClass("alert alert-success");
                $('#messaggioSuccesso').text(response.message);
                // Ciudo il modale
                $('#modalePresenze').modal('hide');



                let idDataPresenza = 0;

                for(var i=0; i < response.length; i++){

                    idDataPresenza = response[i].collaborator_id + '-' + response[i].data;

                    let colore = 0;
                    if (response[i].tipo_di_presenza == 'Intera giornata') {
                        colore = '#35964b';
                    }
                    if(response[i].tipo_di_presenza == 'Mezza giornata') {
                        colore = '#68aeca';
                    }
                    if(response[i].tipo_di_presenza == 'Giornata all\' estero') {
                        colore = '#c7c422';
                    }
                    if(response[i].tipo_di_presenza == 'Giornata di formazione propria') {
                        colore = '#757442';
                    }
                    if(response[i].tipo_di_presenza == 'Giornata a prezzo concordato') {
                        colore = '#7e467e';
                    }
                    if (response[i].spese_rimborso) {
                        $("#" + idDataPresenza).text('S');
                    }
                    if (response[i].bonus) {
                        $("#" + idDataPresenza).text('B');
                    }
                    if (response[i].spese_rimborso && response[i].bonus) {
                        $("#" + idDataPresenza).text('SB');
                    }
                    let idDataCelle = $("#" + idDataPresenza).css('background-color', colore);
                }

            }
        },
    });
});

$(".cambiaImporto").change(function(){
    if ($('#tipo_di_presenza').find(":selected").val() == 'Giornata a prezzo concordato') {
        $('.importo').prop('disabled', false).attr("placeholder", $('#tipo_di_presenza').find(":selected").data('tariffa'));
    } else{
        $('.importo').prop('disabled', 'disabled').attr("placeholder", $('#tipo_di_presenza').find(":selected").data('tariffa'));
    }
});

$('#eliminaPresenza').click( function() {
    $.ajax({
        url: "/eliminaPresenza",
        type: "DELETE",
        data:{
            prendiIdColl: $('#idCollaboratore').val(),
            prendiData: $('#aggiungiData').val(),
        },
        success: function (data) {
            $('#modalePresenze').modal('hide');
            location.reload();
        }
    });
});

$('#print').click(function() {
    //$.print('stampa');
    alert('hello');
});
