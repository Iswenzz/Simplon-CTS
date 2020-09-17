import "axios";
import Axios from "axios";


const form : HTMLFormElement = document.getElementsByTagName("form")[0];
const mailInput = document.getElementById("mail") as HTMLInputElement;
const pwdInput = document.getElementById("motDePasse") as HTMLInputElement;

form.addEventListener("submit", (ev) => {
	ev.preventDefault();

	console.log(`test ${mailInput.value} & ${pwdInput.value}`);
	// TODO : passage en prod => mettre un URL absolu par rapport au serveur hébergeur
	Axios.post("../src/backend/php/checkConnect.php", {
		"mail": mailInput.value,
		"motDePasse": pwdInput.value
	});
});