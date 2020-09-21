import Axios from "axios";

const form : HTMLFormElement = document.getElementsByTagName("form")[0];
const mailInput = document.getElementById("mail") as HTMLInputElement;
const pwdInput = document.getElementById("motDePasse") as HTMLInputElement;

form.addEventListener("submit", async (ev) => {
	ev.preventDefault();

	console.log(`connexion : "${mailInput.value}" & "${pwdInput.value}"`);

	try {
		// TODO : passage en prod => mettre un URL absolu par rapport au serveur hébergeur
		const response = await Axios.post("../src/backend/php/checkLogin.php", {
			"mail": mailInput.value,
			"motDePasse": pwdInput.value
		});
		
		console.log(response.data);

		await import("sweetalert");

		// if the login was succesful
		if (response.data.success) {
			const apiKey : string = response.data.key;
			// save the key for future use
			sessionStorage.setItem("apiKey", apiKey);
			console.log("Login successful !");
			// feedback : success
			swal({
				title: "Connexion réussie!",
				text: `Connexion en tant que ${mailInput.value}...`,
				icon: "success",
			  })
			  .then(() => {
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