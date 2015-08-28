// JavaScript Document
/*function validaForm(campoNum, form, campoNome) {
		var num;
		for (num=1; num<=campoNum; num++) {
				alert('O campo ' +campoNome+ ' não pode ser vazio.');
				document.form.campoNome.style.backgrounColor = "#CCCCCC";
				form.campoNome.focus();
				return -1;
			}		
	}*/

//#######################################################################################################################################
//############################################COMEÇA FUNCOES DE VALIDACAO DE FORMULARIO#################################################
//#######################################################################################################################################
function valida_form(){
	var argPorCampo=7;//altere somente se for alterar o script abaixo
		//primeiro argumento:
			//é o nome do campo
			//ele tem que ser o nome de um campo do formulario
			//obs.: nao pode ser vazio, se for vazio retornará uma mensagem de erro, parando a execuçao do script
		//segundo argumento
			//é o nome do campo que aparecerá para o usuario na mensagem de erro gerada
			//obs.: nao pode ser vazio, se for vazio retornará uma mensagem de erro, parando a execuçao do script
		//terceiro argumento:
			//ve se o campo pode ser vazio
			//ele pode ser: true (se o campo pode ser vazio), false (se o campo não pode ser vazio)
			//obs.: se ele for vazio, altomaticamnete o valor dele será true
		//quarto argumento:
			//ve se o formato do valor do campo é valido
			//ele pode ser: isNan (somente numeros), isStr (não pode conter números), str (qualquer coisa), isMail (se é email), ninNanX:Y(somente numeros entre X e Y), isFunctionFUNCTION (chama a funcao FUNCTION, não use () no final da funcao, e a funcao tem que retornar true se estiver correta)
			//obs.: se ele for vazio, altomaticamnete o valor dele será str
		//quinto argumento:
			//fala se o valor do campo do argumento 1 tem que ser igual ou diferente do campo que esta contido no proximo argumento
			//ele pode ser: true (tem que ser igual), false (tem que ser diferente), default (pode ser igual ou diferente)
			//obs.: se ele for vazio, altomaticamnete o valor dele será default
		//sexto argumento:
			//é o nome do campo que vai ser validado em relaçao ao argumento 1 (leia mais sobre o argumento anterior)
			//ele tem que ser o nome de um campo do formulario
			//obs.: se o valor do argumento anterior ser vazio ou default, este argumento poderá ser vazio, caso contrario ele deve ser preenchido
		//setimo argumento
			//é o nome do campo do quinto argumento que aparecerá para o usuario na mensagem de erro gerada
			//obs.: nao pode ser vazio, se for vazio retornará uma mensagem de erro, parando a execuçao do script
			
	var msg="";
	var args=valida_form.arguments;
	var maximoFor=((args.length-1)/argPorCampo);
	var form=args[0];
	
	if(maximoFor != parseInt(maximoFor)){//verifica se existe algum erro com os argumentos passados para a funcao
			alert("PARA O ADMINISTRADOR: Erro com os argumentos passados para a função de validação do formulário");
			return false;
	}
	else{
		for(r=0; r<maximoFor; r++){
			tc=parseInt((r*argPorCampo)+1);
			if(args[tc]=="" || args[tc+1]==""){//verifica de outra forma se esta tudo certo com os argumentos passados
				alert("PARA O ADMINISTRADOR: Erro com os argumentos passados para a função de validação do formulário");
				return false;
			}
			validado=new validaArgumentsForValida_form(args[0], args[tc], args[tc+1], args[tc+2], args[tc+3], args[tc+4], args[tc+5], args[tc+6]);
			if(validado.msg!=""){
				alert(validado.msg);
				return false;
			}
			campo=validado.campo;
			exi=validado.exi;
			psv=validado.psv;
			formato=validado.formato;
			igDi=validado.igDi;
			campo2=validado.campo2;
			exi2=validado.exi2;
			if(campo2.toString().substr(0,7)!="[object"){
				msg+=valTipos(campo, exi, psv, formato, igDi, "", "");
			}
			else if(campo2.toString().substr(0,7)=="[object"){
				msg+=valTipos(campo, exi, psv, formato, igDi, pegaValor(campo2), exi2);
			}
		}
	}
	if(msg!=""){
		alert(msg);
	}
	return (msg=="");
}

function validaArgumentsForValida_form(form, _tc, _tc1, _tc2, _tc3, _tc4, _tc5, _tc6){
	this.msg="";
	this.campo=eval("form."+_tc);
	if(this.campo.toString().substr(0,7)!="[object"){
		this.msg="PARA O ADMINISTRADOR: Erro com os argumentos passados para a função de validação do formulário.\nCampo "+_tc+" indefinido";
	}
	this.exi=String(_tc1).toUpperCase();
	if(this.exi==""){
		this.exi=String(_tc).toUpperCase();
	}
	this.psv=String(_tc2);
	this.formato=String(_tc3);
	if(this.formato!="isNan" && this.formato!="isStr" && this.formato!="isMail" && this.formato.substring(0, 6)!="ninNan" && this.formato.substr(0,10)!="isFunction"){
		this.formato="str";
	}
	this.igDi=String(_tc4);
	if(this.igDi!="true" && this.igDi!="false"){
		this.idDi="default";
	}
	this.strCampo=String(_tc5);
	if((this.igDi=="true" || this.igDi=="false") && this.strCampo==""){
		this.msg="PARA O ADMINISTRADOR: Erro com os argumentos passados para a função de validação do formulário.\nArgumento '"+String(_tc5)+"' incorreto";
	}
	this.campo2 = new Object();
	if(this.strCampo!=""){
		this.campo2=eval("form."+this.strCampo);
		if(this.campo2.toString().substr(0,7)!="[object"){
			this.msg="PARA O ADMINISTRADOR: Erro com os argumentos passados para a função de validação do formulário.\nArgumento '"+String(_tc5)+"' incorreto";
		}
	}
	this.exi2=String(_tc6).toUpperCase();
	if(this.exi2==""){
		this.exi2=String(_tc5).toUpperCase();
	}
}
function pegaValor(campo){//retornará um array
	if(campo.toString().substr(0,7)!="[object"){
		return false;
	}
	x=0;
	array = new Array();
	if(campo.type){
		switch(campo.type){
			case "select-one"://se ele entrar aqui, ele caira no case de baixo porque não tem break
			case "select-multiple":
				for(w=0; w<campo.length; w++){
					if(campo[w].selected){
						array[x++]=campo[w].value;
					}
				}
				break;
			case "checkbox":
				if(campo.checked==true){
					array[0] = campo.value;
				}
				break;
			case "textarea"://se ele entrar aqui, ele caira no case de baixo porque não tem break
			case "text"://se ele entrar aqui, ele caira no case de baixo porque não tem break
			case "password"://se ele entrar aqui, ele caira no case de baixo porque não tem break
			case "file"://se ele entrar aqui, ele caira no case de baixo porque não tem break
			case "hidden":
				array[0] = campo.value;
				break;
		}
	}
	else if(campo.length){
		for(q=0; q<campo.length; q++){
			if(campo[q].checked){
				array[0]=campo[q].value;
			}
		}
	}
	if(array.length==0){
		array[0]="";
	}
	return array;
}
function valTipos(campo, exi, psv, formato, igDi, valor2, campo2Name){
	msg = "";
	valorArray = pegaValor(campo);
	for(e=0; e<valorArray.length; e++){
		valor = valorArray[e];
		if(psv=="false" && valor==""){
			msg+="Preencha o campo "+exi+"  .\n";
		}
		else if(psv=="false"|| valor!=""){
			if(formato=="isNan" && isNaN(valor)){//somente numeros
				msg+="Campo "+exi+"  numerico.\n";
			}
			if(formato=="isStr"){//nao pode ter numeros
				for(xFor=0; xFor<valor.length; xFor++){
					if(!isNaN(valor.substr(xFor,1))){
						msg+="Palavras sem espaços\n";
						break;
					}
				}
			}
			if(formato=="isMail"){
				if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valor)==false){
					msg+="O campo "+exi+" tem que ser um email valido.\n";
				}
			}
			if(formato.substr(0, 6)=="ninNan"){
				number=formato.substr(6);
				num=number.split(":");
				if(isNaN(valor)){
					msg+="O campo "+exi+" tem que ser somente n&uacute;meros entre "+ num[0] +" e "+ num[1] +".\n";
				}
				else if(valor < parseInt(num[0]) || valor > parseInt(num[1])){
					msg+="O campo "+exi+" tem que ser somente números entre "+ num[0] +" e "+ num[1] +".\n";
				}
			}
			if(formato.substr(0,10)=="isFunction"){
				if(eval(formato.substr(10)+"('"+ valor +"')")!=true){
					msg+="Preencha o campo "+exi+" corretamente.\n";
				}
			}
			if(igDi=="true" || igDi=="false"){
				if(igDi=="true" && valor!=valor2){
					msg+="O valor do campo "+ exi +" tem que ser igual ao do campo "+ campo2Name.toUpperCase() +".\n";
				}
				else if(igDi=="false" && valor==valor2){
					msg+="O valor do campo "+ exi +" tem que ser diferente ao do campo "+ campo2Name.toUpperCase() +".\n";
				}
			}
		}
		if(msg!=""){
			changeColor(campo, 2);
			return msg;
		}
	}
	if(msg=="") changeColor(campo, 1);
	return msg;
}
function changeColor(input, type){
	if(input.disabled==false)
		if(type==1)
			with(input.style){
				backgroundColor = "#FFFFFF";
				fontSize = "11px";
				//height = "15px";
			}
		else
			with(input.style){
				backgroundColor = "#FFFFFF";
				border = "1px solid #FF0000";
				fontSize = "11px";
				//height = "15px";
			}
}
//#######################################################################################################################################
//############################################TERMINA FUNCOES DE VALIDACAO DE FORMULARIO#################################################
//#######################################################################################################################################




