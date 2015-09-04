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


$('#saveChangedPassword').click(function() {
	var pass = $('#op').val();
	var newPass = $('#np').val();
	var repNewPass = $('#rnp').val();
	$('#passwordChangeError').hide();
	$('#passwordChangeSuccess').hide();
	
	if (newPass===repNewPass) {
		var data = { 'op': pass, 'np': newPass };
	}
	else {
		$('#passwordChangeError').show();
	}

	console.log('start');
	$.ajax({
		type : 'POST',
		url: '/common/processEditPassword.php',
		data: data,
		dataType: 'json',
		success: function(data, textStatus, jqXHR) {
			console.log('ajax');
			console.log(data);
			
			if (data.error) {
				$('#profileChangeSuccess').hide();
				$('#passwordChangeError').show();
			}
			else {
				console.log('ok');
				$('#profileChangeError').hide();
				$('#passwordChangeSuccess').show();
			}
			
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log('error ajax');
		}
	});
	console.log('end');
	return false;
});


$('#changeProfileInfo').click(function() {
	var first_name = $('#fn');
	var first_name_val = first_name.val();
	var last_name = $('#ln');
	var last_name_val = last_name.val();
	var email = $('#em');
	var email_val = email.val();
	$('#profileChangeSuccess').hide();
	$('#profileChangeError').hide();
	
	var data = { 'fn': first_name_val, 'ln': last_name_val, 'em': email_val };
	
	console.log('start');
	$.ajax({
		type : 'POST',
		url: '/common/processEditProfile.php',
		data: data,
		dataType: 'json',
		success: function(data, textStatus, jqXHR) {
			console.log('ajax');
			console.log(data);

			if (data.error) {
				$('#profileChangeError').show();
			}
			else {
				console.log('ok');
				$('#profileChangeSuccess').show();
				first_name.data('value', first_name_val);
				last_name.data(last_name_val);
				email.data(email_val);
			}
			
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log('error ajax');
		}

	});
	var saveOrCancel = $('.saveOrCancel');
	var edit = $('#editProfileInfo');
	saveOrCancel.hide();
	edit.show();
	
	first_name.attr('disabled', true);
	last_name.attr('disabled', true);
	email.attr('disabled', true);
	console.log('end');
	return false;
});