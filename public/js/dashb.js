$(document).ready(function(){
	// navbar
	//
	const ElemensDropdown = document.querySelectorAll(".dropdown-trigger");
	const InstanceDropdown = M.Dropdown.init(ElemensDropdown,{
		coverTrigger: false,
	});

	// navbar menu mobile
	//
	const ElemensDropdownMenuMobile = document.querySelectorAll(".sidenav");
	const InstanceDropdownMenuMobile = M.Sidenav.init(ElemensDropdownMenuMobile,{
		edge: "right",
		draggable: true,
	});

	// modal
	var elems = document.querySelectorAll('.modal');
	var instances = M.Modal.init(elems);

	$("#modal-close").click(function() {
		 $('.modal').hide();
		 $(".sidenav-overlay").hide();
	});

	$('select').formSelect();
});
