import "../assets/scss/style.scss";
import Axios from "axios";
import swal from "sweetalert";
import "./logout";


const form = document.getElementById("inscription-form") as HTMLFormElement;
const nameInput = document.getElementById("inscription-nom") as HTMLInputElement;
const firstNameInput = document.getElementById("inscription-prenom") as HTMLInputElement;
const mailInput = document.getElementById("inscription-mail") as HTMLInputElement;
const pwdInput = document.getElementById("inscription-motDePasse") as HTMLInputElement;

form.addEventListener("submit", async (ev) => {
	ev.preventDefault();

	console.log(`inscription : "{nameInput.value}" & "{firstNameInput.value}" & "{mailInput.value}" & "{pwdInput.value}"`);

	try {
		// TODO : passage en prod => mettre un URL absolu par rapport au serveur hébergeur
		const response = await Axios.post("../src/backend/php/api/InscriptionAPI.php", {
			"name": nameInput.value,
			"firstName": firstNameInput.value,
			"mail": mailInput.value,
			"password": pwdInput.value
		});
		
		console.log(response.data);

		// if the signup was succesful
		if (response.data.success) {
			const apiKey : string = response.data.key;
			// save the key for future use
			sessionStorage.setItem("apiKey", apiKey);
			console.log("Sign up successful !");
			// feedback : success
			swal({
				title: "Inscription réussie!",
				text: `Connexion en tant que {mailInput.value}...`,
				icon: "success",
			  })
			  .then(() => {
				  window.location.reload();
			  });
		} else {
			// feedback : failure
			swal({
				title: "Inscription échouée!",
				text: response.data.message,
				icon: "error",
			  });
		}
	} catch (error) {
		console.log(error);
	}
});