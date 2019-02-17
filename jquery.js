
$(document).ready(function() {

	/*  No of rows dropdown options  */
	var noRows_options = '';
	var i;
	for (i=5; i<=30; i+=5) { 
	  noRows_options += '<option value="' + i + '">' + i + '</option>';
	}
	$('select#dropdown-norows').html(noRows_options);


	/*  Status dropdown options  */
	var status_options = "";
	var status = ["Any", "Confirmed", "Pending", "Denied"];
	status.forEach(myForeach);
	$('select#dropdown-status').html(status_options);

	function myForeach(option, index, array) { // JS foreach
	  status_options += '<option>' + option + '</option>'; 
	}


	/*  Table rows displayed according to status  */
	$('select#dropdown-status').on('change', function() {
							/* Both below the same */
		//var optionSelected = $("option:selected", this);
		//var optionSelected = $(this).find('option:selected')
    var valueSelected = this.value; // Good
		//var valueSelected = $(this).val(); // Bad

		if(valueSelected != 'Any') {
			var target = $('table tr[data-status="' + valueSelected + '"]');
			$("table tbody tr").not(target).hide();
			target.fadeIn();
	  } else {
	    $("table tbody tr").fadeIn();
	  }
	});

});