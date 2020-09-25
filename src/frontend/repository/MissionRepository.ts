import Axios from "axios";
import DeleteButton from "../component/DeleteButton";
import Deserializer from "../util/Deserializer";
import Mission from "../model/Mission";
import Repository from "./Repository";

export default class MissionRepository implements Repository {
	list: HTMLUListElement;

	constructor(listId = "mission-list") {
		this.list = document.getElementById(listId) as HTMLUListElement;
	}
	
	// DB
	public async getAll() : Promise<Mission[]> {
		const response =  await Axios.post("../src/backend/php/api/MissionAPI.php", {
			method: "getAll"
		});

		const res : Mission[] = [];

		for (const mission of response.data.body) {
			res.push(new Deserializer(new Mission(), mission).deserialize());
		}

		return res;
	}

	public async get(model: Mission) : Promise<Mission> {
		const response =  await Axios.post("../src/backend/php/api/MissionAPI.php", {
			method: "get",
			code: model.getCode()
		});

		return new Deserializer(new Mission(), response.data.body).deserialize();
	}


	public async add(mission: Mission) : Promise<boolean> {
		const response =  await Axios.post("../src/backend/php/api/MissionAPI.php", {
			method: "add",
			mission: mission.jsonSerialize()
		});

		return response.data.success;
	}


	public async delete(mission: Mission) : Promise<boolean> {
		const response =  await Axios.post("../src/backend/php/api/MissionAPI.php", {
			method: "delete",
			mission: mission.jsonSerialize()
		});

		return response.data.success;
	}

	public async update(mission: Mission) : Promise<Mission> {
		const response =  await Axios.post("../src/backend/php/api/MissionAPI.php", {
			method: "update",
			mission: mission.jsonSerialize()
		});

		return new Deserializer(new Mission(), response.data.body).deserialize();
	}

	

	// HTML
	public async listAll(): Promise<void> {

		try {
			const missions = await this.getAll();

			// display all missions gotten from the DB
			for (const mission of missions) {
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = mission.format();
				this.list.append(item);

				item.setAttribute("id", "");
				item.classList.add("list-item");

				item.addEventListener("hover", () => {
					document.querySelector("#mission .transparent").classList.remove("transparent");
				});

				// personal delete button
				const del = new DeleteButton(item, mission, this);
				item.append(del.getButton());
			}
		} catch (error) {
			console.log(error);
		}
	}
}