//////////////  FIM do ValidaForm ////////////////////////////////

/*
 * jQuery validation plug-in 1.7
 *
 * http://bassistance.de/jquery-plugins/jquery-plugin-validation/
 * http://docs.jquery.com/Plugins/Validation
 *
 * Copyright (c) 2006 - 2008 Jörn Zaefferer
 *
 * $Id: jquery.validate.js 6403 2009-06-17 14:27:16Z joern.zaefferer $
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

(function($) {

$.extend($.fn, {
	// http://docs.jquery.com/Plugins/Validation/validate
	validate: function( options ) {

		// if nothing is selected, return nothing; can't chain anyway
		if (!this.length) {
			options && options.debug && window.console && console.warn( "nothing selected, can't validate, returning nothing" );
			return;
		}

		// check if a validator for this form was already created
		var validator = $.data(this[0], 'validator');
		if ( validator ) {
			return validator;
		}
		
		validator = new $.validator( options, this[0] );
		$.data(this[0], 'validator', validator); 
		
		if ( validator.settings.onsubmit ) {
		
			// allow suppresing validation by adding a cancel class to the submit button
			this.find("input, button").filter(".cancel").click(function() {
				validator.cancelSubmit = true;
			});
			
			// when a submitHandler is used, capture the submitting button
			if (validator.settings.submitHandler) {
				this.find("input, button").filter(":submit").click(function() {
					validator.submitButton = this;
				});
			}
		
			// validate the form on submit
			this.submit( function( event ) {
				if ( validator.settings.debug )
					// prevent form submit to be able to see console output
					event.preventDefault();
					
				function handle() {
					if ( validator.settings.submitHandler ) {
						if (validator.submitButton) {
							// insert a hidden input as a replacement for the missing submit button
							var hidden = $("<input type='hidden'/>").attr("name", validator.submitButton.name).val(validator.submitButton.value).appendTo(validator.currentForm);
						}
						validator.settings.submitHandler.call( validator, validator.currentForm );
						if (validator.submitButton) {
							// and clean up afterwards; thanks to no-block-scope, hidden can be referenced
							hidden.remove();
						}
						return false;
					}
					return true;
				}
					
				// prevent submit for invalid forms or custom submit handlers
				if ( validator.cancelSubmit ) {
					validator.cancelSubmit = false;
					return handle();
				}
				if ( validator.form() ) {
					if ( validator.pendingRequest ) {
						validator.formSubmitted = true;
						return false;
					}
					return handle();
				} else {
					validator.focusInvalid();
					return false;
				}
			});
		}
		
		return validator;
	},
	// http://docs.jquery.com/Plugins/Validation/valid
	valid: function() {
        if ( $(this[0]).is('form')) {
            return this.validate().form();
        } else {
            var valid = true;
            var validator = $(this[0].form).validate();
            this.each(function() {
				valid &= validator.element(this);
            });
            return valid;
        }
    },
	// attributes: space seperated list of attributes to retrieve and remove
	removeAttrs: function(attributes) {
		var result = {},
			$element = this;
		$.each(attributes.split(/\s/), function(index, value) {
			result[value] = $element.attr(value);
			$element.removeAttr(value);
		});
		return result;
	},
	// http://docs.jquery.com/Plugins/Validation/rules
	rules: function(command, argument) {
		var element = this[0];
		
		if (command) {
			var settings = $.data(element.form, 'validator').settings;
			var staticRules = settings.rules;
			var existingRules = $.validator.staticRules(element);
			switch(command) {
			case "add":
				$.extend(existingRules, $.validator.normalizeRule(argument));
				staticRules[element.name] = existingRules;
				if (argument.messages)
					settings.messages[element.name] = $.extend( settings.messages[element.name], argument.messages );
				break;
			case "remove":
				if (!argument) {
					delete staticRules[element.name];
					return existingRules;
				}
				var filtered = {};
				$.each(argument.split(/\s/), function(index, method) {
					filtered[method] = existingRules[method];
					delete existingRules[method];
				});
				return filtered;
			}
		}
		
		var data = $.validator.normalizeRules(
		$.extend(
			{},
			$.validator.metadataRules(element),
			$.validator.classRules(element),
			$.validator.attributeRules(element),
			$.validator.staticRules(element)
		), element);
		
		// make sure required is at front
		if (data.required) {
			var param = data.required;
			delete data.required;
			data = $.extend({required: param}, data);
		}
		
		return data;
	}
});

// Custom selectors
$.extend($.expr[":"], {
	// http://docs.jquery.com/Plugins/Validation/blank
	blank: function(a) {return !$.trim("" + a.value);},
	// http://docs.jquery.com/Plugins/Validation/filled
	filled: function(a) {return !!$.trim("" + a.value);},
	// http://docs.jquery.com/Plugins/Validation/unchecked
	unchecked: function(a) {return !a.checked;}
});

// constructor for validator
$.validator = function( options, form ) {
	this.settings = $.extend( true, {}, $.validator.defaults, options );
	this.currentForm = form;
	this.init();
};

$.validator.format = function(source, params) {
	if ( arguments.length == 1 ) 
		return function() {
			var args = $.makeArray(arguments);
			args.unshift(source);
			return $.validator.format.apply( this, args );
		};
	if ( arguments.length > 2 && params.constructor != Array  ) {
		params = $.makeArray(arguments).slice(1);
	}
	if ( params.constructor != Array ) {
		params = [ params ];
	}
	$.each(params, function(i, n) {
		source = source.replace(new RegExp("\\{" + i + "\\}", "g"), n);
	});
	return source;
};

$.extend($.validator, {
	
	defaults: {
		messages: {},
		groups: {},
		rules: {},
		errorClass: "error",
		validClass: "valid",
		errorElement: "label",
		focusInvalid: true,
		errorContainer: $( [] ),
		errorLabelContainer: $( [] ),
		onsubmit: true,
		ignore: [],
		ignoreTitle: false,
		onfocusin: function(element) {
			this.lastActive = element;
				
			// hide error label and remove error class on focus if enabled
			if ( this.settings.focusCleanup && !this.blockFocusCleanup ) {
				this.settings.unhighlight && this.settings.unhighlight.call( this, element, this.settings.errorClass, this.settings.validClass );
				this.errorsFor(element).hide();
			}
		},
		onfocusout: function(element) {
			if ( !this.checkable(element) && (element.name in this.submitted || !this.optional(element)) ) {
				this.element(element);
			}
		},
		onkeyup: function(element) {
			if ( element.name in this.submitted || element == this.lastElement ) {
				this.element(element);
			}
		},
		onclick: function(element) {
			// click on selects, radiobuttons and checkboxes
			if ( element.name in this.submitted )
				this.element(element);
			// or option elements, check parent select in that case
			else if (element.parentNode.name in this.submitted)
				this.element(element.parentNode);
		},
		highlight: function( element, errorClass, validClass ) {
			$(element).addClass(errorClass).removeClass(validClass);
		},
		unhighlight: function( element, errorClass, validClass ) {
			$(element).removeClass(errorClass).addClass(validClass);
		}
	},

	// http://docs.jquery.com/Plugins/Validation/Validator/setDefaults
	setDefaults: function(settings) {
		$.extend( $.validator.defaults, settings );
	},

	messages: {
		required: "Campo obrigat&oacute;rio",
		remote: "Erro sess&atilde;o",
		email: "E-mail inv&aacute;lido",
		url: "URL inv&aacute;lida",
		date: "Data inv&aacute;lida",
		dateISO: "Data inv&aacute;lida ",
		number: "Somente n&uacute;meros inteiros",
		digits: "Campo numerico",
		creditcard: "N&uacute;mero do cart&atilde;o inv&aacute;lido",
		equalTo:"Incorreto",
		accept: "Express&atilde;o inv&aacute;lida",
		maxlength: $.validator.format("M&aacute;ximo {0} caracteres"),
		minlength: $.validator.format("M&iacute;nimo{0} caracteres"),
		rangelength: $.validator.format("Entre {0} e {1} caracteres"),
		range: $.validator.format("Valores entre {0} e {1}"),
		max: $.validator.format("Menor ou igual a {0}"),
		min: $.validator.format("Maior ou igual a {0}")
	},
	
	autoCreateRanges: false,
	
	prototype: {
		
		init: function() {
			this.labelContainer = $(this.settings.errorLabelContainer);
			this.errorContext = this.labelContainer.length && this.labelContainer || $(this.currentForm);
			this.containers = $(this.settings.errorContainer).add( this.settings.errorLabelContainer );
			this.submitted = {};
			this.valueCache = {};
			this.pendingRequest = 0;
			this.pending = {};
			this.invalid = {};
			this.reset();
			
			var groups = (this.groups = {});
			$.each(this.settings.groups, function(key, value) {
				$.each(value.split(/\s/), function(index, name) {
					groups[name] = key;
				});
			});
			var rules = this.settings.rules;
			$.each(rules, function(key, value) {
				rules[key] = $.validator.normalizeRule(value);
			});
			
			function delegate(event) {
				var validator = $.data(this[0].form, "validator"),
					eventType = "on" + event.type.replace(/^validate/, "");
				validator.settings[eventType] && validator.settings[eventType].call(validator, this[0] );
			}
			$(this.currentForm)
				.validateDelegate(":text, :password, :file, select, textarea", "focusin focusout keyup", delegate)
				.validateDelegate(":radio, :checkbox, select, option", "click", delegate);

			if (this.settings.invalidHandler)
				$(this.currentForm).bind("invalid-form.validate", this.settings.invalidHandler);
		},

		// http://docs.jquery.com/Plugins/Validation/Validator/form
		form: function() {
			this.checkForm();
			$.extend(this.submitted, this.errorMap);
			this.invalid = $.extend({}, this.errorMap);
			if (!this.valid())
				$(this.currentForm).triggerHandler("invalid-form", [this]);
			this.showErrors();
			return this.valid();
		},
		
		checkForm: function() {
			this.prepareForm();
			for ( var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++ ) {
				this.check( elements[i] );
			}
			return this.valid(); 
		},
		
		// http://docs.jquery.com/Plugins/Validation/Validator/element
		element: function( element ) {
			element = this.clean( element );
			this.lastElement = element;
			this.prepareElement( element );
			this.currentElements = $(element);
			var result = this.check( element );
			if ( result ) {
				delete this.invalid[element.name];
			} else {
				this.invalid[element.name] = true;
			}
			if ( !this.numberOfInvalids() ) {
				// Hide error containers on last error
				this.toHide = this.toHide.add( this.containers );
			}
			this.showErrors();
			return result;
		},

		// http://docs.jquery.com/Plugins/Validation/Validator/showErrors
		showErrors: function(errors) {
			if(errors) {
				// add items to error list and map
				$.extend( this.errorMap, errors );
				this.errorList = [];
				for ( var name in errors ) {
					this.errorList.push({
						message: errors[name],
						element: this.findByName(name)[0]
					});
				}
				// remove items from success list
				this.successList = $.grep( this.successList, function(element) {
					return !(element.name in errors);
				});
			}
			this.settings.showErrors
				? this.settings.showErrors.call( this, this.errorMap, this.errorList )
				: this.defaultShowErrors();
		},
		
		// http://docs.jquery.com/Plugins/Validation/Validator/resetForm
		resetForm: function() {
			if ( $.fn.resetForm )
				$( this.currentForm ).resetForm();
			this.submitted = {};
			this.prepareForm();
			this.hideErrors();
			this.elements().removeClass( this.settings.errorClass );
		},
		
		numberOfInvalids: function() {
			return this.objectLength(this.invalid);
		},
		
		objectLength: function( obj ) {
			var count = 0;
			for ( var i in obj )
				count++;
			return count;
		},
		
		hideErrors: function() {
			this.addWrapper( this.toHide ).hide();
		},
		
		valid: function() {
			return this.size() == 0;
		},
		
		size: function() {
			return this.errorList.length;
		},
		
		focusInvalid: function() {
			if( this.settings.focusInvalid ) {
				try {
					$(this.findLastActive() || this.errorList.length && this.errorList[0].element || [])
					.filter(":visible")
					.focus()
					// manually trigger focusin event; without it, focusin handler isn't called, findLastActive won't have anything to find
					.trigger("focusin");
				} catch(e) {
					// ignore IE throwing errors when focusing hidden elements
				}
			}
		},
		
		findLastActive: function() {
			var lastActive = this.lastActive;
			return lastActive && $.grep(this.errorList, function(n) {
				return n.element.name == lastActive.name;
			}).length == 1 && lastActive;
		},
		
		elements: function() {
			var validator = this,
				rulesCache = {};
			
			// select all valid inputs inside the form (no submit or reset buttons)
			// workaround $Query([]).add until http://dev.jquery.com/ticket/2114 is solved
			return $([]).add(this.currentForm.elements)
			.filter(":input")
			.not(":submit, :reset, :image, [disabled]")
			.not( this.settings.ignore )
			.filter(function() {
				!this.name && validator.settings.debug && window.console && console.error( "%o has no name assigned", this);
			
				// select only the first element for each name, and only those with rules specified
				if ( this.name in rulesCache || !validator.objectLength($(this).rules()) )
					return false;
				
				rulesCache[this.name] = true;
				return true;
			});
		},
		
		clean: function( selector ) {
			return $( selector )[0];
		},
		
		errors: function() {
			return $( this.settings.errorElement + "." + this.settings.errorClass, this.errorContext );
		},
		
		reset: function() {
			this.successList = [];
			this.errorList = [];
			this.errorMap = {};
			this.toShow = $([]);
			this.toHide = $([]);
			this.currentElements = $([]);
		},
		
		prepareForm: function() {
			this.reset();
			this.toHide = this.errors().add( this.containers );
		},
		
		prepareElement: function( element ) {
			this.reset();
			this.toHide = this.errorsFor(element);
		},
	
		check: function( element ) {
			element = this.clean( element );
			
			// if radio/checkbox, validate first element in group instead
			if (this.checkable(element)) {
				element = this.findByName( element.name )[0];
			}
			
			var rules = $(element).rules();
			var dependencyMismatch = false;
			for( method in rules ) {
				var rule = { method: method, parameters: rules[method] };
				try {
					var result = $.validator.methods[method].call( this, element.value.replace(/\r/g, ""), element, rule.parameters );
					
					// if a method indicates that the field is optional and therefore valid,
					// don't mark it as valid when there are no other rules
					if ( result == "dependency-mismatch" ) {
						dependencyMismatch = true;
						continue;
					}
					dependencyMismatch = false;
					
					if ( result == "pending" ) {
						this.toHide = this.toHide.not( this.errorsFor(element) );
						return;
					}
					
					if( !result ) {
						this.formatAndAdd( element, rule );
						return false;
					}
				} catch(e) {
					this.settings.debug && window.console && console.log("exception occured when checking element " + element.id
						 + ", check the '" + rule.method + "' method", e);
					throw e;
				}
			}
			if (dependencyMismatch)
				return;
			if ( this.objectLength(rules) )
				this.successList.push(element);
			return true;
		},
		
		// return the custom message for the given element and validation method
		// specified in the element's "messages" metadata
		customMetaMessage: function(element, method) {
			if (!$.metadata)
				return;
			
			var meta = this.settings.meta
				? $(element).metadata()[this.settings.meta]
				: $(element).metadata();
			
			return meta && meta.messages && meta.messages[method];
		},
		
		// return the custom message for the given element name and validation method
		customMessage: function( name, method ) {
			var m = this.settings.messages[name];
			return m && (m.constructor == String
				? m
				: m[method]);
		},
		
		// return the first defined argument, allowing empty strings
		findDefined: function() {
			for(var i = 0; i < arguments.length; i++) {
				if (arguments[i] !== undefined)
					return arguments[i];
			}
			return undefined;
		},
		
		defaultMessage: function( element, method) {
			return this.findDefined(
				this.customMessage( element.name, method ),
				this.customMetaMessage( element, method ),
				// title is never undefined, so handle empty string as undefined
				!this.settings.ignoreTitle && element.title || undefined,
				$.validator.messages[method],
				"<strong>Warning: No message defined for " + element.name + "</strong>"
			);
		},
		
		formatAndAdd: function( element, rule ) {
			var message = this.defaultMessage( element, rule.method ),
				theregex = /\$?\{(\d+)\}/g;
			if ( typeof message == "function" ) {
				message = message.call(this, rule.parameters, element);
			} else if (theregex.test(message)) {
				message = jQuery.format(message.replace(theregex, '{$1}'), rule.parameters);
			}			
			this.errorList.push({
				message: message,
				element: element
			});
			
			this.errorMap[element.name] = message;
			this.submitted[element.name] = message;
		},
		
		addWrapper: function(toToggle) {
			if ( this.settings.wrapper )
				toToggle = toToggle.add( toToggle.parent( this.settings.wrapper ) );
			return toToggle;
		},
		
		defaultShowErrors: function() {
			for ( var i = 0; this.errorList[i]; i++ ) {
				var error = this.errorList[i];
				this.settings.highlight && this.settings.highlight.call( this, error.element, this.settings.errorClass, this.settings.validClass );
				this.showLabel( error.element, error.message );
			}
			if( this.errorList.length ) {
				this.toShow = this.toShow.add( this.containers );
			}
			if (this.settings.success) {
				for ( var i = 0; this.successList[i]; i++ ) {
					this.showLabel( this.successList[i] );
				}
			}
			if (this.settings.unhighlight) {
				for ( var i = 0, elements = this.validElements(); elements[i]; i++ ) {
					this.settings.unhighlight.call( this, elements[i], this.settings.errorClass, this.settings.validClass );
				}
			}
			this.toHide = this.toHide.not( this.toShow );
			this.hideErrors();
			this.addWrapper( this.toShow ).show();
		},
		
		validElements: function() {
			return this.currentElements.not(this.invalidElements());
		},
		
		invalidElements: function() {
			return $(this.errorList).map(function() {
				return this.element;
			});
		},
		
		showLabel: function(element, message) {
			var label = this.errorsFor( element );
			if ( label.length ) {
				// refresh error/success class
				label.removeClass().addClass( this.settings.errorClass );
			
				// check if we have a generated label, replace the message then
				label.attr("generated") && label.html(message);
			} else {
				// create label
				label = $("<" + this.settings.errorElement + "/>")
					.attr({"for":  this.idOrName(element), generated: true})
					.addClass(this.settings.errorClass)
					.html(message || "");
				if ( this.settings.wrapper ) {
					// make sure the element is visible, even in IE
					// actually showing the wrapped element is handled elsewhere
					label = label.hide().show().wrap("<" + this.settings.wrapper + "/>").parent();
				}
				if ( !this.labelContainer.append(label).length )
					this.settings.errorPlacement
						? this.settings.errorPlacement(label, $(element) )
						: label.insertAfter(element);
			}
			if ( !message && this.settings.success ) {
				label.text("");
				typeof this.settings.success == "string"
					? label.addClass( this.settings.success )
					: this.settings.success( label );
			}
			this.toShow = this.toShow.add(label);
		},
		
		errorsFor: function(element) {
			var name = this.idOrName(element);
    		return this.errors().filter(function() {
				return $(this).attr('for') == name;
			});
		},
		
		idOrName: function(element) {
			return this.groups[element.name] || (this.checkable(element) ? element.name : element.id || element.name);
		},

		checkable: function( element ) {
			return /radio|checkbox/i.test(element.type);
		},
		
		findByName: function( name ) {
			// select by name and filter by form for performance over form.find("[name=...]")
			var form = this.currentForm;
			return $(document.getElementsByName(name)).map(function(index, element) {
				return element.form == form && element.name == name && element  || null;
			});
		},
		
		getLength: function(value, element) {
			switch( element.nodeName.toLowerCase() ) {
			case 'select':
				return $("option:selected", element).length;
			case 'input':
				if( this.checkable( element) )
					return this.findByName(element.name).filter(':checked').length;
			}
			return value.length;
		},
	
		depend: function(param, element) {
			return this.dependTypes[typeof param]
				? this.dependTypes[typeof param](param, element)
				: true;
		},
	
		dependTypes: {
			"boolean": function(param, element) {
				return param;
			},
			"string": function(param, element) {
				return !!$(param, element.form).length;
			},
			"function": function(param, element) {
				return param(element);
			}
		},
		
		optional: function(element) {
			return !$.validator.methods.required.call(this, $.trim(element.value), element) && "dependency-mismatch";
		},
		
		startRequest: function(element) {
			if (!this.pending[element.name]) {
				this.pendingRequest++;
				this.pending[element.name] = true;
			}
		},
		
		stopRequest: function(element, valid) {
			this.pendingRequest--;
			// sometimes synchronization fails, make sure pendingRequest is never < 0
			if (this.pendingRequest < 0)
				this.pendingRequest = 0;
			delete this.pending[element.name];
			if ( valid && this.pendingRequest == 0 && this.formSubmitted && this.form() ) {
				$(this.currentForm).submit();
				this.formSubmitted = false;
			} else if (!valid && this.pendingRequest == 0 && this.formSubmitted) {
				$(this.currentForm).triggerHandler("invalid-form", [this]);
				this.formSubmitted = false;
			}
		},
		
		previousValue: function(element) {
			return $.data(element, "previousValue") || $.data(element, "previousValue", {
				old: null,
				valid: true,
				message: this.defaultMessage( element, "remote" )
			});
		}
		
	},
	
	classRuleSettings: {
		required: {required: true},
		email: {email: true},
		url: {url: true},
		date: {date: true},
		dateISO: {dateISO: true},
		dateDE: {dateDE: true},
		number: {number: true},
		numberDE: {numberDE: true},
		digits: {digits: true},
		creditcard: {creditcard: true}
	},
	
	addClassRules: function(className, rules) {
		className.constructor == String ?
			this.classRuleSettings[className] = rules :
			$.extend(this.classRuleSettings, className);
	},
	
	classRules: function(element) {
		var rules = {};
		var classes = $(element).attr('class');
		classes && $.each(classes.split(' '), function() {
			if (this in $.validator.classRuleSettings) {
				$.extend(rules, $.validator.classRuleSettings[this]);
			}
		});
		return rules;
	},
	
	attributeRules: function(element) {
		var rules = {};
		var $element = $(element);
		
		for (method in $.validator.methods) {
			var value = $element.attr(method);
			if (value) {
				rules[method] = value;
			}
		}
		
		// maxlength may be returned as -1, 2147483647 (IE) and 524288 (safari) for text inputs
		if (rules.maxlength && /-1|2147483647|524288/.test(rules.maxlength)) {
			delete rules.maxlength;
		}
		
		return rules;
	},
	
	metadataRules: function(element) {
		if (!$.metadata) return {};
		
		var meta = $.data(element.form, 'validator').settings.meta;
		return meta ?
			$(element).metadata()[meta] :
			$(element).metadata();
	},
	
	staticRules: function(element) {
		var rules = {};
		var validator = $.data(element.form, 'validator');
		if (validator.settings.rules) {
			rules = $.validator.normalizeRule(validator.settings.rules[element.name]) || {};
		}
		return rules;
	},
	
	normalizeRules: function(rules, element) {
		// handle dependency check
		$.each(rules, function(prop, val) {
			// ignore rule when param is explicitly false, eg. required:false
			if (val === false) {
				delete rules[prop];
				return;
			}
			if (val.param || val.depends) {
				var keepRule = true;
				switch (typeof val.depends) {
					case "string":
						keepRule = !!$(val.depends, element.form).length;
						break;
					case "function":
						keepRule = val.depends.call(element, element);
						break;
				}
				if (keepRule) {
					rules[prop] = val.param !== undefined ? val.param : true;
				} else {
					delete rules[prop];
				}
			}
		});
		
		// evaluate parameters
		$.each(rules, function(rule, parameter) {
			rules[rule] = $.isFunction(parameter) ? parameter(element) : parameter;
		});
		
		// clean number parameters
		$.each(['minlength', 'maxlength', 'min', 'max'], function() {
			if (rules[this]) {
				rules[this] = Number(rules[this]);
			}
		});
		$.each(['rangelength', 'range'], function() {
			if (rules[this]) {
				rules[this] = [Number(rules[this][0]), Number(rules[this][1])];
			}
		});
		
		if ($.validator.autoCreateRanges) {
			// auto-create ranges
			if (rules.min && rules.max) {
				rules.range = [rules.min, rules.max];
				delete rules.min;
				delete rules.max;
			}
			if (rules.minlength && rules.maxlength) {
				rules.rangelength = [rules.minlength, rules.maxlength];
				delete rules.minlength;
				delete rules.maxlength;
			}
		}
		
		// To support custom messages in metadata ignore rule methods titled "messages"
		if (rules.messages) {
			delete rules.messages;
		}
		
		return rules;
	},
	
	// Converts a simple string to a {string: true} rule, e.g., "required" to {required:true}
	normalizeRule: function(data) {
		if( typeof data == "string" ) {
			var transformed = {};
			$.each(data.split(/\s/), function() {
				transformed[this] = true;
			});
			data = transformed;
		}
		return data;
	},
	
	// http://docs.jquery.com/Plugins/Validation/Validator/addMethod
	addMethod: function(name, method, message) {
		$.validator.methods[name] = method;
		$.validator.messages[name] = message != undefined ? message : $.validator.messages[name];
		if (method.length < 3) {
			$.validator.addClassRules(name, $.validator.normalizeRule(name));
		}
	},

	methods: {

		// http://docs.jquery.com/Plugins/Validation/Methods/required
		required: function(value, element, param) {
			// check if dependency is met
			if ( !this.depend(param, element) )
				return "dependency-mismatch";
			switch( element.nodeName.toLowerCase() ) {
			case 'select':
				// could be an array for select-multiple or a string, both are fine this way
				var val = $(element).val();
				return val && val.length > 0;
			case 'input':
				if ( this.checkable(element) )
					return this.getLength(value, element) > 0;
			default:
				return $.trim(value).length > 0;
			}
		},
		
		// http://docs.jquery.com/Plugins/Validation/Methods/remote
		remote: function(value, element, param) {
			if ( this.optional(element) )
				return "dependency-mismatch";
			
			var previous = this.previousValue(element);
			if (!this.settings.messages[element.name] )
				this.settings.messages[element.name] = {};
			previous.originalMessage = this.settings.messages[element.name].remote;
			this.settings.messages[element.name].remote = previous.message;
			
			param = typeof param == "string" && {url:param} || param; 
			
			if ( previous.old !== value ) {
				previous.old = value;
				var validator = this;
				this.startRequest(element);
				var data = {};
				data[element.name] = value;
				$.ajax($.extend(true, {
					url: param,
					mode: "abort",
					port: "validate" + element.name,
					dataType: "json",
					data: data,
					success: function(response) {
						validator.settings.messages[element.name].remote = previous.originalMessage;
						var valid = response === true;
						if ( valid ) {
							var submitted = validator.formSubmitted;
							validator.prepareElement(element);
							validator.formSubmitted = submitted;
							validator.successList.push(element);
							validator.showErrors();
						} else {
							var errors = {};
							var message = (previous.message = response || validator.defaultMessage( element, "remote" ));
							errors[element.name] = $.isFunction(message) ? message(value) : message;
							validator.showErrors(errors);
						}
						previous.valid = valid;
						validator.stopRequest(element, valid);
					}
				}, param));
				return "pending";
			} else if( this.pending[element.name] ) {
				return "pending";
			}
			return previous.valid;
		},

		// http://docs.jquery.com/Plugins/Validation/Methods/minlength
		minlength: function(value, element, param) {
			return this.optional(element) || this.getLength($.trim(value), element) >= param;
		},
		
		// http://docs.jquery.com/Plugins/Validation/Methods/maxlength
		maxlength: function(value, element, param) {
			return this.optional(element) || this.getLength($.trim(value), element) <= param;
		},
		
		// http://docs.jquery.com/Plugins/Validation/Methods/rangelength
		rangelength: function(value, element, param) {
			var length = this.getLength($.trim(value), element);
			return this.optional(element) || ( length >= param[0] && length <= param[1] );
		},
		
		// http://docs.jquery.com/Plugins/Validation/Methods/min
		min: function( value, element, param ) {
			return this.optional(element) || value >= param;
		},
		
		// http://docs.jquery.com/Plugins/Validation/Methods/max
		max: function( value, element, param ) {
			return this.optional(element) || value <= param;
		},
		
		// http://docs.jquery.com/Plugins/Validation/Methods/range
		range: function( value, element, param ) {
			return this.optional(element) || ( value >= param[0] && value <= param[1] );
		},
		
		// http://docs.jquery.com/Plugins/Validation/Methods/email
		email: function(value, element) {
			// contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
			return this.optional(element) || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(value);
		},
	
		// http://docs.jquery.com/Plugins/Validation/Methods/url
		url: function(value, element) {
			// contributed by Scott Gonzalez: http://projects.scottsplayground.com/iri/
			return this.optional(element) || /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
		},
        
		// http://docs.jquery.com/Plugins/Validation/Methods/date
		date: function(value, element) {
			return this.optional(element) || !/Invalid|NaN/.test(new Date(value));
		},
	
		// http://docs.jquery.com/Plugins/Validation/Methods/dateISO
		dateISO: function(value, element) {
			return this.optional(element) || /^((0?[1-9]|[12]\d)\/(0?[1-9]|1[0-2])|30\/(0?[13-9]|1[0-2])|31\/(0?[13578]|1[02]))\/(19|20)?\d{2}$/.test(value);
		},
	
		// http://docs.jquery.com/Plugins/Validation/Methods/number
		number: function(value, element) {
			return this.optional(element) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);
		},
	
		// http://docs.jquery.com/Plugins/Validation/Methods/digits
		digits: function(value, element) {
			return this.optional(element) || /^\d+$/.test(value);
		},
		
		// http://docs.jquery.com/Plugins/Validation/Methods/creditcard
		// based on http://en.wikipedia.org/wiki/Luhn
		creditcard: function(value, element) {
			if ( this.optional(element) )
				return "dependency-mismatch";
			// accept only digits and dashes
			if (/[^0-9-]+/.test(value))
				return false;
			var nCheck = 0,
				nDigit = 0,
				bEven = false;

			value = value.replace(/\D/g, "");

			for (var n = value.length - 1; n >= 0; n--) {
				var cDigit = value.charAt(n);
				var nDigit = parseInt(cDigit, 10);
				if (bEven) {
					if ((nDigit *= 2) > 9)
						nDigit -= 9;
				}
				nCheck += nDigit;
				bEven = !bEven;
			}

			return (nCheck % 10) == 0;
		},
		
		// http://docs.jquery.com/Plugins/Validation/Methods/accept
		accept: function(value, element, param) {
			param = typeof param == "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
			return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i")); 
		},
		
		// http://docs.jquery.com/Plugins/Validation/Methods/equalTo
		equalTo: function(value, element, param) {
			// bind to the blur event of the target in order to revalidate whenever the target field is updated
			// TODO find a way to bind the event just once, avoiding the unbind-rebind overhead
			var target = $(param).unbind(".validate-equalTo").bind("blur.validate-equalTo", function() {
				$(element).valid();
			});
			return value == target.val();
		}
		
	}
	
});

// deprecated, use $.validator.format instead
$.format = $.validator.format;

})(jQuery);

// ajax mode: abort
// usage: $.ajax({ mode: "abort"[, port: "uniqueport"]});
// if mode:"abort" is used, the previous request on that port (port can be undefined) is aborted via XMLHttpRequest.abort() 
;(function($) {
	var ajax = $.ajax;
	var pendingRequests = {};
	$.ajax = function(settings) {
		// create settings for compatibility with ajaxSetup
		settings = $.extend(settings, $.extend({}, $.ajaxSettings, settings));
		var port = settings.port;
		if (settings.mode == "abort") {
			if ( pendingRequests[port] ) {
				pendingRequests[port].abort();
			}
			return (pendingRequests[port] = ajax.apply(this, arguments));
		}
		return ajax.apply(this, arguments);
	};
})(jQuery);

// provides cross-browser focusin and focusout events
// IE has native support, in other browsers, use event caputuring (neither bubbles)

// provides delegate(type: String, delegate: Selector, handler: Callback) plugin for easier event delegation
// handler is only called when $(event.target).is(delegate), in the scope of the jquery-object for event.target 
;(function($) {
	// only implement if not provided by jQuery core (since 1.4)
	// TODO verify if jQuery 1.4's implementation is compatible with older jQuery special-event APIs
	if (!jQuery.event.special.focusin && !jQuery.event.special.focusout && document.addEventListener) {
		$.each({
			focus: 'focusin',
			blur: 'focusout'	
		}, function( original, fix ){
			$.event.special[fix] = {
				setup:function() {
					this.addEventListener( original, handler, true );
				},
				teardown:function() {
					this.removeEventListener( original, handler, true );
				},
				handler: function(e) {
					arguments[0] = $.event.fix(e);
					arguments[0].type = fix;
					return $.event.handle.apply(this, arguments);
				}
			};
			function handler(e) {
				e = $.event.fix(e);
				e.type = fix;
				return $.event.handle.call(this, e);
			}
		});
	};
	$.extend($.fn, {
		validateDelegate: function(delegate, type, handler) {
			return this.bind(type, function(event) {
				var target = $(event.target);
				if (target.is(delegate)) {
					return handler.apply(target, arguments);
				}
			});
		}
	});
})(jQuery);


jQuery.validator.addMethod("cpf", function(value, element) {
   value = jQuery.trim(value);
	
	value = value.replace('.','');
	value = value.replace('.','');
	cpf = value.replace('-','');
	while(cpf.length < 11) cpf = "0"+ cpf;
	var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
	var a = [];
	var b = new Number;
	var c = 11;
	for (i=0; i<11; i++){
		a[i] = cpf.charAt(i);
		if (i < 9) b += (a[i] * --c);
	}
	if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
	b = 0;
	c = 11;
	for (y=0; y<10; y++) b += (a[y] * c--);
	if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
	if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
	return true;
}, "Informe um CPF válido."); // Mensagem padrão 

jQuery.validator.addMethod("dateBR", function(value, element) {
	 //contando chars
	if(value.length!=10) return false;
	// verificando data
	var data 		= value;
	var dia 		= data.substr(0,2);
	var barra1		= data.substr(2,1);
	var mes 		= data.substr(3,2);
	var barra2		= data.substr(5,1);
	var ano 		= data.substr(6,4);
	if(data.length!=10||barra1!="/"||barra2!="/"||isNaN(dia)||isNaN(mes)||isNaN(ano)||dia>31||mes>12)return false;
	if((mes==4||mes==6||mes==9||mes==11) && dia==31)return false;
	if(mes==2  &&  (dia>29||(dia==29 && ano%4!=0)))return false;
	if(ano < 1900 && ano > 2100)return false;
	return true;
}, "Invalida ");  // Mensagem padrão 



/*
 *
 * NOVO METODO PARA O JQUERY VALIDATE
 * VALIDA CNPJ COM 14 OU 15 DIGITOS
 * A VALIDAÇÃO É FEITA COM OU SEM OS CARACTERES SEPARADORES, PONTO, HIFEN, BARRA
 *
 * ESTE MÉTODO FOI ADAPTADO POR:
 * 
 * Shiguenori Suguiura Junior <junior@dothcom.net>
 * 
 * http://blog.shiguenori.com
 * http://www.dothcom.net
 * 
 */
