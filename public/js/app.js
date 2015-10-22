function switchElement(show, hide) {
  document.getElementById(hide).style.display = 'none';
  document.getElementById(show).style.display = 'block';
}

function do_delete(id) {
	var form_elem = document.getElementById('delete_form');
	document.getElementById('delete_id').value = id;
	form_elem.submit();
}

function confirm_delete(id) {
	document.getElementById('confirm_delete_button').onclick = function(){
		do_delete(id);
	};
	$('#delete_modal').openModal();
}

function confirm_multiple_delete() {
	document.getElementById('confirm_delete_button').onclick = function(){
		$('#delete_form').submit();
	};
	$('#delete_modal').openModal();
}

function confirm_update() {
	$('#update_modal').openModal();	
}

function confirm_send() {
	$('#send_modal').openModal();
}