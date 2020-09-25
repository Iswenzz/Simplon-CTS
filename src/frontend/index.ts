import "../assets/scss/index.scss";
import "materialize-css";
import "./signUp";
import "./logout";
import "./login";
import "./canvas";
import Canvas from "./canvas";
import swal from "sweetalert";
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
import InputComponent from "./component/InputComponent";

// initializing components
document.addEventListener("DOMContentLoaded", () => 
{
	// GLOBAL MODELS
	let missionModel = null;
	const planqueModel = null;
	const specialiteModel = null;
	const agentModel = null;
	const contactModel = null;
	const cibleModel = null;


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
	M.Modal.init(modals);

	const creators = document.getElementsByClassName("creator") as HTMLCollectionOf<HTMLButtonElement>;
	for (const item of creators) {
		item.addEventListener("click", async () => {
			const target = item.dataset["target"];
			switch (target) {
				case "mission":
					// inner form
					const input = new InputComponent("text", "mission-list-add-name", "Titre de la mission :");
					// alert 
					const res = await swal({
						title: "Ajouter une nouvelle mission",
						buttons: ["Annuler", "Confirmer"],
						content: {element: input.getContainer()}
					});
					// handling the results
					if (res) {
						missionModel = new Mission(null, input.getInput().value);
						console.log("Nouvelle mission : " + missionModel.format());
					}
					break;
			
				default:
					console.warn(target + " TODO");
					break;
			}
		});
	}

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
