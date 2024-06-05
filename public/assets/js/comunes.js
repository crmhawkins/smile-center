
/*
////////////////////////
    FUNCIONES: COMÚN
////////////////////////
*/

var CommonFunctions = {};

CommonFunctions.notification = function(type, title, text) {
    var options = {
        type: type,
        showConfirmButton: false,
        timer: 5000
    };
    if (title) {
        options['title'] = title;
    }
    if (text) {
        options['text'] = text;
    }

    swal(options);
};
CommonFunctions.notificationWarning = function(text, url) {
    Swal.fire({
        type: 'warning',
        title: 'Advertencia',
        text: text,
        allowEscapeKey: true,
        allowOutsideClick: true,
        allowEnterKey: false,
        showLoaderOnConfirm: true,
    });
};
CommonFunctions.notificationSuccessRedirect = function(text, url) {
    Swal.fire({
        type: 'success',
        title: 'Éxito',
        text: text,
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        showLoaderOnConfirm: true,
        preConfirm: function() {
            return new Promise(function(resolve) {
                window.location = url;
            });
        }
    });
};
CommonFunctions.notificationSuccessStayOrBackProject = function(text, stayUrl, backUrl) {
    var $html = $(
        '<div>' +
            text +
            '<br><br><br>' +
            '<div class="swal2-custombuttons">' +
                '<button class="btn btn-success" data-url="' + stayUrl + '">Seguir creando campaña</button>' +
            '</div>' +
        '</div>'
    );
    $(document).on('click', '.swal2-custombuttons button', function() {
        $(this).addClass('clicked');
        swal.clickConfirm();
    });
    Swal.fire({
        type: 'success',
        title: 'Éxito',
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        customClass: 'swal2-custom',
        showLoaderOnConfirm: true,
        html: $html,
        preConfirm: function() {
            return new Promise(function(resolve) {
                var url = $('.swal2-custombuttons button.clicked').data('url');
                if (url === null) {
                    resolve();
                }
                else {
                    window.location = url;
                }
            });
        }
    });
};
CommonFunctions.notificationSuccessStayOrBackBudget = function(text, stayUrl, backUrl) {
    var $html = $(
        '<div>' +
            text +
            '<br><br><br>' +
            '<div class="swal2-custombuttons">' +
                '<button class="btn btn-success" data-url="' + stayUrl + '">Seguir creando presupuesto</button>' +
            '</div>' +
        '</div>'
    );
    $(document).on('click', '.swal2-custombuttons button', function() {
        $(this).addClass('clicked');
        swal.clickConfirm();
    });
    Swal.fire({
        type: 'success',
        title: 'Éxito',
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        customClass: 'swal2-custom',
        showLoaderOnConfirm: true,
        html: $html,
        preConfirm: function() {
            return new Promise(function(resolve) {
                var url = $('.swal2-custombuttons button.clicked').data('url');
                if (url === null) {
                    resolve();
                }
                else {
                    window.location = url;
                }
            });
        }
    });
};

