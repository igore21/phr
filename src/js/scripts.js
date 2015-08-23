$(function() {
	$('#addParameter').click(function() {
		var templateRow = $('#templateParameter');
		var newRow = templateRow.clone();
		var parameterList = $('#parameterList');
		var selectedParameterText = parameterList.find(':selected').text();
		var selectedParameterValue = parameterList.find(':selected').val();
		newRow.find('.paramId').val(selectedParameterValue);
		console.log(selectedParameterValue);
		
		newRow.removeAttr('id');
		newRow.find('.parameterName').text(selectedParameterText);
		newRow.show();
		$('.parameterElem:last').after(newRow);
		return false;
	});
	
	$('.removeParameter').click(function() {
		
	});
	
	$('#parameters').on('click', '.removeParameter', function() {
		var parameter = $(this).closest('.parameterElem');
		parameter.remove();
	});
	
});



