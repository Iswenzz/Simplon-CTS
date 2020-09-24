import "../assets/scss/style.scss";
import "materialize-css";
import "./signUp";
import "./logout";
import "./login";
import ContactController from "./controller/ContactController";

// initializing login dropdown & inscription modal
document.addEventListener("DOMContentLoaded", () => {
	// dropdown
	const lognumberrigger = document.getElementById("login");
	const loginInstance = M.Dropdown.init(lognumberrigger, {
		// aligned ?
		alignment: null,
		// appears below the trigger
		coverTrigger: false,
		// not closing when clicked
		closeOnClick: false,
		// free width
		constrainWidth: false
	});

	const inscriptionTrigger = document.getElementById("inscription");
	inscriptionTrigger.addEventListener("click", () => {
		loginInstance.close();
	});

	// modal
	const modals = document.querySelectorAll(".modal");
	M.Modal.init(modals);

	// select
	const selects = document.querySelectorAll("select");
	M.FormSelect.init(selects);

	// tabs
	const tabs = document.querySelectorAll(".tabs");
	M.Tabs.init(tabs);


	// lists
	const contactCtrl = new ContactController("contact-list");
	contactCtrl.listAll();
});