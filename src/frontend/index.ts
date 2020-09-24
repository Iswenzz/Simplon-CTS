import "../assets/scss/index.scss";
import "materialize-css";
import "./signUp";
import "./logout";
import "./login";
import "./canvas";
import Canvas from "./canvas";
import ContactRepository from "./repository/ContactRepository";
import CibleRepository from "./repository/CibleRepository";
import AgentRepository from "./repository/AgentRepository";
import SpecialiteRepository from "./repository/SpecialiteRepository";
import PlanqueRepository from "./repository/PlanqueRepository";

// initializing components
document.addEventListener("DOMContentLoaded", () => 
{
	// 3D scene
	new Canvas();

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
		alignment: null, 		// aligned ?
		coverTrigger: false, 	// appears below the trigger
		closeOnClick: false, 	// not closing when clicked
		constrainWidth: false 	// free width
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
