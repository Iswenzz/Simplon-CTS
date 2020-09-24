import Axios from "axios";
import DeleteButton from "../component/DeleteButton";
import Deserializer from "../Deserializer";
import Contact from "../model/Contact";
import Model from "../model/Model";
import Controller from "./Controller";

export default class ContactController implements Controller {
	model: Contact;
	list: HTMLUListElement;

	constructor(listId : string) {
		this.list = document.getElementById(listId) as HTMLUListElement;
		this.model = new Contact();
	}
	
	public async fetchAll() : Promise<Contact[]> {
		const response =  await Axios.post("../src/backend/php/api/ContactAPI.php", {
			method: "getAll"
		});

		const res : Contact[] = [];

		for (const contact of response.data.body) {
			console.log(`récup contact : ${JSON.stringify(contact)}`);

			const dsr = new Deserializer(new Contact(), contact);
			console.log(dsr);
			res.push(dsr.deserialize());
		}

		return res;
	}

	fetch: () => Promise<Model>;
	add: () => Promise<boolean>;
	delete: () => Promise<boolean>;
	
	public setModel(model: Contact) : void {
		this.model = model;
	}

	public getModel() : Contact {
		return this.model;
	}


	public async listAll(): Promise<void> {

		try {
			const contacts = await this.fetchAll();

			// display all contacts gotten from the DB
			for (const contact of contacts) {
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = contact.format();
				this.list.append(item);

				item.setAttribute("id", "contact-list-item-..."); // ...code
				item.classList.add("list-item");

				// personal delete button
				const del = new DeleteButton(item);
				item.append(del.getButton());
			}
		} catch (error) {
			console.log(error);
		}
	}
}