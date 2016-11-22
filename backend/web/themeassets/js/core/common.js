$('[data-pjax-form-container="1"]').on('pjax:end', function (data, status, xhr, options) {
    window.parent.eModal.close();
    var container = window.parent.$('[data-pjax-grid-container="1"]');
    var grid = window.parent.$('[data-gridurl]');
    
    if (container.length == 0 || grid.length == 0) return;

    window.parent.$.pjax.reload({url: grid.eq(0).data('gridurl'), container: container[0], timeout: 3000});
    var obj = jQuery.parseJSON(status.responseText);
    displayMessage(obj);

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
        if (data != '') {
            window.parent.$('#msg_panel').html(html);
        }
        setTimeout(function () {
            $('.alert').fadeOut()
        }, 5000);
    }
}

$('[data-pjax-grid-container="1"]').on('pjax:complete', function () {
    attachEModal($('[data-toggle="emodal"]'));
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

$('iframe').ready(function () {
    var p = $('.content').height();
    var height = p + 60;
    window.parent.$('.embed-responsive-item').height(height);
});

/*$(".icon-trash").on('click',function (e) {
 e.preventDefault();
 var deleteUrl = $(this).attr('delete-url');
 if (window.confirm("Are you sure you want to delete this item?"))
 {
 $.ajax({
 url: deleteUrl,
 type: "post",
 error: function (xhr, status, error) {
 alert("There was an error with your request." + xhr.responseText);
 }
 }).done(function (data) {
 $.pjax.reload({container: "[data-pjax-grid-container=\"1\"]"});
 });
 }
 
 });*/