jQuery.validator.addMethod("cnpj", function(cnpj, element) {
   cnpj = jQuery.trim(cnpj);
	
	// DEIXA APENAS OS NÚMEROS
   cnpj = cnpj.replace('/','');
   cnpj = cnpj.replace('.','');
   cnpj = cnpj.replace('.','');
   cnpj = cnpj.replace('-','');

   var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
   digitos_iguais = 1;

   if (cnpj.length < 14 && cnpj.length < 15){
      return false;
   }
   for (i = 0; i < cnpj.length - 1; i++){
      if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
         digitos_iguais = 0;
         break;
      }
   }

   if (!digitos_iguais){
      tamanho = cnpj.length - 2
      numeros = cnpj.substring(0,tamanho);
      digitos = cnpj.substring(tamanho);
      soma = 0;
      pos = tamanho - 7;

      for (i = tamanho; i >= 1; i--){
         soma += numeros.charAt(tamanho - i) * pos--;
         if (pos < 2){
            pos = 9;
         }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(0)){
         return false;
      }
      tamanho = tamanho + 1;
      numeros = cnpj.substring(0,tamanho);
      soma = 0;
      pos = tamanho - 7;
      for (i = tamanho; i >= 1; i--){
         soma += numeros.charAt(tamanho - i) * pos--;
         if (pos < 2){
            pos = 9;
         }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(1)){
         return false;
      }
      return true;
   }else{
      return false;
   }
}, "Informe um CNPJ válido."); // Mensagem padrão 

