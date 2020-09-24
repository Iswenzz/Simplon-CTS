import Axios from "axios";
import DeleteButton from "../component/DeleteButton";
import Deserializer from "../util/Deserializer";
import Specialite from "../model/Specialite";
import Repository from "./Repository";

export default class SpecialiteRepository implements Repository {
	list: HTMLUListElement;

	constructor(listId : string) {
		this.list = document.getElementById(listId) as HTMLUListElement;
	}
	
	// DB
	public async getAll() : Promise<Specialite[]> {
		const response =  await Axios.post("../src/backend/php/api/SpecialiteAPI.php", {
			method: "getAll"
		});

		const res : Specialite[] = [];

		for (const specialite of response.data.body) {
			res.push(new Deserializer(new Specialite(), specialite).deserialize());
		}

		return res;
	}

	public async get(model: Specialite) : Promise<Specialite> {
		const response =  await Axios.post("../src/backend/php/api/SpecialiteAPI.php", {
			method: "get",
			code: model.getCode()
		});

		return new Deserializer(new Specialite(), response.data.body).deserialize();
	}


	public async add(specialite: Specialite) : Promise<boolean> {
		const response =  await Axios.post("../src/backend/php/api/SpecialiteAPI.php", {
			method: "add",
			specialite: specialite.jsonSerialize()
		});

		return response.data.success;
	}


	public async delete(specialite: Specialite) : Promise<boolean> {
		const response =  await Axios.post("../src/backend/php/api/SpecialiteAPI.php", {
			method: "delete",
			specialite: specialite.jsonSerialize()
		});

		return response.data.success;
	}

	public async update(specialite: Specialite) : Promise<Specialite> {
		const response =  await Axios.post("../src/backend/php/api/SpecialiteAPI.php", {
			method: "update",
			specialite: specialite.jsonSerialize()
		});

		return new Deserializer(new Specialite(), response.data.body).deserialize();
	}

	

	// HTML
	public async listAll(): Promise<void> {

		try {
			const specialites = await this.getAll();

			// display all specialites gotten from the DB
			for (const specialite of specialites) {
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = specialite.format();
				this.list.append(item);

				item.setAttribute("id", "");
				item.classList.add("list-item");

				// personal delete button
				const del = new DeleteButton(item, specialite, this);
				item.append(del.getButton());
			}
		} catch (error) {
			console.log(error);
		}
	}
}