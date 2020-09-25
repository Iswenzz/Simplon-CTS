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
import MissionRepository from "./repository/MissionRepository";
import MissionTab from "./tabs/MissionTab";
import Mission from "./model/Mission";
import Planque from "./model/Planque";
import Specialite from "./model/Specialite";
import Contact from "./model/Contact";
import Agent from "./model/Agent";
import Cible from "./model/Cible";

// initializing components
document.addEventListener("DOMContentLoaded", () => 
{
	// GLOBAL MODELS
	let missionModel = null;
	let planqueModel = null;
	let specialiteModel = null;
	let agentModel = null;
	let contactModel = null;
	let cibleModel = null;


	// 3D scene
	new Canvas();

	// visible / hidden depending on connect status
	if (sessionStorage["apiKey"]) { // connected
		document.body.classList.add("connected");
		document.body.classList.remove("disconnected");

		// enable inputs
		const inputs = [...document.getElementsByTagName("input"), ...document.getElementsByTagName("textarea")];
		for (const input of inputs) {
			input.removeAttribute("disabled");
		}


	} else {
		document.body.classList.add("disconnected");
		document.body.classList.remove("connected");

		// disable inputs
		const inputs = [...document.getElementsByTagName("input"), ...document.getElementsByTagName("textarea")];
		for (const input of inputs) {
			input.setAttribute("disabled", "true");
		}
		// ...minus those for login & signup
		const logInputs = document.querySelectorAll("#login-dropdown input, #inscription-modal input");
		for (const input of logInputs) {
			input.removeAttribute("disabled");
		}
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
	modals.forEach((modal) => {
		const modalEl = modal as HTMLElement;
		if (modalEl.classList.contains("new")) {
			// modals for adding new models
			M.Modal.init(modal, {
				// when modal closes => creates a new model of the relevant type
				onCloseEnd: () => {
					const target = modalEl.dataset["target"];
					switch (target) {
						case "mission":
							missionModel = new Mission();
							const titreInput = document.getElementById("mission-list-name-input") as HTMLInputElement;
							missionModel.setTitre(titreInput.value);
							break;
						case "hideout":
							planqueModel = new Planque();
							break;
						case "specialite":
							specialiteModel = new Specialite();
							break;
						case "agent":
							agentModel = new Agent();
							break;
						case "contact":
							contactModel = new Contact();
							break;
						case "target":
							cibleModel = new Cible();
							break;
						default:
							console.error("Cible modal inconnue : " + target);
							break;
					}
					console.log(`${modalEl.id}: New ${target} !`);
				}
			});
			
		} else { // TODO others modals
			M.Modal.init(modal);
		}
	});

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
	// MISSIONS
	const missionRepo = new MissionRepository("mission-list");
	// const missionInputs = [...document.querySelectorAll("#mission input, #mission textarea")] as HTMLElement[];
	// const mission = new MissionTab(missionRepo, missionInputs, missionModel);
	// mission.init();

	// text edit buttons
	const textTriggers = document.getElementsByClassName("text-edit-trigger") as HTMLCollectionOf<HTMLButtonElement>;
	for (const trig of textTriggers) {
		const targetSel = trig.dataset["target"];
		const targets = document.querySelectorAll(targetSel);

		trig.addEventListener("click", () => {
			for (const target of targets) {
				target.removeAttribute("disabled");
			}
		});

		for (const target of targets) {
			target.addEventListener("blur", () => {
				target.setAttribute("disabled", "true");
			});
		}
	}
});
