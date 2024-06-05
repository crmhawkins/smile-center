(function($) {

    function HawkinsAjaxForm($form, options) {
        var defaultOptions = {
            notify: null,
            validate: null,
            redirect: null,
            custom: null,
            stopMultiple: true,
            includeCsrfToken: true,
            disableButtons: true,
            loadingButton: true,
            beforeSerialize: null,
            beforeSubmit: null,
            onSuccess: null,
            onError: null,
            onComplete: null
        };

        this.get = function(option) {
            return $form.data('hawkinsAjaxForm')[option];
        }
        this.set = function(option, value) {
            $form.data('hawkinsAjaxForm')[option] = value;
        }

        function notify(type, title, text) {
            if ($form.data('hawkinsAjaxForm').notify) {
                $form.data('hawkinsAjaxForm').notify(type, title, text);
            }
            else {
                alert(text ? text : title);
            }
        }
        function validate(validationErrors) {
            if ($form.data('hawkinsAjaxForm').validate) {
                $form.data('hawkinsAjaxForm').validate(validationErrors);
            }
            else {
                var message = "Por favor corrige los siguientes errores:\n";
                $.each(validationErrors, function(field, errors) {
                    message += "- " + field + ": " + errors[0] + "\n";
                });
                alert(message);
            }
        }
        function redirect(url, delay) {
            if ($form.data('hawkinsAjaxForm').redirect) {
                $form.data('hawkinsAjaxForm').redirect(url, delay);
            }
            else {
                setTimeout(function() {
                    window.location = url;
                }, delay);
            }
        }
        function custom(data) {
            if ($form.data('hawkinsAjaxForm').custom) {
                $form.data('hawkinsAjaxForm').custom(data);
            }
        }

        function processResponse(response) {
            // Validación
            if (response.validation) {
                validate(response.validation);
            }

            // Notificación
            if (response.message) {
                notify(response.message.type, response.message.title, response.message.text);
            }

            // Redirección
            if (response.redirection) {
                redirect(response.redirection.url, response.redirection.delay);
            }

            // Personalizado
            if (response.custom) {
                custom(response.custom);
            }
        }
        function completed() {
            if ($form.data('hawkinsAjaxForm').currentLoadingButton) {
                if ($form.data('hawkinsAjaxForm').currentLoadingButton.prop("tagName") == 'INPUT') {
                    $form.data('hawkinsAjaxForm').currentLoadingButton.val(
                        $form.data('hawkinsAjaxForm').currentLoadingButton.data('default-text')
                    );
                }
                else {
                    $form.data('hawkinsAjaxForm').currentLoadingButton.html(
                        $form.data('hawkinsAjaxForm').currentLoadingButton.data('default-text')
                    );
                }
                $form.data('hawkinsAjaxForm').currentLoadingButton = null;
            }

            if ($form.data('hawkinsAjaxForm').disableButtons) {
                $form.find('button, input[type=submit], input[type=button]').each(function() {
                    var $this = $(this);
                    $this.prop('disabled', $this.data('was-disabled'))
                });
            }

            $form.data('hawkinsAjaxForm').processing = false;

            if ($form.data('hawkinsAjaxForm').onComplete) {
                $form.data('hawkinsAjaxForm').onComplete();
            }
        }

        if (!$form.data('hawkinsAjaxForm')) {
            $form.data('hawkinsAjaxForm', $.extend({}, defaultOptions, options));

            if ($form.data('hawkinsAjaxForm').loadingButton) {
                $form.on('click', 'button, input[type=submit]', function() {
                    $form.data('hawkinsAjaxForm').lastButtonClicked = $(this);
                });
            }

            $form.ajaxForm({
                dataType: 'json',
                beforeSerialize: function($formElement, options) {
                    if ($form.data('hawkinsAjaxForm').beforeSerialize) {
                        var proceed = $form.data('hawkinsAjaxForm').beforeSerialize($formElement, options);
                        if (proceed === false) {
                            return false;
                        }
                    }
                },
                beforeSubmit: function(formData, $formElement, options) {
                    if ($form.data('hawkinsAjaxForm').stopMultiple && $form.data('hawkinsAjaxForm').processing) {
                        return false;
                    }

                    if ($form.data('hawkinsAjaxForm').includeCsrfToken) {
                        var $csrf = $('meta[name="csrf-token"]');
                        if ($csrf.length > 0) {
                            formData.push({ name: '_token', value: $csrf.attr('content') });
                        }
                    }

                    if ($form.data('hawkinsAjaxForm').beforeSubmit) {
                        var proceed = $form.data('hawkinsAjaxForm').beforeSubmit(formData, $formElement, options);
                        if (proceed === false) {
                            return false;
                        }
                    }

                    if ($form.data('hawkinsAjaxForm').disableButtons) {
                        $form.find('button, input[type=submit], input[type=button]').each(function() {
                            var $this = $(this);
                            $this.data('was-disabled', $this.prop('disabled'));
                            $this.prop('disabled', true);
                        });
                    }

                    if ($form.data('hawkinsAjaxForm').loadingButton) {
                        var $loadingButton = $form.data('hawkinsAjaxForm').lastButtonClicked;
                        if ($loadingButton && !$form.data('hawkinsAjaxForm').currentLoadingButton && $loadingButton.data('loading-text')) {
                            if ($loadingButton.prop("tagName") == 'INPUT') {
                                $loadingButton.data('default-text', $loadingButton.val());
                                $loadingButton.val($loadingButton.data('loading-text'));
                            }
                            else {
                                $loadingButton.data('default-text', $loadingButton.html());
                                $loadingButton.html($loadingButton.data('loading-text'));
                            }
                            $form.data('hawkinsAjaxForm').currentLoadingButton = $loadingButton;
                        }
                    }

                    $form.data('hawkinsAjaxForm').processing = true;
                },
                success: function(response, statusText, xhr, $formElement) {
                    if ($form.data('hawkinsAjaxForm').onSuccess) {
                        var proceed = $form.data('hawkinsAjaxForm').onSuccess(response, statusText, xhr, $formElement);
                        if (proceed === false) {
                            return false;
                        }
                    }

                    processResponse(response);
                    completed();
                },
                error: function(xhr, statusText, errorThrown) {
                    if ($form.data('hawkinsAjaxForm').onError) {
                        var proceed = $form.data('hawkinsAjaxForm').onError(xhr, statusText, errorThrown);
                        if (proceed === false) {
                            return false;
                        }
                    }

                    var response = null;
                    try {
                        response = JSON.parse(xhr.responseText);
                    } catch(e) {
                        notify('error', 'Error', 'Error desconocido');
                    }

                    if (response) {
                        processResponse(response);
                    }

                    completed();
                }
            });
        }
    }

    $.hawkinsAjaxForm = function(selector, options) {
        return new HawkinsAjaxForm($(selector), options);
    };

    $.fn.hawkinsAjaxForm = function(options) {
        return this.each(function() {
            $.hawkinsAjaxForm(this, options);
        });
    };

})(jQuery);
