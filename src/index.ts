import "./signUp";
import "./logout";
import "./login";
import "./canvas";
import Canvas from "./canvas";
import MissionTab from "./tabs/MissionTab";
import ContactTab from "./tabs/ContactTab";
import CibleTab from "./tabs/CibleTab";
import AgentTab from "./tabs/AgentTab";
import SpecialiteTab from "./tabs/SpecialiteTab";
import PlanqueTab from "./tabs/PlanqueTab";
import "./assets/scss/index.scss";
import "materialize-css";

document.addEventListener("DOMContentLoaded", async () =>
{
	// 3D scene
	new Canvas();

	// visible / hidden depending on connect status
	if (sessionStorage["apiKey"])
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
	M.Tabs.init(document.querySelectorAll(".tabs"));
	M.updateTextFields();

	// Tabs
	new PlanqueTab();
	new SpecialiteTab();
	new AgentTab();
});