jQuery.validator.addMethod("notEqual", function(value, element, param) {
   return value == $(param).val() ? false : true;
}, "Este valor não pode ser igual"); // Mensagem padrão 

jQuery.validator.addMethod("diferenteDe", function(value, element, strCompara) {
   return value == strCompara ? false : true;
}, "Este valor não foi alterado"); // Mensagem padrão 

//onKeyPress="return formata(this, '###.###.###-##', event)"

function formata(objeto, mask, evt) {
 
var LetrasU = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var LetrasL = 'abcdefghijklmnopqrstuvwxyz';
var Letras  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
var Numeros = '0123456789';
var Fixos  = '().-:/ ';
var Charset = " !\"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_/`abcdefghijklmnopqrstuvwxyz{|}~";

evt = (evt) ? evt : (window.event) ? window.event : "";
var value = objeto.value;
if (evt) {
 var ntecla = (evt.which) ? evt.which : evt.keyCode;
  tecla = Charset.substr(ntecla - 32, 1);
 if (ntecla < 32) return true;

 var tamanho = value.length;
 if (tamanho >= mask.length) return false;

 var pos = mask.substr(tamanho,1);
 while (Fixos.indexOf(pos) != -1) {
  value += pos;
  tamanho = value.length;
  if (tamanho >= mask.length) return false;
  pos = mask.substr(tamanho,1);
 }

 switch (pos) {
   case '#' : if (Numeros.indexOf(tecla) == -1) return false; break;
   case 'A' : if (LetrasU.indexOf(tecla) == -1) return false; break;
   case 'a' : if (LetrasL.indexOf(tecla) == -1) return false; break;
   case 'Z' : if (Letras.indexOf(tecla) == -1) return false; break;
   case '*' : objeto.value = value; return true; break;
   default : return false; break;
 }
}
objeto.value = value;
return true;
}


   function numeros()
	 {
	 	if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;
	 }
	 
	  function letras()
	 {
	 	if (event.keyCode < 45 || event.keyCode > 57) {event.returnValue = true}else{ event.returnValue = false};
	 }