CommonFunctions.notificationSuccessStayOrBackPetition = function(text, stayUrl, backUrl) {
    var $html = $(
        '<div>' +
            text +
            '<br><br><br>' +
            '<div class="swal2-custombuttons">' +
                '<button class="btn btn-success" data-url="' + stayUrl + '">Seguir editando</button>' +
                '<button style="margin-left:10px" class="btn btn-success" data-url="' + backUrl + '">Lista</button>' +
            '</div>' +
        '</div>'
    );
    $(document).on('click', '.swal2-custombuttons button', function() {
        $(this).addClass('clicked');
        swal.clickConfirm();
    });
    Swal.fire({
        type: 'success',
        title: 'Éxito',
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        customClass: 'swal2-custom',
        showLoaderOnConfirm: true,
        html: $html,
        preConfirm: function() {
            return new Promise(function(resolve) {
                var url = $('.swal2-custombuttons button.clicked').data('url');
                if (url === null) {
                    resolve();
                }
                else {
                    window.location = url;
                }
            });
        }
    });
};
CommonFunctions.notificationSuccessDownloadOrBack = function(text, stayUrl, backUrl) {
    var $html = $(
        '<div>' +
            text +
            '<br><br><br>' +
            '<div class="swal2-custombuttons">' +
                '<button class="btn btn-success" data-url="' + stayUrl + '">Descargar</button>' +
                '<button style="margin-left:10px" class="btn btn-success" data-url="' + backUrl + '">Seguir editando</button>' +
            '</div>' +
        '</div>'
    );
    $(document).on('click', '.swal2-custombuttons button', function() {
        $(this).addClass('clicked');
        swal.clickConfirm();
    });
    Swal.fire({
        type: 'success',
        title: 'Éxito',
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        customClass: 'swal2-custom',
        showLoaderOnConfirm: true,
        html: $html,
        preConfirm: function() {
            return new Promise(function(resolve) {
                console.log(resolve);
                var url = $('.swal2-custombuttons button.clicked').data('url');
                if (url === null) {
                    resolve();
                }
                else {
                    window.location = url;
                    resolve();
                }
            });
        }
    });
};
CommonFunctions.notificationSuccessStayOrBackInvoice = function(text, stayUrl, backUrl) {
    var $html = $(
        '<div>' +
            text +
            '<br><br><br>' +
            '<div class="swal2-custombuttons">' +
                '<button class="btn btn-success" data-url="' + stayUrl + '">Ver factura generada</button>' +
            '</div>' +
        '</div>'
    );
    $(document).on('click', '.swal2-custombuttons button', function() {
        $(this).addClass('clicked');
        swal.clickConfirm();
    });
    Swal.fire({
        type: 'success',
        title: 'Éxito',
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        customClass: 'swal2-custom',
        showLoaderOnConfirm: true,
        showConfirmButton: false,
        html: $html,
        preConfirm: function() {
            return new Promise(function(resolve) {
                var url = $('.swal2-custombuttons button.clicked').data('url');
                if (url === null) {
                    resolve();
                }
                else {
                    window.location = url;
                }
            });
        }
    });
};
CommonFunctions.notificationSuccessStayOrBackNewBudgetConcept = function(text, stayUrl, backUrl) {
    var $html = $(
        '<div>' +
            text +
            '<br><br><br>' +
            '<div class="swal2-custombuttons">' +
                '<button style="margin-left:10px" class="btn btn-success" data-url="' + backUrl + '">Ir al Presupuesto</button>' +
                '<button style="margin-left:10px" class="btn btn-success" data-url="' + stayUrl + '">Seguir Editando</button>' +
            '</div>' +
        '</div>'
    );
    $(document).on('click', '.swal2-custombuttons button', function() {
        $(this).addClass('clicked');
        swal.clickConfirm();
    });
    Swal.fire({
        type: 'success',
        title: 'Éxito',
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        customClass: 'swal2-custom',
        showLoaderOnConfirm: true,
        showConfirmButton: false,
        html: $html,
        preConfirm: function() {
            return new Promise(function(resolve) {
                var url = $('.swal2-custombuttons button.clicked').data('url');
                if (url === null) {
                    resolve();
                }
                else {
                    window.location = url;
                }
            });
        }
    });
};
CommonFunctions.notificationSuccessSendEmailOrBackNewBudgetConcept = function(text, stayUrl, backUrl) {
    var $html = $(
        '<div>' +
            text +
            '<br><br><br>' +
            '<div class="swal2-custombuttons">' +
                '<button class="btn btn-success" data-url="' + stayUrl + '">Guardar y Enviar Email</button>' +
                '<button style="margin-left:10px" class="btn btn-success" data-url="' + backUrl + '">Ir al presupuesto</button>' +
            '</div>' +
        '</div>'
    );
    $(document).on('click', '.swal2-custombuttons button', function() {
        $(this).addClass('clicked');
        swal.clickConfirm();
    });
    Swal.fire({
        type: 'success',
        title: 'Éxito',
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        customClass: 'swal2-custom',
        showLoaderOnConfirm: true,
        showConfirmButton: false,
        html: $html,
        preConfirm: function() {
            return new Promise(function(resolve) {
                var url = $('.swal2-custombuttons button.clicked').data('url');
                if (url === null) {
                    resolve();
                }
                else {
                    window.location = url;
                }
            });
        }
    });
};
CommonFunctions.notificationSuccessStayOrBack = function(text, stayUrl, backUrl) {
    var $html = $(
        '<div>' +
            text +
            '<br><br><br>' +
            '<div class="swal2-custombuttons">' +
                '<button class="btn btn-success" data-url="' + stayUrl + '">Seguir Editando</button>' +
                '<button style="margin-left:10px" class="btn btn-success" data-url="' + backUrl + '">Ir a la lista</button>' +
            '</div>' +
        '</div>'
    );
    $(document).on('click', '.swal2-custombuttons button', function() {
        $(this).addClass('clicked');
        swal.clickConfirm();
    });
    Swal.fire({
        type: 'success',
        title: 'Éxito',
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        customClass: 'swal2-custom',
        showLoaderOnConfirm: true,
        showConfirmButton: false,
        html: $html,
        preConfirm: function() {
            return new Promise(function(resolve) {
                var url = $('.swal2-custombuttons button.clicked').data('url');
                if (url === null) {
                    resolve();
                }
                else {
                    window.location = url;
                }
            });
        }
    });
};
CommonFunctions.notificationSuccessStayOrBackHolidayCriteria = function(text, stayUrl, backUrl) {
    var $html = $(
        '<div>' +
            text +
            '<br><br><br>' +
            '<div class="swal2-custombuttons">' +
                '<button class="btn btn-success" data-url="' + stayUrl + '">Seguir Editando</button>' +
                '<button style="margin-left:10px" class="btn btn-success" data-url="' + backUrl + '">Volver</button>' +
            '</div>' +
        '</div>'
    );
    $(document).on('click', '.swal2-custombuttons button', function() {
        $(this).addClass('clicked');
        swal.clickConfirm();
    });
    Swal.fire({
        type: 'success',
        title: 'Éxito',
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        customClass: 'swal2-custom',
        showLoaderOnConfirm: true,
        showConfirmButton: false,
        html: $html,
        preConfirm: function() {
            return new Promise(function(resolve) {
                var url = $('.swal2-custombuttons button.clicked').data('url');
                if (url === null) {
                    resolve();
                }
                else {
                    window.location = url;
                }
            });
        }
    });
};
CommonFunctions.notificationConfirmDelete = function(text, buttonText, url, callback) {
    Swal.fire({
        type: 'warning',
        title: 'Atención',
        text: text,
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: buttonText,
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: function() {
            return new Promise(function(resolve) {
                $('.swal2-buttonswrapper > button:not(:first)').remove();

                var $form = $('<form method="POST"><input type="hidden" name="_method" value="DELETE" /></form>');
                $form.prop('action', url);
                $form.data('callback', callback);
                $form.appendTo('body');
                CommonFunctions.setupAjaxForm($form);
                $form.submit();
            });
        }
    });
};
CommonFunctions.notificationConfirmDeleteBudgetConcept = function(text, buttonText, url, callback) {
    Swal.fire({
        type: 'warning',
        title: 'Atención',
        text: text,
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: buttonText,
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: function() {
            return new Promise(function(resolve) {
                $('.swal2-buttonswrapper > button:not(:first)').remove();

                var $form = $('<form method="POST"><input type="hidden" name="_method" value="DELETE" /></form>');
                $form.prop('action', url);
                $form.data('callback', callback);
                $form.appendTo('body');
                CommonFunctions.setupAjaxForm($form);
                $form.submit();
            });
        }
    });
};
CommonFunctions.notificationConfirmPurchaseOrderGeneration = function(text, buttonText, url, callback) {
    Swal.fire({
        type: 'warning',
        title: 'Confirmación',
        text: text,
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        showCancelButton: true,
        confirmButtonColor: 'green',
        confirmButtonText: buttonText,
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: function() {
            return new Promise(function(resolve) {
                $('.swal2-buttonswrapper > button:not(:first)').remove();

                var $form = $('<form method="POST"><input type="hidden" name="_method" value="DELETE" /></form>');
                $form.prop('action', url);
                $form.data('callback', callback);
                $form.appendTo('body');
                CommonFunctions.setupAjaxForm($form);
                $form.submit();
            });
        }
    });
};


