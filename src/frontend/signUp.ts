import "../assets/scss/style.scss";
import Axios from "axios";
import "./logout";


const form = document.getElementById("inscription-form") as HTMLFormElement;
const nameInput = document.getElementById("inscription-nom") as HTMLInputElement;
const firstNameInput = document.getElementById("inscription-prenom") as HTMLInputElement;
const mailInput = document.getElementById("inscription-mail") as HTMLInputElement;
const pwdInput = document.getElementById("inscription-motDePasse") as HTMLInputElement;

form.addEventListener("submit", async (ev) => {
	ev.preventDefault();

	console.log(`inscription : "${nameInput.value}" & "${firstNameInput.value}" & "${mailInput.value}" & "${pwdInput.value}"`);

	try {
		// TODO : passage en prod => mettre un URL absolu par rapport au serveur hébergeur
		const response = await Axios.post("../src/backend/php/createAdmin.php", {
			"name": nameInput.value,
			"firstName": firstNameInput.value,
			"mail": mailInput.value,
			"password": pwdInput.value
		});
		
		console.log(response.data);
	} catch (error) {
		console.log(error);
	}
});