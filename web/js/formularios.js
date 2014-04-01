$.validator.setDefaults(
        {
            invalidHandler: function(event, validator) {
                //display error alert on form submit    
            },
            errorPlacement: function(label, element) { // render error placement for each input type   
                $('<span class="error"></span>').insertAfter(element).append(label)
                var parent = $(element).parent('.input-with-icon');
                parent.removeClass('success-control').addClass('error-control');
            },
            highlight: function(element) { // hightlight error inputs
                var parent = $(element).parent();
                parent.removeClass('success-control').addClass('error-control');
            },
            unhighlight: function(element) { // revert the change done by hightlight

            },
            success: function(label, element) {
                var parent = $(element).parent('.input-with-icon');
                parent.removeClass('error-control').addClass('success-control');
            },
        });
$(function()
{
    $.validator.addMethod('onecheck', function(value, ele) {
            return $("#div_xdias input:checked").length >= 1;
        }, 'Please Select Atleast One CheckBox');
    $("#servicio_form").validate({
        rules: {
            "servicio[nombre]": "required",
            "servicio[empresa]": "required",
            "servicio[tipo]": "required",
            "servicio[pais]": "required",
            "servicio[hora]": "required",
            "servicio[tipoFrecuencia]": {                
                required: true
            },
            "servicio[fechaInicial]": "required",
            "servicio[frecuencia]": {
                required: '#div_frecuencia:visible'
            }            
        },
        messages: {
            "servicio[nombre]": "Ingrese el nombre para el Servicio",
            "servicio[empresa]": "Seleccione una Empresa",
            "servicio[tipo]": "Seleccione un tipo de servicio",
            "servicio[pais]": "Seleccione el pais de origen o procedencia del servicio",
            "servicio[hora]": "Seleccione la hora de salida o arribo del servicio",
            "servicio[tipoFrecuencia]": {
                    required: "Seleccione el tipo de frecuencia del servicio"                    
                },
            "servicio[fechaInicial]": "Ingrese la fecha de inicio del servicio",
            "servicio[frecuencia]": {
                required: 'Ingrese la cantidad de días de frecuencia del servicio'
            }            
        },
        submitHandler: function(form) {                        
            if($('#div_xdias').is(':visible') && $('#div_xdias input:checked').length < 1)
            {
                $('#errores_dias').show();
            }
            else
            {
                $('#errores_dias').hide();
                form.submit();
            }
            return false;
        }
    });
    $("#feriado_form").validate({
        rules: {
            "feriado[fecha]": "required",
            "feriado[nombre]": "required"
        },
        messages: {
            "feriado[fecha]": "Ingrese la fecha correspondiente al feriado",
            "feriado[nombre]": "Ingrese el nombre que representa el feriado"
        }
    });
    $("#empresa_form").validate({
        rules: {
            "empresa[nombre]": "required"
        },
        messages: {
            "empresa[nombre]": "Ingrese el nombre de la Empresa"
        }
    });
    $("#pais_form").validate({
        rules: {
            "pais[nombre]": "required"
        },
        messages: {
            "pais[nombre]": "Ingrese el nombre del Pais",
        }
    });
    $("#provincia_form").validate({
        rules: {
            "provincia[nombre]": "required",
            "provincia[pais]": "required"
        },
        messages: {
            "provincia[nombre]": "Ingrese el nombre de la Provincia",
            "provincia[pais]": "Seleccione el pais al que pertenece la Provincia"
        }
    });
    $("#localidad_form").validate({
        rules: {
            "localidad[nombre]": "required",
            "localidad[provincia]": "required"
        },
        messages: {
            "localidad[nombre]": "Ingrese el nombre de la Localidad",
            "localidad[provincia]": "Seleccione la provincia a la que pertenece la Localidad"
        }
    });
    $("#form_cuenta_details").validate({
        rules: {
            "usuario[nombre]": "required",
            "usuario[apellido]": "required",
            "usuario[email]": {
                required: true,
                email: true
            }
        },
        messages: {
            "usuario[email]": {
                required: "Ingrese un email del Usuario",
                email: "El email ingresado es inválido"
            },
            "usuario[nombre]": "Ingrese el nombre del Usuario",
            "usuario[apellido]": "Ingrese el nombre del Usuario",
        }
    });
    $("#form_cuenta_settings").validate({
        rules: {
            "usuario[email]": {
                required: true,
                email: true
            }
        },
        messages: {
            "usuario[email]": {
                required: "Ingrese un email del Usuario",
                email: "El email ingresado es inválido"
            }

        }
    });
    $("#form_cuenta_password").validate({
        rules: {
            "change_password[current_password]": "required",
            "change_password[plainPassword][first]": "required",
            "change_password[plainPassword][second]": {
                required: true,
                equalTo: "#change_password_plainPassword_first"
            }
        },
        messages: {
            "change_password[current_password]": "Ingrese su contraseña actual",
            "change_password[plainPassword][first]": "Ingrese su nueva contraseña",
            "change_password[plainPassword][second]": {
                required: 'Repita la nueva contraseña',
                equalTo: "Las nuevas contraseñas no coinciden"
            }

        }
    });

});