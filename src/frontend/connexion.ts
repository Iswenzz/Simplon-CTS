import "axios";
import Axios from "axios";


const form : HTMLFormElement = document.getElementsByTagName("form")[0];
const mailInput = document.getElementById("mail") as HTMLInputElement;
const pwdInput = document.getElementById("motDePasse") as HTMLInputElement;

form.addEventListener("submit", (ev) => {
	ev.preventDefault();

	console.log(`test ${mailInput.value} & ${pwdInput.value}`);
	Axios.post("http://localhost/~jsouchet/TP/TP6-CTS/src/backend/php/checkConnect.php", {
		"mail": mailInput.value,
		"motDePasse": pwdInput.value
	});
});