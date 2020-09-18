import Axios from "axios";


const form : HTMLFormElement = document.getElementsByTagName("form")[0];
const mailInput = document.getElementById("mail") as HTMLInputElement;
const pwdInput = document.getElementById("motDePasse") as HTMLInputElement;

form.addEventListener("submit", async (ev) => {
	ev.preventDefault();

	console.log(`connexion : "${mailInput.value}" & "${pwdInput.value}"`);

	try {
		// TODO : passage en prod => mettre un URL absolu par rapport au serveur hébergeur
		const response = await Axios.post("../src/backend/php/checkConnect.php", {
			"mail": mailInput.value,
			"motDePasse": pwdInput.value
		});
		
		console.log(response.data);
		const apiKey : string = response.data.key;
		const user : string = response.data.user;
		// save the ids for future use
		sessionStorage.setItem("apiKey", apiKey);
		sessionStorage.setItem("user", user);
	} catch (error) {
		// console.log(error);
	}
});