//adiciona metodo ao validate para verificar tamanho
jQuery.validator.addMethod("verificaTamanho", function(value, element) {
  return value.length == 14 || value.length == 18;
}, jQuery.format("Informe 14 ou 18 digitos"));

/*function cnpj_cpf verifica qual das funcoes tem que chamar cpf ou cnpj*/
	 function cnpj_cpf(campo,documento,f,formi)
	 {
      form = formi;

      for (Count = 0; Count < 2; Count++)
			{
         if (form.rad[Count].checked)
            break;
			}
      if (Count == 0)
			{
				mascara_cpf (campo,documento,f);
				jQuery.validator.addMethod("Tamanho", function(value, element) {
   return value.length == 14 ;
}, jQuery.format("Informe 14 digitos"));
				}else{
        mascara_cnpj (campo,documento,f);
				jQuery.validator.addMethod("Tamanho", function(value, element) {
   return value.length == 18;
}, jQuery.format("Informe 18 digitos"));
      }
   }

   function mascara_cnpj (campo,documento,f)
	 {
      var mydata = '';
      mydata = mydata + documento;

      if (mydata.length == 2)
			{
         mydata   = mydata + '.';

         ct_campo = eval("document."+f+"."+campo+".value = mydata");
         ct_campo;
      }

      if (mydata.length == 6)
			{
               mydata   = mydata + '.';

               ct_campo = eval("document."+f+"."+campo+".value = mydata");
               ct_campo;
      }

      if (mydata.length == 10)
			{
         mydata      = mydata + '/';

         ct_campo1 = eval("document."+f+"."+campo+".value = mydata");
         ct_campo1;
      }

      if (mydata.length == 15){
               mydata      = mydata + '-';

               ct_campo1 = eval("document."+f+"."+campo+".value = mydata");
               ct_campo1;
      }

      if (mydata.length == 18 )
			{

         valida_cnpj(f,campo);
      }
   }

   function mascara_cpf (campo,documento,f){
         var mydata = '';
         mydata = mydata + documento;

         if (mydata.length == 3){
            mydata   = mydata + '.';

            ct_campo = eval("document."+f+"."+campo+".value = mydata");
            ct_campo;
         }

         if (mydata.length == 7){
                  mydata   = mydata + '.';

                  ct_campo = eval("document."+f+"."+campo+".value = mydata");
                  ct_campo;
         }

         if (mydata.length == 11){
            mydata      = mydata + '-';

            ct_campo1 = eval("document."+f+"."+campo+".value = mydata");
            ct_campo1;
         }

         if (mydata.length == 14 ){

            valida_cpf(f,campo);
						
         }

   }

   function valida_cnpj(f,campo){
         pri = eval("document."+f+"."+campo+".value.substring(0,2)");
         seg = eval("document."+f+"."+campo+".value.substring(3,6)");
         ter = eval("document."+f+"."+campo+".value.substring(7,10)");
         qua = eval("document."+f+"."+campo+".value.substring(11,15)");
         qui = eval("document."+f+"."+campo+".value.substring(16,18)");

         var i;
         var numero;
         var situacao = '';

         numero = (pri+seg+ter+qua+qui);

         s = numero;

         c = s.substr(0,12);
         var dv = s.substr(12,2);
         var d1 = 0;

         for (i = 0; i < 12; i++){
            d1 += c.charAt(11-i)*(2+(i % 8));
         }

         if (d1 == 0){
            var result = "falso";
         }
            d1 = 11 - (d1 % 11);

         if (d1 > 9) d1 = 0;

            if (dv.charAt(0) != d1){
               var result = "falso";
            }

         d1 *= 2;
         for (i = 0; i < 12; i++){
            d1 += c.charAt(11-i)*(2+((i+1) % 8));
         }

         d1 = 11 - (d1 % 11);
         if (d1 > 9) d1 = 0;

            if (dv.charAt(1) != d1){
               var result = "falso";
            }


         if (result == "falso") {
          
 
						alert("CNPJ invalido!");
            aux1 = eval("document."+f+"."+campo+".focus");
            aux2 = eval("document."+f+"."+campo+".value = ''");

         }
   }

   function valida_cpf(f,campo){
         pri = eval("document."+f+"."+campo+".value.substring(0,3)");
         seg = eval("document."+f+"."+campo+".value.substring(4,7)");
         ter = eval("document."+f+"."+campo+".value.substring(8,11)");
         qua = eval("document."+f+"."+campo+".value.substring(12,14)");

         var i;
         var numero;

         numero = (pri+seg+ter+qua);

         s = numero;
         c = s.substr(0,9);
         var dv = s.substr(9,2);
         var d1 = 0;

         for (i = 0; i < 9; i++){
            d1 += c.charAt(i)*(10-i);
         }

         if (d1 == 0){
            var result = "falso";
         }

         d1 = 11 - (d1 % 11);
         if (d1 > 9) d1 = 0;

         if (dv.charAt(0) != d1){
            var result = "falso";
         }

         d1 *= 2;
         for (i = 0; i < 9; i++){
            d1 += c.charAt(i)*(11-i);
         }

         d1 = 11 - (d1 % 11);
         if (d1 > 9) d1 = 0;

         if (dv.charAt(1) != d1){
            var result = "falso";
         }

         if (result == "falso") {
            alert("CPF invalido!");
            aux1 = eval("document."+f+"."+campo+".focus");
            aux2 = eval("document."+f+"."+campo+".value = ''");

         }
   }

