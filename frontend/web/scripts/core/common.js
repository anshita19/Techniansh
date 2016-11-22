
$('[data-pjax-form-container="1"]').on('pjax:end', function (data, status, xhr, options) {

    var container = window.parent.$('[data-pjax-grid-container="1"]');
    var grid = window.parent.$('[data-gridurl]');
    if (container.length == 0 || grid.length == 0)
        return;
    var obj = jQuery.parseJSON(status.responseText);
    if (obj.msgtype !== '') {
        window.parent.eModal.close();
        window.parent.$.pjax.reload({url: grid.eq(0).data('gridurl'), container: container[0], timeout: 3000});
        displayMessage(obj);
    }
});

$('[data-pjax-form-container="1"]').on('pjax:error', function (xhr, textStatus, error, options) {
    if (textStatus.responseText !== '') {
        var obj = {"msgtype": "warning", "msg": textStatus.responseText};
        displayFormMessage(obj);
    }
});

$(document).bind("ajaxSend", function () {
    $('#ajax_loader').addClass("modal-backdrop fade in");
}).bind("ajaxComplete", function () {
    $('#ajax_loader').removeClass("modal-backdrop fade in");
});

function displayMessage(data) {
    if (data != '')
    {
        var html = '';
        html += '<div class=\"alert-' + data.msgtype + ' alert fade in\">';
        html += '<button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button>';
        html += data.msg;
        html += '</div>';
        if (data !== '') {
            window.parent.$('#msg_panel').html(html);
        }
        setTimeout(function () {
            $('.alert').fadeOut()
        }, 5000);
    }
}

function displayFormMessage(data) {
    if (data != '')
    {
        var html = '';
        html += '<div class=\"alert-' + data.msgtype + ' alert fade in\">';
        html += '<button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button>';
        html += data.msg;
        html += '</div>';
        if (data !== '') {
            $('#msg_panel').html(html);
        }
    }
}

$('[data-pjax-grid-container="1"]').on('pjax:complete', function () {
    attachEModal($('[data-toggle="emodal"]'));
    if ($('.select').length)
    {
        $('.select').select2({
            minimumResultsForSearch: Infinity,
            width:'auto'
        });
    }
});

$(function () {
    attachEModal($('[data-toggle="emodal"]'));
});

function attachEModal(obj) {
    obj.click(function () {
        eModal.iframe({id: 'iframe_emodal', url: $(this).attr('href'), size: eval('eModal.size.' + ($(this).attr('data-size') ? $(this).attr('data-size') : 'xl')), title: $(this).attr('data-title')});
        return false;
    });
}

$(document).on("pjax:timeout", function (event) {
    // Prevent default timeout redirection behavior
    event.preventDefault()
});

if ($('.styled').length)
{
    $('.styled').uniform({
        radioClass: 'choice'
    });
}

if ($('.select').length)
{
    $('.select').select2({
        minimumResultsForSearch: Infinity,
    });
}

if ($(".file-styled").length) {
    $(".file-styled").uniform({
        wrapperClass: 'bg-primary',
        fileButtonHtml: '<i class="icon-googleplus5"></i>'
    });
}

if($(".slug").length){
    $(".slug").focusin(function() {
        $(".slug").val($('#'+$(this).attr('data-dep')).val().replace(/\s+/g, '-').toLowerCase());
    });
}

$('iframe').ready(function () {
    var p = $('.content').height();
    var height = p + 60;
    window.parent.$('.embed-responsive-item').height(height);
});

$(".styled, .multiselect-container input").uniform({
    radioClass: 'choice'
});

