import "../assets/scss/style.scss";
import "materialize-css";
import "./logout";

// initializing login dropdown & inscription modal
document.addEventListener("DOMContentLoaded", () => {
	// login
	const loginTrigger = document.getElementById("login");
	const loginInstance = M.Dropdown.init(loginTrigger, {
		// aligned ?
		alignment: null,
		// appears below the trigger
		coverTrigger: false,
		// not closing when clicked
		closeOnClick: false,
		// free width
		constrainWidth: false,
		// lazy loading
		onOpenStart: () => {
			import("./login");
		}
	});

	const inscriptionTrigger = document.getElementById("inscription");
	inscriptionTrigger.addEventListener("click", () => {
		loginInstance.close();
	});

	// inscription
	const inscriptionModal = document.getElementById("inscription-modal");
	M.Modal.init(inscriptionModal, {
		onOpenStart: () => {
			import("./signUp");
		},
	});
});