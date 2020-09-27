import Axios from "axios";
import DeleteButton from "../component/DeleteButton";
import Deserializer from "../util/Deserializer";
import Cible from "../model/Cible";
import Repository from "./Repository";

export default class CibleRepository implements Repository
{
	/**
	 * Get all cible.
	 */
	public async getAll() : Promise<Cible[]>
	{
		const response =  await Axios.post("../src/backend/php/api/CibleAPI.php", {
			method: "getAll"
		});

		const res : Cible[] = [];
		for (const cible of response.data.body)
			res.push(new Deserializer(new Cible(), cible).deserialize());
		return res;
	}

	/**
	 * Get a cible.
	 * @param model
	 */
	public async get(model: Cible) : Promise<Cible>
	{
		const response =  await Axios.post("../src/backend/php/api/CibleAPI.php", {
			method: "get",
			code: model.getCode()
		});
		return new Deserializer(new Cible(), response.data.body).deserialize();
	}

	/**
	 * Add a cible.
	 * @param cible
	 */
	public async add(cible: Cible) : Promise<boolean>
	{
		const response =  await Axios.post("../src/backend/php/api/CibleAPI.php", {
			method: "add",
			cible: cible.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Delete a cible.
	 * @param cible
	 */
	public async delete(cible: Cible) : Promise<boolean>
	{
		const response =  await Axios.post("../src/backend/php/api/CibleAPI.php", {
			method: "delete",
			cible: cible.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Update a cible.
	 * @param cible
	 */
	public async update(cible: Cible) : Promise<Cible>
	{
		const response =  await Axios.post("../src/backend/php/api/CibleAPI.php", {
			method: "update",
			cible: cible.jsonSerialize()
		});
		return new Deserializer(new Cible(), response.data.body).deserialize();
	}

	// public async listAll(): Promise<void>
	// {
	// 	try
	// 	{
	// 		const cibles = await this.getAll();
	// 		// display all cibles gotten from the DB
	// 		for (const cible of cibles)
	// 		{
	// 			const item = document.createElement("li") as HTMLLIElement;
	// 			item.innerText = cible.format();
	// 			this.list.append(item);
	//
	// 			item.setAttribute("id", "");
	// 			item.classList.add("list-item");
	//
	// 			// personal delete button
	// 			const del = new DeleteButton(item, cible, this);
	// 			item.append(del.getButton());
	// 		}
	// 	}
	// 	catch (error)
	// 	{
	// 		console.log(error);
	// 	}
	// }
}