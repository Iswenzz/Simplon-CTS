import Axios from "axios";
import DeleteButton from "../component/DeleteButton";
import Deserializer from "../Deserializer";
import Contact from "../model/Contact";
import Repository from "./Repository";

export default class ContactRepository implements Repository {
	list: HTMLUListElement;

	constructor(listId : string) {
		this.list = document.getElementById(listId) as HTMLUListElement;
	}
	
	// DB
	public async getAll() : Promise<Contact[]> {
		const response =  await Axios.post("../src/backend/php/api/ContactAPI.php", {
			method: "getAll"
		});

		const res : Contact[] = [];

		for (const contact of response.data.body) {
			res.push(new Deserializer(new Contact(), contact).deserialize());
		}

		return res;
	}

	public async get(model: Contact) : Promise<Contact> {
		const response =  await Axios.post("../src/backend/php/api/ContactAPI.php", {
			method: "get",
			code: model.getCode()
		});

		return new Deserializer(new Contact(), response.data.body).deserialize();
	}


	public async add(contact: Contact) : Promise<boolean> {
		const response =  await Axios.post("../src/backend/php/api/ContactAPI.php", {
			method: "add",
			contact: contact.jsonSerialize()
		});

		return response.data.success;
	}


	public async delete(contact: Contact) : Promise<boolean> {
		const response =  await Axios.post("../src/backend/php/api/ContactAPI.php", {
			method: "delete",
			contact: contact.jsonSerialize()
		});

		return response.data.success;
	}

	public async update(contact: Contact) : Promise<Contact> {
		const response =  await Axios.post("../src/backend/php/api/ContactAPI.php", {
			method: "update",
			contact: contact.jsonSerialize()
		});

		return new Deserializer(new Contact(), response.data.body).deserialize();
	}

	

	// HTML
	public async listAll(): Promise<void> {

		try {
			const contacts = await this.getAll();

			// display all contacts gotten from the DB
			for (const contact of contacts) {
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = contact.format();
				this.list.append(item);

				item.setAttribute("id", "");
				item.classList.add("list-item");

				// personal delete button
				const del = new DeleteButton(item, contact, this);
				item.append(del.getButton());
			}
		} catch (error) {
			console.log(error);
		}
	}
}