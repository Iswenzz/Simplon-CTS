import "axios";
import Axios, { AxiosResponse } from "axios";


const form : HTMLFormElement = document.getElementsByTagName("form")[0];
const mailInput = document.getElementById("mail") as HTMLInputElement;
const pwdInput = document.getElementById("motDePasse") as HTMLInputElement;

form.addEventListener("submit", async (ev) => {
	ev.preventDefault();

	console.log(`test ${mailInput.value} & ${pwdInput.value}`);

	try {
		// TODO : passage en prod => mettre un URL absolu par rapport au serveur hébergeur
		const response = await Axios.post("../src/backend/php/checkConnect.php", {
			"mail": mailInput.value,
			"motDePasse": pwdInput.value
		});
		// thanks to async .. await, this is synchronized with the fetch
		console.log(response.data);
	} catch (error) {
		// console.log(error);
	}
});