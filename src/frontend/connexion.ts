import Axios from "axios";
import "./disconnect";


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
		
		// if the login was succesful
		if (response.data.success) {
			const apiKey : string = response.data.key;
			// save the key for future use
			sessionStorage.setItem("apiKey", apiKey);
			console.log("Login successful !");
			// redirect to home
			setTimeout(() => {
				window.location.href = "index.html";
			}, 2000);
		} else {
			console.log("Login failed ☹");
		}
	} catch (error) {
		console.log(error);
	}
});