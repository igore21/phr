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
		newRow.find('.paramMeasureUnit').text(selectedParameter.data('measureUnit'));
		
		newRow.find('.paramId').attr('name', 'params[' + selectedParameterId + '][parameter_id]').val(selectedParameterId);
		newRow.find('.paramExecuteAfter').attr('name', 'params[' + selectedParameterId + '][execute_after]');
		newRow.find('.paramTimeUnit').attr('name', 'params[' + selectedParameterId + '][time_unit]');
		newRow.find('.paramComment').attr('name', 'params[' + selectedParameterId + '][comment]');
		newRow.find('.paramMandatory').attr('name', 'params[' + selectedParameterId + '][mandatory]');
		
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
	$('.saveAsDraftButton').click(function() {
		var taskRow = $(this).closest('.dataRow');
		$('.tcheck').hide();
		var data = getData(taskRow, 2);
		saveData(taskRow, data, false);
		return false;
	});
	
	$('.saveAsCompleteButton').click(function() {
		var taskRow = $(this).closest('.dataRow');
		$('.tcheck').hide();
		var data = getData(taskRow, 3);
		valid = checkData(taskRow);
		if (!valid) {
			taskRow.find('.dataValue').prop('disabled', true);
			$('.dataActionButtons').hide();
			$('.dataActionConfButtons').show();
		} else {
			saveData(taskRow, data, true);
		}
	});
	
	$('.returnForCorrectionButton').click(function() {
		$(this).closest('.dataRow').find('.dataValue').prop('disabled', false);
		$('.dataActionButtons').show();
		$('.dataActionConfButtons').hide();
	});
	
	$('.saveAnywayButton').click(function() {
		var taskRow = $(this).closest('.dataRow');
		$('.tcheck').hide();
		var data = getData(taskRow, 3);
		saveData(taskRow, data, true);
	});
	
	function getData(taskRow, state) {
		var data = {data: []};
		taskRow.find('table tbody tr').each(function() {
			var row = $(this);
			var dataType = row.find('.taskDataType').val();
			var valueInput = row.find('.type' + dataType);
			var value = valueInput.val();
			if (dataType == 4) value = valueInput.prop('checked');
			
			rowData = {
				'id': row.find('.taskId').val(),
				'data_type': dataType,
				'value': value,
				'state': state,
			}
			data.data.push(rowData);
		});
		console.log(data);
		return data;
	}
	
	function checkData(taskRow) {
		var allValid = true;
		taskRow.find('table tbody tr').each(function() {
			var row = $(this);
			var idInput = row.find('.taskId');
			var dataType = row.find('.taskDataType').val();
			var valueInput = row.find('.type' + dataType);
			var value = valueInput.val();
			if (dataType == 4) value = valueInput.prop('checked');
			
			var validRow = true;
			
			var mandatory = idInput.data('mandatory');
			if (mandatory == 1 && value == '') {
				validRow = false;
				row.find('.task_warn_row').show();
			}
			
			if (validRow) {
				row.find('.task_ok_row').show();
			}
			allValid = allValid && validRow;
		});
		
		if (!allValid) {
			$('.task_check').show();
		}
		return allValid;
	}
	
	function saveData(taskRow, data, hide) {
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
					taskRow.find('.dataStatusSucess').show();
					if (hide) taskRow.fadeOut(1000);
					console.log("success");
				}
				
			},
			error : function(jqXHR, textStatus, errorThrown) {
				console.log('error ajax');
			}
		});
	}
});