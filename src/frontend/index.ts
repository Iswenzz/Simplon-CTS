import "../assets/scss/style.scss";
import "materialize-css";
import "./logout";
// import "./login";

// initializing login dropdown
document.addEventListener("DOMContentLoaded", () => {
	const trigger = document.getElementById("login");
	M.Dropdown.init(trigger, {
		coverTrigger: false,
		// lazy loading
		onOpenStart: () => {
			import("./login");
		}
	});
});