CommonFunctions.notificationConfirmDenyPetition = function(text, buttonText, url, callback) {
    Swal.fire({
        type: 'warning',
        title: 'Atención',
        text: text,
        allowEscapeKey: false,
        allowOutsideClick: false,
        allowEnterKey: false,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: buttonText,
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: function() {
            return new Promise(function(resolve) {
                $('.swal2-buttonswrapper > button:not(:first)').remove();

                var $form = $('<form method="POST"><input type="hidden" name="_method" value="POST" /></form>');
                $form.prop('action', url);
                $form.data('callback', callback);
                $form.appendTo('body');
                CommonFunctions.setupAjaxForm($form);
                $form.submit();
            });
        }
    });
};

CommonFunctions.validation = function(validationErrors) {
    function parseField(field) {
        var parts = field.split('.');
        if (parts.length == 1) {
            return parts[0];
        }
        var field = parts.shift();
        parts = parts.map(function(item) {
            return "[" + item + "]";
        });
        return field + parts.join('');
    }

    $.each(validationErrors, function(field, errors) {
        var $field = $('[name="' + parseField(field) + '"]');
        if ($field.length > 1) {
            // ...
        }
        else if ($field.length == 1) {
            var $target = $field;
            var $container = $field.parent();
            if ($container.hasClass('input-group')) {
                $target = $container;
                $container = $container.parent();
            }

            $target.addClass('is-invalid');

            var $error = $container.children('.invalid-feedback:first');
            if ($error.length == 0) {
                $error = $('<div class="invalid-feedback" />');
                $target.after($error);
            }
            $error.html(errors[0]);

            if (!$target.hasClass('was-invalid-before')) {
                $field.on('change', function() {
                    $target.removeClass('is-invalid');
                    $error.html('');
                });
                $target.addClass('was-invalid-before');
            }
        }
    });
};

