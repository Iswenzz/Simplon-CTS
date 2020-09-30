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
import "../assets/scss/index.scss";
import "materialize-css";
import ContactTab from "./tabs/ContactTab";
import CibleTab from "./tabs/CibleTab";
import AgentTab from "./tabs/AgentTab";
import SpecialiteTab from "./tabs/SpecialiteTab";
import PlanqueTab from "./tabs/PlanqueTab";

document.addEventListener("DOMContentLoaded", async () =>
{
	// 3D scene
	new Canvas();

	// visible / hidden depending on connect status
	if (sessionStorage["apiKey"] || true)
	{ // connected
		document.body.classList.add("connected");
		document.body.classList.remove("disconnected");

		// enable inputs
		const inputs = [...document.getElementsByTagName("input"), ...document.getElementsByTagName("textarea")];
		for (const input of inputs)
			input.removeAttribute("disabled");
	}
	else
	{
		document.body.classList.add("disconnected");
		document.body.classList.remove("connected");

		// disable inputs
		const inputs = [...document.getElementsByTagName("input"), ...document.getElementsByTagName("textarea")];
		for (const input of inputs)
			input.setAttribute("disabled", "true");

		// ...minus those for login & signup
		const logInputs = document.querySelectorAll("#login-dropdown input, #inscription-modal input");
		for (const input of logInputs)
			input.removeAttribute("disabled");
	}
	// materialize elems
	const loginInstance = M.Dropdown.init(document.getElementById("login"), {
		alignment: null, 		// aligned ?
		coverTrigger: false, 	// appears below the trigger
		closeOnClick: false, 	// not closing when clicked
		constrainWidth: false 	// free width
	});
	document.getElementById("inscription").addEventListener("click", () => {
		loginInstance.close();
	});
	M.Modal.init(document.querySelectorAll(".modal"));
	M.FormSelect.init(document.querySelectorAll("select"));
	M.Tabs.init(document.querySelectorAll(".tabs"));
	M.updateTextFields();

	// repositories
	const missionRepo = new MissionRepository();
	const contactRepo = new ContactRepository();
	const cibleRepo = new CibleRepository();
	const agentRepo = new AgentRepository();
	const specialiteRepo = new SpecialiteRepository();
	const planqueRepo = new PlanqueRepository();

	// tabs
	new MissionTab(missionRepo, document.getElementById("mission-list"));
	new ContactTab(contactRepo, document.getElementById("contact-list"));
	new CibleTab(cibleRepo, document.getElementById("target-list"));
	new AgentTab(agentRepo, document.getElementById("agent-list"));
	new SpecialiteTab(specialiteRepo, document.getElementById("specialite-list"));
	new PlanqueTab(planqueRepo, document.getElementById("hideout-list"));
});
