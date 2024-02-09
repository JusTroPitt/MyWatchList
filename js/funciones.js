

	function aleatorio(maximo) {
		
		var random = Math.floor((Math.random() * maximo) + 1);
		 var getElement = document.getElementById("random");
		 
		 getElement.href = "detalles.php?id=" + random;
	}

	
(function($) {

	var datatableInit = function() {

		$('#datatable').dataTable({
		});

	};

	$(function() {
		datatableInit();
	});

}

).apply(this, [jQuery]);