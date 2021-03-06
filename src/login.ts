import Axios from "axios";
import swal from "sweetalert";

const form : HTMLFormElement = document.getElementsByTagName("form")[0];
const mailInput = document.getElementById("mail") as HTMLInputElement;
const pwdInput = document.getElementById("motDePasse") as HTMLInputElement;

// prevent closing the dropdown with keydown.
mailInput.addEventListener("keydown", (e: KeyboardEvent) => e.stopPropagation());
pwdInput.addEventListener("keydown", (e: KeyboardEvent) => e.stopPropagation());

form.addEventListener("submit", async (ev) => 
{
	ev.preventDefault();
	console.log(`connexion : "${mailInput.value}" & "${pwdInput.value}"`);

	try {
		const response = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/ConnectionAPI.php`, {
			"mail": mailInput.value,
			"motDePasse": pwdInput.value
		});
		
		console.log(response.data);

		// if the login was succesful
		if (response.data.success) {
			const apiKey : string = response.data.body.key;
			// save the key for future use
			sessionStorage.setItem("apiKey", apiKey);
			console.log("Login successful !");
			// feedback : success
			swal({
				title: "Connexion réussie!",
				text: `Connexion en tant que ${mailInput.value}...`,
				icon: "success",
			  }).then(() => {
				window.location.reload();
			});
		} else {
			// feedback : failure
			swal({
				title: "Connexion échouée!",
				text: response.data.message,
				icon: "error",
			});
		}
	} catch (error) {
		console.log(error);
	}
});
