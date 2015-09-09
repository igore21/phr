$(function() {
	$('#addParameter').click(function() {
		var templateRow = $('#templateParameter');
		var newRow = templateRow.clone();
		
		var parameterList = $('#parameterList');
		var selectedParameter = parameterList.find(':selected');
		var selectedParameterId = selectedParameter.val();
		
		if (selectedParameterId == 0) {
			return false;
		}
		
		selectedParameter.prop("disabled", true);
		parameterList.val(0);
		
		newRow.find('.paramId').val(selectedParameterId);
		newRow.find('.paramName').text(selectedParameter.text());
		
		newRow.find('.paramId').attr('name', 'params[' + selectedParameterId + '][parameter_id]').val(selectedParameterId);
		newRow.find('.paramExecuteAfter').attr('name', 'params[' + selectedParameterId + '][execute_after]');
		newRow.find('.paramTimeUnit').attr('name', 'params[' + selectedParameterId + '][time_unit]');
		newRow.find('.paramComment').attr('name', 'params[' + selectedParameterId + '][comment]');
		
		newRow.removeAttr('id');
		newRow.show();
		$('.parameterElem:last').after(newRow);
		
		return false;
	});
	
	$('#parameters').on('click', '.removeParameter', function() {
		var parameter = $(this).closest('.parameterElem');
		var parameterId = parameter.find('.paramId').val();
		
		$('#parameterList option[value="' + parameterId + '"]').prop('disabled', false);
		parameter.remove();
		return false;
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
	
	//=========
	// Data
	//=========
	$('.saveDataButton').click(function() {
		var taskRow = $(this).closest('tr');
		
		var dataType = taskRow.find('.taskDataType').val();
		var valueInput = taskRow.find('.type' + dataType);
		var value = valueInput.val();
		
		valueInput.removeClass('invalidInput');
		if (!value || value == '') {
			valueInput.addClass('invalidInput');
			return;
		}
		console.log('val: ' + value);
		var data = {
			'id': taskRow.find('.taskId').val(),
			'data_type': dataType,
			'value': value,
		}
		
		sendTaskData(data, taskRow);
		return false;
	});
	
	$('.btnIgnore').click(function() {
		var taskRow = $(this).closest('tr');
		
		var data = {
			'id': taskRow.find('.taskId').val(),
			'ignored': true,
		}
		
		sendTaskData(data, taskRow);
		return false;
	});
	
	function sendTaskData(data, taskRow) {
		$.ajax({
			type : 'POST',
			url: '/patient/tasks/saveTaskData.php',
			data: data,
			dataType: 'json',
			success: function(data, textStatus, jqXHR) {
				console.log(data);
				
				if (data.error) {
					// TODO
				}
				else {
					taskRow.find('.saveDataButton').hide();
					taskRow.find('.btnIgnore').hide();
					taskRow.find('.actionOk').show();
					taskRow.find('.dataValue').prop('disabled', true);
				}
				
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log('error ajax');
			}
		});
	}
});