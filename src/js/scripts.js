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
		
		first_name.attr('disabled', false);
		last_name.attr('disabled', false);
		email.attr('disabled', false);
		
		var saveOrCancel = $('.saveOrCancel').show();
		$(this).hide();
		
		return false;
	});
	
	$('#cancelChangeProfileInfo').click(function(){
		var first_name = $('#fn');
		var last_name = $('#ln');
		var email = $('#em');
		
		first_name.val(first_name.data('value'));
		last_name.val(last_name.data('value'));
		email.val(email.data('value'));
		
		first_name.attr('disabled', true);
		last_name.attr('disabled', true);
		email.attr('disabled', true);
		
		$('#editProfileInfo').show();
		$('.saveOrCancel').hide();
		
		return false;
	});
	
	
	$('#saveChangedPassword').click(function() {
		$('#editPasswordForm').checkValidity();
		
		var pass = $('#op').val();
		var newPass = $('#np').val();
		var repNewPass = $('#rnp').val();
		
		if (newPass !== repNewPass) {
			$('#passwordChangeError').text('Nova sifra nije ispravno potvrdjena').show();
			return false;
		}
		
		$('#op').val('');
		$('#np').val('');
		$('#rnp').val('');
		
		$('#passwordChangeError').hide();
		$('#passwordChangeSuccess').hide();
		
		var data = { 'op': pass, 'np': newPass };
		$.ajax({
			type : 'POST',
			url: '/common/processEditPassword.php',
			data: data,
			dataType: 'json',
			success: function(data, textStatus, jqXHR) {
				console.log(data);
				if (data.error) {
					$('#passwordChangeError').text(data.error).show();
				}
				else {
					$('#passwordChangeSuccess').show();
				}
			},
			error : function(jqXHR, textStatus, errorThrown) {
				$('#passwordChangeError').text('Doslo je do greske u kominikaciji sa serverom').show();
			}
		});
		return false;
	});
	
	$('#changeProfileInfo').click(function() {
		$('#editProfileForm').checkValidity();
		
		var first_name = $('#fn');
		var first_name_val = first_name.val();
		var last_name = $('#ln');
		var last_name_val = last_name.val();
		var email = $('#em');
		var email_val = email.val();
		
		$('#profileChangeSuccess').hide();
		$('#profileChangeError').hide();
		
		var data = { 'fn': first_name_val, 'ln': last_name_val, 'em': email_val };
		$.ajax({
			type : 'POST',
			url: '/common/processEditProfile.php',
			data: data,
			dataType: 'json',
			success: function(data, textStatus, jqXHR) {
				console.log(data);
				
				if (data.error) {
					$('#profileChangeError').text(data.error).show();
				}
				else {
					$('#profileChangeSuccess').show();
					
					$('#profileName').text(first_name_val + ' ' + first_name_val);
					first_name.data('value', first_name_val);
					last_name.data(last_name_val);
					email.data(email_val);
					
					$('.saveOrCancel').hide();
					$('#editProfileInfo').show();
					first_name.attr('disabled', true);
					last_name.attr('disabled', true);
					email.attr('disabled', true);
				}
				
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log('error ajax');
			}
		});
		
		return false;
	});
	
});