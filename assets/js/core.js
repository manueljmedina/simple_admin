function jsonToFormData (inJSON, inTestJSON, inFormData, parentKey) {
    // http://stackoverflow.com/a/22783314/260665
    // Raj: Converts any nested JSON to formData.
    var form_data = inFormData || new FormData();
    var testJSON = inTestJSON || {};
    for ( var key in inJSON ) {
        // 1. If it is a recursion, then key has to be constructed like "parent.child" where parent JSON contains a child JSON
        // 2. Perform append data only if the value for key is not a JSON, recurse otherwise!
        var constructedKey = key;
        if (parentKey) {
            constructedKey = parentKey + "." + key;
        }

        var value = inJSON[key];
        if (value && value.constructor === {}.constructor) {
            // This is a JSON, we now need to recurse!
            jsonToFormData (value, testJSON, form_data, constructedKey);
        } else {
            form_data.append(constructedKey, inJSON[key]);
            testJSON[constructedKey] = inJSON[key];
        }
    }
    return form_data;
}

function enviarAjax(parametros){
    var pg = $.trim($('#controller').val());  

        pg = pg+'.controller.php';
       var mensajeDefault = 'No se ha obtenido una respuesta correcta del servidor, Favor intenta nuevamente...<br>\n\
                                                Si el problema persiste, llama al administrador.';
         $('input').attr('disabled','-1');
         $('.btn').attr('disabled','-1');
	
  
		var testJSON = {};
        var form_data = jsonToFormData (parametros, testJSON);
		
           $.ajax({
				data: ((parametros == '[object FormData]') ? parametros : form_data),
				processData: false,
				contentType: false,
                url:   'app/controllers/'+pg,
                type:  'POST',
                timeout: 300000,
                beforeSend: function () {
					if(pg=='login.controller.php'){
						$('#loginButton').html("Validando credenciales...");
					}else{
						alerover();
					}
					
				},
                success:  function (response){
					$('#loginButton').html("Ingresar");
					console.log(response);
				var IS_JSON = true;//Validar si devuelve json
				try{
					var json		= JSON.parse(response);
					 habilitar();
					 if(json.mensaje){
						 	if(pg=='login.controller.php' && json.respuesta=='reload'){
							$('.alert_login').html(json.mensaje);
								//window.location.reload(true);
								window.location.replace("?page=Dashboard");
							}else{
								$('.alert_login').html(json.mensaje);
							}
						mensajeSistema(json);	
                    }
				}
				 catch(err){
					IS_JSON = false;
					mensajeSistema(mensajeDefault);
					habilitar_nohideBox();
				}  
                                
                }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                     habilitar();
                         mensajeSistema(mensajeDefault);
                         console.log(textStatus);
                         console.log(XMLHttpRequest);
                     }
            });


            event.preventDefault();

    }
	
	function habilitar(){
        bootbox.hideAll();
        jQuery('.btn').removeAttr('disabled');
        jQuery('input').removeAttr('disabled');
        jQuery('select').removeAttr('disabled');
        jQuery('textarea').removeAttr('disabled');
		jQuery('.permDisabled').attr('disabled','-1');
        jQuery(".load").html("");   
    }

    $(document.body).on("submit", ".ajaxform", function(event) {
		 event.preventDefault();
        
		  var formulario = new FormData($("form")[0]);
		 
            enviarAjax(formulario);
           
    });
	
	/* Fin de enviar formularios*/		
function alerover(){
        bootbox.dialog({
        message  : "<center> <h4>Espera un momento mientras se procesa la solicitud realizada</h4><br><img src='assets/img/loading.gif' width='60'></center>",
        closeButton :false
        });  
}

/* Enviar formularios por AJAX*/  
function mensajeSistema(respuesta){
	if(respuesta.mensaje){
		var mensaje = respuesta.mensaje;
	}else{
		var mensaje = respuesta;
	}
	  
        bootbox.alert({ 
            title:'<center> Mensaje del sistema </center>',
            size: 'midium',
            message: mensaje,
            callback: function(){
				if(respuesta.respuesta =='reload'){
				 window.location.reload(true);
				}
				habilitar();
			}
        });
   }
   
   function habilitar_nohideBox(){
        jQuery('.btn').removeAttr('disabled');
        jQuery('input').removeAttr('disabled');
        jQuery('select').removeAttr('disabled');
        jQuery('textarea').removeAttr('disabled');
		jQuery('.permDisabled').attr('disabled','-1');
        jQuery(".load").html("");
   }
   
   $('input').attr('autocomplete','off');