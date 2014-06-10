/**
 *
 */
function MultiCombo(conf) {
	
	// Constantes privadas
	/**
	 * Ancho por defecto del componente.
	 */
	var DEFAULT_WIDTH			= 200;
	
	/**
	 * Alto por defecto del componente, (aplicable al panel flotante).
	 */
	var DEFAULT_HEIGHT			= 200;
	
	/**
	 * Ancho de la imagen de despliegue.
	 */
	var DROPDOWN_IMAGE_WIDTH 	= 15;
	
	/**
	 * Ancho de los botones.
	 */
	var BUTTON_WIDTH 			= 30;

	/**
	 * Texto por defecto cuando el componente se encuentra sin valor válido.
	 */
	var DEFAULT_BLANK_TEXT 		= "Seleccione:";
	// Fin de constantes privadas
	
	// Atributos públicos
	/**
	 * Nombre del campo representado por el control
	 */
	this.campo 					= null;

	/**
	 * Referencia al campo input.
	 */
	this.input 					= null;
	
	/**
	 * Referencia al campo select.
	 */
	this.select					= null;
	// Fin de atributos públicos
	
	// Atributos Privados
	/**
	 * Instancia de JQuery.
	 */
	var $j 						= null;
	
	/**
	 * Texto en blanco a establecer en el campo imput al blanquear el componente.
	 */
	var blankText				= DEFAULT_BLANK_TEXT;
	
	/**
	 * Data contenida en el componente
	 */
	var data					= null;
	
	/**
	 * Contenedor de datos
	 */
	var dataContainer 			= null;
	
	/**
	 * Opción a establecer por defecto en el campo select al blanquear el componente.
	 */
	var options					= [ MultiCombo.OPTION_SELECTION ];
	
	/**
	 * Referencia a este componente.
	 */
	var mc 						= this;
	
	/**
	 * Configuración del componente.
	 */
	var cfg						= null;
	
	/**
	 * Separador utilizado para el formateo.
	 */
	var separator				= "; ";

	/**
	 * Contenedor principal del componente
	 */
	var container 				= null;

	/**
	 * Contenedor del campo input.
	 */
	var inputContainer			= null;
	
	/**
	 * Modo Simple / Múltiple del componente.
	 */
	var mode					= MultiCombo.MODE_MULTI;
	
	/**
	 * Contenedor del campo select.
	 */
	var selectContainer			= null;
	
	/**
	 * Datos seleccionados.
	 */
	var selectedData			= null;
	
	/**
	 * Bandera para controlar la acción Seleccionar Todos
	 */
	var selFlag					= false;
	
	/**
	 * Contenedor de visualización.
	 */
	var visualContainer			= null;
	// Fin de atributos privados
	
	// Métodos públicos
	/**
	 * Vacía la data del componente.
	 */
	this.clear = function() {
		mc.reset();
		dataContainer.empty();
		mc.select.empty();
		setText("");
	};
	
	/**
	 * Obtiene la data del componente.
	 */
	this.getData = function() {
		return data;
	};
	
	/**
	 * Obtiene el nombre del campo funcional asociado al componente. Útil para
	 * 	efectos de validación.
	 */
	this.getFieldName = function() {
		return mc.campo;
	}
	
	/**
	 * Obtiene el modo en el que se encuentra funcionando el componenete, el cual podrá
	 */
	this.getMode = function() {
		return mode;
	};
	
	/**
	 * Obtiene el valor seleccionado del componente en forma de arreglo.
	 * @param attr Indica qué atributo del componente conformará el valor. En caso
	 * 	de que sea 'null' o 'undefined', se devolverá la lista de objetos seleccionados.
	 * @return Arreglo de valores seleccionados. En caso de que el modo sea de selección simple,
	 *	.
	 */
	this.getValue = function(/* String */ attr) {
		if(mode == MultiCombo.MODE_MULTI) {
			if(selectedData) {
				var arr = [];
				if(attr) {
					for(var i = 0, n = selectedData.length; i < n; i++) 
						arr.push(selectedData[i][attr]);
				} else {
					for(var i = 0, n = selectedData.length; i < n; i++) {
						arr.push({
							text: 	(cfg.text instanceof Function) 
										? cfg.text(selectedData[i]) 
										: selectedData[i][cfg.text],
							value: 	selectedData[i][cfg.value],
							data: 	selectedData[i]
						});
					}
				}
				return arr;
			} else return null;
			
		} else if(mode == MultiCombo.MODE_SINGLE) {
			var nOpts = options.length;
			var i = mc.select.children(":selected").val();
			
			if(i >= nOpts) {
				if(attr) return data[i - nOpts][attr];
				else 
					return {
						text:	(cfg.text instanceof Function)
									? cfg.text(data[i - nOpts])
									: data[i - nOpts][cfg.text],
						value:	data[i - nOpts][cfg.value],
						data: 	data[i - nOpts]
					};
			} else {
				if(attr) return null;
				else return options[i];
			}
		}
	};
	
	/**
	 * Indica si el componente es visible o no (usando la propiedad CSS 'display').
	 * @return <code>true</code> si el componente es visible. En caso contrario retorna
	 * 	<code>false</code>.
	 */
	this.isVisible = function() {
		return container.css("display") != "none";
	};
	
	/**
	 * Resetea los valores seleccionados del componente.
	 */
	this.reset = function() {
		if(mode == MultiCombo.MODE_MULTI) {
			if(selectedData && selectedData.length > 0) selectedData.splice(0, selectedData.length);
			setText(blankText);
			unselectChecks();
			if(!visualContainer.is(":hidden")) mc.toogle();
		} else if(mode == MultiCombo.MODE_SINGLE) {
			mc.select.attr("selectedIndex", 0);
		}
	};
	
	/**
	 * Establece la data en el componente.
	 * @params _data Data a ser establecida en el componente, la cual debe contener los 
	 *	atributos especificados en los parámetros 'text' y 'value' en la construcción del 
	 *	componente. En caso de que el parámetro de configuración 'text' sea una función de 
	 *	formateo, la data deberá tener los atributos esperados por la misma.
	 */
	this.setData = function(_data) {
		
		var item 	= null;
		var text	= null;
		var nOpts	= options.length;
		data 		= _data;
		
		mc.clear();
		$j.each(options, function(i) {
			mc.select.append($j("<option></option>")
				.attr("value", i)
				.text(this.text)
			);
		});
		for(var i = 0, n = data.length; i < n; i++) {
			text = ((cfg.text instanceof Function) ? cfg.text(data[i]) : data[i][ cfg.text ]);
		
			item = $j("<div class='mc-data-item'><div><input name='" + cfg.id + "_chk' type='checkbox' value='" + i + "' /></div><div class='mc-data-text'>" 
				+ text + "</div></div>");
			item.addClass((i % 2 == 0) ? "mc-data-alter" : "mc-data-noalter");
			item.attr("title", text);
			
			mc.select.append($j("<option></option>")
				.attr("value", nOpts + i)
				.text(text)
			);
			dataContainer.append(item);
		}
		setText(blankText);
	};
	
	/**
	 * Establece el modo de funcionamiento del componente.
	 * @param mode MultiCombo.MODE_SINGLE para indicar el modo de selección simple, usando un combo box nativo HTML.
	 * 	MultiCombo.MODE_MULTI para indicar el modo de selección múltiple.
	 */
	this.setMode = function(/* int */ _mode) {
		
		inputContainer.css("display", (_mode == MultiCombo.MODE_MULTI) ? "block" : "none");
		selectContainer.css("display", (_mode == MultiCombo.MODE_SINGLE) ? "block" : "none");
		mc.reset();
		mode = _mode;
	};

	/**
	 * Establece el estilo para el componente en distintas secciones del mismo. Debe indicarse 
	 *	un objeto JSON con cada una de las secciones como atributos. Las secciones soportadas
	 *	hasta el momento son:
	 *		- container: Para los estilos del contenedor principal del control.
	 *		- dataContainer: Para los estilos del contenedor de datos.
	 * Estos atributos deben tener como valor un objeto JSON con la estructura que utilizaría
	 *	un objeto DOM Style.
	 *
	 * @param style Estructura de estilos a establecer.
	 * @param savePrevStyle Indica si el estilo anterior, o se sobreescribe por completo, 
	 *	blanqueando incluso estilos existentes que difieran a los predeterminados.
	 */
	this.setStyle = function(style, savePrevStyle) {
		if(style) {
			if(style.container) container.css(style.container);
			if(style.dataContainer) dataContainer.css(style.dataContainer);
			if(savePrevStyle == undefined || savePrevStyle) {
				for(var a in style) cfg.style[a] = style[a];
			}
		}
	};
	
	/**
	 * Establece un valor seleccionado para el componente.
	 * @param value Valor a establecer.
	 */
	this.setValue = function(value) {
		if(mode == MultiCombo.MODE_MULTI) {
			
		} else if(mode == MultiCombo.MODE_SINGLE) {
			for(var i = 0, n = data.length; i < n; i++) {
				if(data[i][cfg.value] == value) {
					mc.select.val(i + options.length);
					break;
				}
			}
		}
	};
	
	/**
	 * Establece la visibilidad del componente.
	 *	@param visible <code>true</code> para hacer que el componente sea visible. En caso 
	 *	contrario se debe especificar <code>false</code>.
	 */
	this.setVisible = function(/* boolean */ visible) {
		container.css("display", (visible) ? "block" : "none");
	};
	
	/**
	 * Muestra u oculta el panel de datos dependiendo del estado actual del componente.
	 * @return <code>true</code> si el contenedor de visualización se abrió con la acción.
	 * 	En caso de haberse cerrado, la función retornará <code>false</code>.
	 */
	this.toogle = function() {
		var isHidden = visualContainer.is(":hidden");
		if(isHidden) {
			var position = container.offset();
			visualContainer.css("top", position.top + 22);
			visualContainer.css("left", position.left);
			visualContainer.show();
		} else {
			visualContainer.hide();
			dataContainer.attr("scrollTop", 0);
		}
		return isHidden;
	};
	
	/**
	 * Alterna entre el modo de selección múltiple y el modod de selección simple del 
	 * 	componente.
	 * @return Modo de funcionamiento final del componente.
	 */
	this.toogleMode = function() {
		this.setMode((mode == MultiCombo.MODE_MULTI) ? MultiCombo.MODE_SINGLE : MultiCombo.MODE_MULTI);
		return mode;
	};
	
	/**
	 * Valida que se haya seleccionado alguna data del componente.
	 * @return <code>true</code> Si el componente posee un valor válido seleccionado. En caso 
	 *	contrario, retorna false.
	 */
	this.validate = function() {
	
		if(mode == MultiCombo.MODE_MULTI) return selectedData != null && selectedData.length > 0;
		else if(mode == MultiCombo.MODE_SINGLE) {
			var nOpts = options.length;
			var i = mc.select.attr("selectedIndex");
			if(i < nOpts) return options[i].valid;
			else return true;
		}
	};
	// Fin de métodos públicos
	
	// Métodos privados
	/**
	 * Cancela la selección de datos en el modo de selección múltiple, removiendo la seleccion de 
	 * 	los elementos, y reestableciendo la selección anterior.
	 */
	var cancelSelection = function() {
		unselectChecks();
		// Se marcan los que existen en la data seleccionada
		$j("input:checkbox[name=" + cfg.id + "_chk]").each(function(i) {
			if(selectedData) {
				for(var j = 0, n = selectedData.length; j < n; j++) {
					if(data[i].id == selectedData[j].id) this.checked = true
				}
			}
		});
	};
	
	/**
	 * Selecciona la data deseada por el usuario en el modo de selección múltiple, copiandola al 
	 * 	atributo correspondiente y haciendo las modificaciones pertinentes en la caja de texto 
	 * 	y tooltip.
	 */
	var selectData = function() {
		selectedData 	= [];
		var label 		= [];
		var o 			= null;
		$j("input:checkbox[name=" + cfg.id + "_chk]:checked").each(function(i) {
			o = data[this.value];
			selectedData.push(o);
			label.push(((cfg.format) ? cfg.format(o) : o[ cfg.text ]));
		});
		label = label.join(separator);
		if(label.length == 0) label = blankText;
		setText(label);
		if(cfg.selectDataCallback) cfg.selectDataCallback();
	};

	/**
	 * Establece una cadena en el campo de entrada, para el modo de selección múltiple.
	 * @param text Texto a establecer en el campo input.
	 */
	var setText = function(text) {
		mc.input.val(text);
		mc.input.attr("title", text);
	};
	
	/**
	 * Deselecciona los checks seleccionados para el modo de selección múltiple.
	 */
	var unselectChecks = function() {
		$j("input:checkbox[name=" + cfg.id + "_chk]:checked").each(function() {
			this.checked 	= false;
			selFlag 		= false;
		});
	};
	// Fin de métodos privados
	
	// Código de inicialización del componente
	(function(conf) {
		
		// Valida la existencia de JQuery
		if(!jQuery || !jQuery.noConflict) {
			alert("MultiCombo: Error de dependencia. JQuery requerido.");
			return;
		} else $j = jQuery.noConflict();
		
		if(conf) cfg = conf;
		else {
			alert("MultiCombo: Error de configuración. Objeto de configuración requerido.");
			return;
		}
		
		// Validación de parámetros de configuración mandatorios:
		// - id
		if(!cfg.id) {
			alert("MultiCombo: Error de configuración. Parámetro 'id' es requerido.");
			return;
		}
		// - text
		if(!cfg.text) {
			alert("MultiCombo: Error de configuración. Parámetro 'text' es requerido.");
			return;
		}
		// - value
		if(!cfg.value) {
			alert("MultiCombo: Error de configuración. Parámetro 'value' es requerido.");
			return;
		}
		// Fin de la validación de parámetros de configuración mandatorios.
		
		mc.campo = cfg.fieldName;
		
		// Valida la existencia del elemento contenedor
		container = $j('#' + cfg.id);
		if(!container) {
			alert("MultiCombo: Error de configuración. Elemento '" + cfg.id + "' inválido.");
			return;
		}
		
		var w = (cfg.width) ? cfg.width : DEFAULT_WIDTH;
		var h = (cfg.height) ? cfg.height : DEFAULT_HEIGHT;
		
		container.width(w);
		container.addClass("mc-main");
		
		// Campo input
		var inputField = $j("<input class='mc-input-field' type='text' />");
		inputField.attr("readonly", true);
		inputField.width(w - DROPDOWN_IMAGE_WIDTH - 24);
		inputField.bind("click", function() {
			if(!mc.toogle()) selectData();
		});
		mc.input = inputField;
		
		// Botón de despliegue
		var dropdownButton = $j("<div></div>");
		dropdownButton.addClass("mc-button");
		dropdownButton.addClass("mc-dropdown-button");
		dropdownButton.bind("click", function() {
			if(!mc.toogle()) selectData();
		});
		
		// Contenedor del campo input
		inputContainer = $j("<div></div>");
		inputContainer.addClass("mc-input-container");
		inputContainer.append(inputField);
		inputContainer.append(dropdownButton);
		
		// Campo select
		var selectField = $j("<select class=''></select>");
		selectField.width(w);
		selectField.bind("change", function() {
		});
		mc.select = selectField;
		
		// Contenedor del campo select
		selectContainer = $j("<div></div>");
		selectContainer.addClass("mc-input-container");
		selectContainer.css("display", "none");
		selectContainer.append(selectField);
		
		// Cotenedor de visualización: el cual se mostrará y ocultará y deberá contener 
		// al contenedor de datos y al de botones
		visualContainer = $j("<div></div>");
		visualContainer.width(w - 2);
		visualContainer.height(h);
		visualContainer.addClass("mc-visual-container");
		
		// Contenedor de datos
		dataContainer = $j("<div></div>");
		dataContainer.addClass("mc-data-container");
		dataContainer.height(h - 20);
		
		// Contenedor de botones
		var buttonsContainer = $j("<div></div>");
		buttonsContainer.addClass("mc-buttons-container");
		
		// Contenedor de botones de la izquierda (utilizado para obtener alineación 
		// independiente de los botones a la izquierda)
		var leftButtonsContainer = $j("<div></div>");
		leftButtonsContainer.addClass("mc-left-buttons-container");
		leftButtonsContainer.width(w - BUTTON_WIDTH * 2 - 2);
		
		// Botón Seleccionar / Deseleccionar Todos
		var selectAllButton = $j("<div></div>");
		selectAllButton.addClass("mc-button");
		selectAllButton.addClass("mc-selectall-button");
		selectAllButton.attr("title", "Marcar / Desmarcar todos");
		selectAllButton.bind("click", function() {
			var chk 	= null;
			var chks 	= $j("input[name=" + cfg.id + "_chk]");
			selFlag 	= !selFlag;
			
			chks.each(function() {
				this.checked = selFlag;
			});
		});
		leftButtonsContainer.append(selectAllButton);
		
		// Botón Aceptar
		var okButton = $j("<div></div>");
		okButton.addClass("mc-button");
		okButton.addClass("mc-ok-button");
		okButton.attr("title", "Aceptar");
		okButton.bind("click", function() {
			if(!mc.toogle()) selectData();
		});
		
		// Botón Cancelar
		var cancelButton = $j("<div></div>");
		cancelButton.addClass("mc-button");
		cancelButton.addClass("mc-cancel-button");
		cancelButton.attr("title", "Cancelar");
		cancelButton.bind("click", function() {
			cancelSelection();
			mc.toogle();
		});
		
		// Anexo de los botones al contenedor de botones
		buttonsContainer.append(leftButtonsContainer);
		buttonsContainer.append(okButton);
		buttonsContainer.append(cancelButton);
		
		// Anexo de los contenedores de datos y botones al contenedor de visualizacion
		visualContainer.append(dataContainer);
		visualContainer.append(buttonsContainer);
		
		// Anexo de los contenedores de campo de entrada y visualización al contenedor general
		container.append(inputContainer);
		container.append(selectContainer);
		$j(document.body).append(visualContainer);
		visualContainer.hide();
		
		// Aplicación de estilos adicionales
		mc.setStyle(cfg.style, false);
		
		// Establecimiento del valor usado para blanqueo de campo de texto
		if(cfg.blankText) blankText = cfg.blankText;
		// Opciones adicionales para el combo de selección simple
		if(cfg.options) options = cfg.options;
		// Poblado automático del componente
		if(cfg.populate) cfg.populate(mc.setData);
		
	}) (conf);
};

// Constantes públicas
/**
 * Constante para representar el modo de selección simple del componente.
 */
MultiCombo.MODE_SINGLE 		= 0;

/**
 * Constante para representar el modo de selección múltiple del componente, (predeterminado).
 */
MultiCombo.MODE_MULTI 		= 1;

/**
 * Constante para representar la opción estándar 'Todos'.
 */
MultiCombo.OPTION_ALL		= { text: "Todos", 			value: 0, 	valid: true };

/**
 * Constante para representar la opción estándar 'Seleccione:'.
 */
MultiCombo.OPTION_SELECTION	= { text: "Seleccione:", 	value: -1, 	valid: false };

/**
 * Constante para representar la opción estándar 'Ninguno'.
 */
MultiCombo.OPTION_NONE		= { text: "Ninguno", 		value: -2, 	valid: true };