<?php
/**
 * This file include sends styles and JS code utilities for the input form masks.
 * It should be included in the header of the HTML page with a statement like this:
 * 
 * <pre>include_once __DIR__ . "/FormStylesAndJS.php";</pre>
 * 
 * @author Umberto Salsi <salsi@icosaedro.it>
 * @version $Date: 2018/12/25 01:56:21 $
 * @package FormStylesAndJS
 */
?>

<style>
.changed {
	background-color: yellow;
}
</style>

<script>

/**
 * Set the background color of the control to yellow if it differs from the
 * default value, so making more apparent which changes have been made.
 */
function setStyleOnChange(c)
{
	// Retrieve the dafult value of the control:
	var defaultValue = "";
	if( c.type === "select-one" ){
		for(var i = c.options.length - 1; i >= 0; i--){
			if( c.options[i].defaultSelected ){
				defaultValue = c.options[i].value.trim();
				break;
			}
		}
	} else {
		defaultValue = c.defaultValue.trim();
	}
	
	// Detect if current value differs from the default:
	var changed = c.value.trim() !== defaultValue;
	//alert("changed: " + changed);
	
	// Highlight if value changed:
	if( changed )
		c.style = "background-color: yellow;"
	else
		c.style = "";
}

/**
 * Set the visibility of the specified element based on the status of the
 * specified checkbox.
 * @param string checkbox  ID of the controlling checkbox.
 * @param string area  ID of the controlled area, typically a "div".
 */
function setVisibilityToggle(checkbox, area)
{
	var area = document.getElementById(area);
	var is_visible = document.getElementById(checkbox).checked;
	area.style.display = is_visible? "block" : "none";
}

</script>