// JavaScript Document

/*
* @Copyright (c) 2011 Aurélio Saraiva, Diego Plentz
* @Page http://github.com/plentz/jquery-maskmoney
* try at http://plentz.org/maskmoney

* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
*/

/*
* @Version: 1.3
* @Release: 2011-04-20
*/
(function($) {
	$.fn.maskMoney = function(settings) {
		settings = $.extend({
			symbol: 'US$',
			showSymbol: false,
			symbolStay: false,
			thousands: ',',
			decimal: '.',
			precision: 2,
			defaultZero: true,
			allowZero: false,
			allowNegative: false
		}, settings);

		return this.each(function() {
			var input = $(this);

			function keypressEvent(e) {
				e = e||window.event;
				var k = e.charCode||e.keyCode||e.which;
				if (k == undefined) return false; //needed to handle an IE "special" event
				if (input.attr('readonly') && (k!=13&&k!=9)) return false; // don't allow editing of readonly fields but allow tab/enter

				if (k<48||k>57) { // any key except the numbers 0-9
					if (k==45) { // -(minus) key
						input.val(changeSign(input));
						return false;
					}
					if (k==43) { // +(plus) key
						input.val(input.val().replace('-',''));
						return false;
					} else if (k==13||k==9) { // enter key or tab key
						return true;
					} else if (k==37||k==39) { // left arrow key or right arrow key
						return true;
					} else { // any other key with keycode less than 48 and greater than 57
						preventDefault(e);
						return true;
					}
				} else if (input.val().length==input.attr('maxlength')) {
					return false;
				} else {
					preventDefault(e);

					var key = String.fromCharCode(k);
					var x = input.get(0);
					var selection = input.getInputSelection(x);
					var startPos = selection.start;
					var endPos = selection.end;
					x.value = x.value.substring(0, startPos) + key + x.value.substring(endPos, x.value.length);
					maskAndPosition(x, startPos + 1);
					return false;
				}
			}

			function keydownEvent(e) {
				e = e||window.event;
				var k = e.charCode||e.keyCode||e.which;
				if (k == undefined) return false; //needed to handle an IE "special" event
				if (input.attr('readonly') && (k!=13&&k!=9)) return false; // don't allow editing of readonly fields but allow tab/enter

				var x = input.get(0);
				var selection = input.getInputSelection(x);
				var startPos = selection.start;
				var endPos = selection.end;

				if (k==8) { // backspace key
					preventDefault(e);

					if(startPos == endPos){
						// Remove single character
						x.value = x.value.substring(0, startPos - 1) + x.value.substring(endPos, x.value.length);
						startPos = startPos - 1;
					} else {
						// Remove multiple characters
						x.value = x.value.substring(0, startPos) + x.value.substring(endPos, x.value.length);
					}
					maskAndPosition(x, startPos);
					return false;
				} else if (k==9) { // tab key
					return true;
				} else if (k==46||k==63272) { // delete key (with special case for safari)
					preventDefault(e);
					if(x.selectionStart == x.selectionEnd){
						// Remove single character
						x.value = x.value.substring(0, startPos) + x.value.substring(endPos + 1, x.value.length);
					} else {
						//Remove multiple characters
						x.value = x.value.substring(0, startPos) + x.value.substring(endPos, x.value.length);
					}
					maskAndPosition(x, startPos);
					return false;
				} else { // any other key
					return true;
				}
			}

			function focusEvent(e) {
				var mask = getDefaultMask();
				if (input.val()==mask) {
					input.val('');
				} else if (input.val()==''&&settings.defaultZero) {
					input.val(setSymbol(mask));
				} else {
					input.val(setSymbol(input.val()));
				}
				if (this.createTextRange) {
					var textRange = this.createTextRange();
					textRange.collapse(false); // set the cursor at the end of the input
					textRange.select();
				}
			}

			function blurEvent(e) {
				if ($.browser.msie) {
					keypressEvent(e);
				}

				if (input.val()==''||input.val()==setSymbol(getDefaultMask())||input.val()==settings.symbol) {
					if(!settings.allowZero) input.val('');
					else if (!settings.symbolStay) input.val(getDefaultMask());
					else input.val(setSymbol(getDefaultMask()));
				} else {
					if (!settings.symbolStay) input.val(input.val().replace(settings.symbol,''));
					else if (settings.symbolStay&&input.val()==settings.symbol) input.val(setSymbol(getDefaultMask()));
				}
			}

			function preventDefault(e) {
				if (e.preventDefault) { //standard browsers
					e.preventDefault();
				} else { // internet explorer
					e.returnValue = false
				}
			}

			function maskAndPosition(x, startPos) {
				var originalLen = input.val().length;
				input.val(maskValue(x.value));
				var newLen = input.val().length;
				startPos = startPos - (originalLen - newLen);
				input.setCursorPosition(startPos);
			}

			function maskValue(v) {
				v = v.replace(settings.symbol,'');

				var strCheck = '0123456789';
				var len = v.length;
				var a = '', t = '', neg='';

				if(len!=0 && v.charAt(0)=='-'){
					v = v.replace('-','');
					if(settings.allowNegative){
						neg = '-';
					}
				}

				if (len==0) {
					if (!settings.defaultZero) return t;
					t = '0.00';
				}

				for (var i = 0; i<len; i++) {
					if ((v.charAt(i)!='0') && (v.charAt(i)!=settings.decimal)) break;
				}

				for (; i<len; i++) {
					if (strCheck.indexOf(v.charAt(i))!=-1) a+= v.charAt(i);
				}

				var n = parseFloat(a);
				n = isNaN(n) ? 0 : n/Math.pow(10,settings.precision);
				t = n.toFixed(settings.precision);

				i = settings.precision == 0 ? 0 : 1;
				var p, d = (t=t.split('.'))[i].substr(0,settings.precision);
				for (p = (t=t[0]).length; (p-=3)>=1;) {
					t = t.substr(0,p)+settings.thousands+t.substr(p);
				}

				return (settings.precision>0)
					? setSymbol(neg+t+settings.decimal+d+Array((settings.precision+1)-d.length).join(0))
					: setSymbol(neg+t);
			}

			function mask() {
				var value = input.val();
				input.val(maskValue(value));
			}

			function getDefaultMask() {
				var n = parseFloat('0')/Math.pow(10,settings.precision);
				return (n.toFixed(settings.precision)).replace(new RegExp('\\.','g'),settings.decimal);
			}

			function setSymbol(v) {
				if (settings.showSymbol) {
					if (v.substr(0, settings.symbol.length) != settings.symbol) return settings.symbol+v;
				}
				return v;
			}

			function changeSign(i){
				if (settings.allowNegative) {
					var vic = i.val();
					if (i.val()!='' && i.val().charAt(0)=='-'){
						return i.val().replace('-','');
					} else{
						return '-'+i.val();
					}
				} else {
					return i.val();
				}
			}

			input.bind('keypress.maskMoney',keypressEvent);
			input.bind('keydown.maskMoney',keydownEvent);
			input.bind('blur.maskMoney',blurEvent);
			input.bind('focus.maskMoney',focusEvent);
			input.bind('mask', mask);

			input.one('unmaskMoney',function() {
				input.unbind('.maskMoney');

				if ($.browser.msie) {
					this.onpaste= null;
				} else if ($.browser.mozilla) {
					this.removeEventListener('input',blurEvent,false);
				}
			});
		});
	}

	$.fn.unmaskMoney=function() {
		return this.trigger('unmaskMoney');
	};

	$.fn.mask=function() {
		return this.trigger('mask');
	};

	$.fn.setCursorPosition = function(pos) {
		this.each(function(index, elem) {
			if (elem.setSelectionRange) {
				elem.focus();
				elem.setSelectionRange(pos, pos);
			} else if (elem.createTextRange) {
				var range = elem.createTextRange();
				range.collapse(true);
				range.moveEnd('character', pos);
				range.moveStart('character', pos);
				range.select();
			}
		});
		return this;
	};

	$.fn.getInputSelection = function(el) {
		var start = 0, end = 0, normalizedValue, range, textInputRange, len, endRange;

		if (typeof el.selectionStart == "number" && typeof el.selectionEnd == "number") {
			start = el.selectionStart;
			end = el.selectionEnd;
		} else {
			range = document.selection.createRange();

			if (range && range.parentElement() == el) {
				len = el.value.length;
				normalizedValue = el.value.replace(/\r\n/g, "\n");

				// Create a working TextRange that lives only in the input
				textInputRange = el.createTextRange();
				textInputRange.moveToBookmark(range.getBookmark());

				// Check if the start and end of the selection are at the very end
				// of the input, since moveStart/moveEnd doesn't return what we want
				// in those cases
				endRange = el.createTextRange();
				endRange.collapse(false);

				if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
					start = end = len;
				} else {
					start = -textInputRange.moveStart("character", -len);
					start += normalizedValue.slice(0, start).split("\n").length - 1;

					if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
						end = len;
					} else {
						end = -textInputRange.moveEnd("character", -len);
						end += normalizedValue.slice(0, end).split("\n").length - 1;
					}
				}
			}
		}

		return {
			start: start,
			end: end
		};
	}
})(jQuery);

