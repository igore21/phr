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
	
	$('#editProfileInfo').click(function(){
		var first_name = $('#fn');
		var last_name = $('#ln');
		var email = $('#em');
		var saveOrCancel = $('.saveOrCancel');
		first_name.attr('disabled', false);
		last_name.attr('disabled', false);
		email.attr('disabled', false);
		saveOrCancel.show();
		$(this).hide();
		return false;
	});
	
	$('#cancelChangeProfileInfo').click(function(){
		var first_name = $('#fn');
		var last_name = $('#ln');
		var email = $('#em');
		var edit = $('#editProfileInfo');
		var first_name_val = $('#fn').data('value');
		var last_name_val = $('#ln').data('value');
		var email_val = $('#em').data('value');
		var saveOrCancel = $('.saveOrCancel');
		first_name.val(first_name_val);
		last_name.val(last_name_val);
		email.val(email_val);
		first_name.attr('disabled', true);
		last_name.attr('disabled', true);
		email.attr('disabled', true);
		saveOrCancel.hide();
		edit.show();
		return false;
	});
	
	$('#saveChange').click(function(){
		var first_name = $('#fn');
		var last_name = $('#ln');
		var email = $('#em');
		var edit = $('#edit');
		first_name.attr('disabled', true);
		last_name.attr('disabled', true);
		email.attr('disabled', true);
	});
	
	$('#cancelPasswordChange').click(function(){
		var oldPassword = $('#op');
		var newPassword = $('#np');
		var repeatNewPassword = $('#rnp');
		oldPassword.val("");
		newPassword.val("");
		repeatNewPassword.val("");
		return false;
	});
	
});