CommonFunctions.setupAjaxForm = function(form) {
    var $form = $(form);
    var options = {
        notify: CommonFunctions.notification,
        validate: CommonFunctions.validation
    };
    if ($form.data('callback')) {
        options['custom'] = typeof $form.data('callback') === "function" ? $form.data('callback') : window[$form.data('callback')];
    }
    $form.hawkinsAjaxForm(options);
}

CommonFunctions.openPopup = function(src, type, options) {
    $.fancybox.open({
        src: src,
        type: type,
        opts: options
    });
}
CommonFunctions.openIframePopup = function(src, options) {
    CommonFunctions.openPopup(src, 'iframe', options)
}
CommonFunctions.openInlinePopup = function(src, options) {
    CommonFunctions.openPopup(src, 'inline', options)
}
CommonFunctions.openHtmlPopup = function(src, options) {
    CommonFunctions.openPopup(src, 'html', options)
}
CommonFunctions.currentPopup = function() {
    return $.fancybox.getInstance();
}
CommonFunctions.closePopup = function() {
    $.fancybox.close();
}

$(document).ready(function() {

    $('form:not([data-ajax=false])').each(function() {
        CommonFunctions.setupAjaxForm(this);
    });

    $('a.popup-iframe').click(function() {
        CommonFunctions.openIframePopup($(this).attr('href'));
        return false;
    });
    $('a.popup-inline').click(function() {
        CommonFunctions.openInlinePopup($(this).attr('href'));
        return false;
    });

});