//função mensagem para confirmar o envio de dados 
function mensagem(msg, url) {
		if (confirm(msg)) {
			window.location = url;
		}
	}
	
function openWindow(nome, ref, tamanho) {
		window.open(nome, ref, tamanho)	
	}
	
function hiddenMenu(id){
	obj = document.getElementById(id);
	if(obj.style.display=="none"){
		obj.style.display="block";
	}
	else{
		obj.style.display="none";
	}
	return (obj.style.display=="none");
}
function invertMenu(x1, x2){
	obj1 = document.getElementById(x1);
	obj2 = document.getElementById(x2);
	if(obj1.style.display=="none"){
		obj2.style.display="block";
	}
	else{
		obj2.style.display="none";
	}
}

function BBCodeParse($str) {
		$a = array(
			"/\[ul\](.*?)\[\/ul\]/is",
			"/\[li\](.*?)\[\/li\]/is",
			"/\[p\](.*?)\[\/p\]/is",
			"/\[i\](.*?)\[\/i\]/is",
			"/\[b\](.*?)\[\/b\]/is",
			"/\[u\](.*?)\[\/u\]/is",
			"/\[center\](.*?)\[\/center\]/is",
			"/\[img\](.*?)\[\/img\]/is",
			"/\[url=(.*?)\](.*?)\[\/url\]/is",
			"/\[urli=(.*?)\](.*?)\[\/urli\]/is",
			"/\[img( alt\=(.*?))?( align\=(.*?))?( modelo\=(.*?))?](.*?)\[\/img\]/is",
			"/\[br\]/is",
			"/\[clear\]/is",
			"/\[table( id=(.*?))?( class=(.*?))?\](.*?)\[\/table\]/is",
			"/\[tr\](.*?)\[\/tr\]/is",
			"/\[td\](.*?)\[\/td\]/is",
			"/\[span\](.*?)\[\/span\]/is",
			"/\[span=(.*?)\](.*?)\[\/span\]/is"
		);
		$b = array(
			"<ul>$1</ul>",
			"<li>$1</li>",
			"<p>$1</p>",
			"<i>$1</i>",
			"<b>$1</b>",
			"<u>$1</u>",
			"<center>$1</center>",
			"<img src=\"$1\" />",
			"<a href=\"$1\" target=\"_blank\">$2</a>",
			"<a href=\"$1\">$2</a>",
			"<img src=\"$7\" alt=\"$2\" align=\"$4\" class=\"$6\" />",
			"<br />",
			"<br clear=\"all\" />",
			"<table id=\"$2\" class=\"$4\">$5</table>",
			"<tr>$1</tr>",
			"<td>$1</td>",
			"<span>$1</span>",
			"<span class=\"$1\">$2</span>"
		);
		$str = preg_replace($a, $b, $str);

		return $str;
	}	

