import Axios from "axios";
import DeleteButton from "../component/DeleteButton";
import Deserializer from "../util/Deserializer";
import Planque from "../model/Planque";
import Repository from "./Repository";

export default class PlanqueRepository implements Repository {
	list: HTMLUListElement;

	constructor(listId : string) {
		this.list = document.getElementById(listId) as HTMLUListElement;
	}
	
	// DB
	public async getAll() : Promise<Planque[]> {
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "getAll"
		});

		const res : Planque[] = [];

		for (const planque of response.data.body) {
			res.push(new Deserializer(new Planque(), planque).deserialize());
		}

		return res;
	}

	public async get(model: Planque) : Promise<Planque> {
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "get",
			code: model.getCode()
		});

		return new Deserializer(new Planque(), response.data.body).deserialize();
	}


	public async add(planque: Planque) : Promise<boolean> {
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "add",
			planque: planque.jsonSerialize()
		});

		return response.data.success;
	}


	public async delete(planque: Planque) : Promise<boolean> {
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "delete",
			planque: planque.jsonSerialize()
		});

		return response.data.success;
	}

	public async update(planque: Planque) : Promise<Planque> {
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "update",
			planque: planque.jsonSerialize()
		});

		return new Deserializer(new Planque(), response.data.body).deserialize();
	}

	

	// HTML
	public async listAll(): Promise<void> {

		try {
			const planques = await this.getAll();

			// display all planques gotten from the DB
			for (const planque of planques) {
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = planque.format();
				this.list.append(item);

				item.setAttribute("id", "");
				item.classList.add("list-item");

				// personal delete button
				const del = new DeleteButton(item, planque, this);
				item.append(del.getButton());
			}
		} catch (error) {
			console.log(error);
		}
	}
}