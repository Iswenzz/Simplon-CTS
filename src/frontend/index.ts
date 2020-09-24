import "../assets/scss/style.scss";
import "materialize-css";
import "./signUp";
import "./logout";
import "./login";
import ContactRepository from "./repository/ContactRepository";
import CibleRepository from "./repository/CibleRepository";
import AgentRepository from "./repository/AgentRepository";
import SpecialiteRepository from "./repository/SpecialiteRepository";
import PlanqueRepository from "./repository/PlanqueRepository";

// initializing components
document.addEventListener("DOMContentLoaded", () => {
	// visible / hidden depending on connect status
	if (sessionStorage["apiKey"]) { // connected
		document.body.classList.add("connected");
		document.body.classList.remove("disconnected");
	} else {
		document.body.classList.add("disconnected");
		document.body.classList.remove("connected");
	}


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
	const contactRepo = new ContactRepository("contact-list");
	contactRepo.listAll();
	const targetRepo = new CibleRepository("target-list");
	targetRepo.listAll();
	const agentRepo = new AgentRepository("agent-list");
	agentRepo.listAll();
	const specialiteRepo = new SpecialiteRepository("specialite-list");
	specialiteRepo.listAll();
	const planqueRepo = new PlanqueRepository("hideout-list");
	planqueRepo.listAll();
});