jQuery.validator.addMethod("ipv4", function(value, element, param) { 
    return this.optional(element) || /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/i.test(value);
}, "Insira um IP v4 válido.");

jQuery.validator.addMethod("ipv6", function(value, element, param) { 
    return this.optional(element) || /^((([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}:[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){5}:([0-9A-Fa-f]{1,4}:)?[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){4}:([0-9A-Fa-f]{1,4}:){0,2}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){3}:([0-9A-Fa-f]{1,4}:){0,3}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){2}:([0-9A-Fa-f]{1,4}:){0,4}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9A-Fa-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9A-Fa-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9A-Fa-f]{1,4}::([0-9A-Fa-f]{1,4}:){0,5}[0-9A-Fa-f]{1,4})|(::([0-9A-Fa-f]{1,4}:){0,6}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){1,7}:))$/i.test(value);
}, "Insira um IP v6 válido.");


// Valid Types: mastercard, visa, amex, dinersclub, enroute, discover, jcb, unknown, all (overrides all other settings)
jQuery.validator.addMethod("creditcardtypes", function(value, element, param) {

	if (/[^0-9-]+/.test(value)) 
		return false;
	
	value = value.replace(/\D/g, "");
	
	var validTypes = 0x0000;
	
	if (param.mastercard) 
		validTypes |= 0x0001;
	if (param.visa) 
		validTypes |= 0x0002;
	if (param.amex) 
		validTypes |= 0x0004;
	if (param.dinersclub) 
		validTypes |= 0x0008;
	if (param.enroute) 
		validTypes |= 0x0010;
	if (param.discover) 
		validTypes |= 0x0020;
	if (param.jcb) 
		validTypes |= 0x0040;
	if (param.unknown) 
		validTypes |= 0x0080;
	if (param.all) 
		validTypes = 0x0001 | 0x0002 | 0x0004 | 0x0008 | 0x0010 | 0x0020 | 0x0040 | 0x0080;
	
	if (validTypes & 0x0001 && /^(51|52|53|54|55)/.test(value)) { //mastercard
		return value.length == 16;
	}
	if (validTypes & 0x0002 && /^(4)/.test(value)) { //visa
		return value.length == 16;
	}
	if (validTypes & 0x0004 && /^(34|37)/.test(value)) { //amex
		return value.length == 15;
	}
	if (validTypes & 0x0008 && /^(300|301|302|303|304|305|36|38)/.test(value)) { //dinersclub
		return value.length == 14;
	}
	if (validTypes & 0x0010 && /^(2014|2149)/.test(value)) { //enroute
		return value.length == 15;
	}
	if (validTypes & 0x0020 && /^(6011)/.test(value)) { //discover
		return value.length == 16;
	}
	if (validTypes & 0x0040 && /^(3)/.test(value)) { //jcb
		return value.length == 16;
	}
	if (validTypes & 0x0040 && /^(2131|1800)/.test(value)) { //jcb
		return value.length == 15;
	}
	if (validTypes & 0x0080) { //unknown
		return true;
	}
	return false;
}, "Please enter a valid credit card number.");


jQuery.validator.addMethod("phone", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, ""); 
	return this.optional(element) || phone_number.length > 9 &&
		phone_number.match(/^\(?\d{2}\)?[\s-]?\d{4}-?\d{4}$/);
}, "Invalido");

jQuery.validator.addMethod("cep", function(cep_number, element) {
    cep_number = cep_number.replace(/\s+/g, ""); 
	return this.optional(element) || cep_number.length > 9 &&
		cep_number.match(/^\d{2}.\d{3}-\d{3}$/);
}, "Invalido");



jQuery.validator.addMethod("mail", function(email, element) {

	return this.optional(element) ||
		email.match(/^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*(.){1}[a-zA-Z]{2,4})+$/);
}, "Invalido");

(function(A){A.extend(A.fn,{pstrength:function(B){var B=A.extend({verdects:["Muito fraco","Fraco","Medio","Forte","Excelente"],colors:["#f00","#c06","#f60","#3c0","#3f0"],scores:[10,15,30,40],common:["password","sex","god","123456","123","liverpool","letmein","qwerty","monkey"],minchar:6},B);return this.each(function(){var C=A(this).attr("id");A(this).after("<div class=\"pstrength-minchar\" id=\""+C+"_minchar\"></div>");A(this).after("<div class=\"pstrength-info\" id=\""+C+"_text\"></div>");A(this).after("<div class=\"pstrength-bar\" id=\""+C+"_bar\" style=\"border: 1px solid white; font-size: 1px; height: 5px; width: 0px;\"></div>");A(this).keyup(function(){A.fn.runPassword(A(this).val(),C,B)})})},runPassword:function(D,F,C){nPerc=A.fn.checkPassword(D,C);var B="#"+F+"_bar";var E="#"+F+"_text";if(nPerc==-200){strColor="#f00";strText="Minimo de 6 caracteres!";A(B).css({width:"0%"})}else{if(nPerc<0&&nPerc>-199){strColor="#ccc";strText="Muito curta";A(B).css({width:"1%"})}else{if(nPerc<=C.scores[0]){strColor=C.colors[0];strText=C.verdects[0];A(B).css({width:"4%"})}else{if(nPerc>C.scores[0]&&nPerc<=C.scores[1]){strColor=C.colors[1];strText=C.verdects[1];A(B).css({width:"6%"})}else{if(nPerc>C.scores[1]&&nPerc<=C.scores[2]){strColor=C.colors[2];strText=C.verdects[2];A(B).css({width:"8%"})}else{if(nPerc>C.scores[2]&&nPerc<=C.scores[3]){strColor=C.colors[3];strText=C.verdects[3];A(B).css({width:"14%"})}else{strColor=C.colors[4];strText=C.verdects[4];A(B).css({width:"20%"})}}}}}}A(B).css({backgroundColor:strColor});A(E).html("<span style='color: "+strColor+";'>"+strText+"</span>")},checkPassword:function(C,B){var F=0;var E=B.verdects[0];if(C.length<B.minchar){F=(F-100)}else{if(C.length>=B.minchar&&C.length<=(B.minchar+2)){F=(F+6)}else{if(C.length>=(B.minchar+3)&&C.length<=(B.minchar+4)){F=(F+12)}else{if(C.length>=(B.minchar+5)){F=(F+18)}}}}if(C.match(/[a-z]/)){F=(F+1)}if(C.match(/[A-Z]/)){F=(F+5)}if(C.match(/\d+/)){F=(F+5)}if(C.match(/(.*[0-9].*[0-9].*[0-9])/)){F=(F+7)}if(C.match(/.[!,@,#,$,%,^,&,*,?,_,~]/)){F=(F+5)}if(C.match(/(.*[!,@,#,$,%,^,&,*,?,_,~].*[!,@,#,$,%,^,&,*,?,_,~])/)){F=(F+7)}if(C.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)){F=(F+2)}if(C.match(/([a-zA-Z])/)&&C.match(/([0-9])/)){F=(F+3)}if(C.match(/([a-zA-Z0-9].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z0-9])/)){F=(F+3)}for(var D=0;D<B.common.length;D++){if(C.toLowerCase()==B.common[D]){F=-200}}return F}})})(jQuery)

