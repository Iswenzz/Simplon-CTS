import "../assets/scss/style.scss";
import "materialize-css";
import "./logout";
// import "./login";

// initializing login dropdown
document.addEventListener("DOMContentLoaded", () => {
	const trigger = document.getElementById("login");
	M.Dropdown.init(trigger, {
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
});