import Axios from "axios";
import Deserializer from "../util/Deserializer";
import Planque from "../model/Planque";
import Repository from "./Repository";
import Pays from "../model/Pays";

export default class PlanqueRepository implements Repository
{
	/**
	 * Get all planque.
	 */
	public async getAll() : Promise<Planque[]>
	{
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "getAll"
		});

		const res : Planque[] = [];
		for (const planque of response.data.body)
			res.push(new Deserializer(new Planque(), planque).deserialize());
		return res;
	}

	/**
	 * Get a planque.
	 * @param model
	 */
	public async get(model: Planque) : Promise<Planque>
	{
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "get",
			code: model.getCode()
		});
		return new Deserializer(new Planque(), response.data.body).deserialize();
	}

	/**
	 * Get all planque in a specific pays.
	 * @param pays
	 */
	public async getAllInCountry(pays: Pays) : Promise<Planque[]>
	{
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "getAllInCountry",
			code: pays.getCode()
		});

		const res : Planque[] = [];
		for (const planque of response.data.body)
			res.push(new Deserializer(new Planque(), planque).deserialize());
		return res;
	}

	/**
	 * Add a planque.
	 * @param planque
	 */
	public async add(planque: Planque) : Promise<boolean>
	{
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "add",
			planque: planque.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Delete a planque.
	 * @param planque
	 */
	public async delete(planque: Planque) : Promise<boolean>
	{
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "delete",
			planque: planque.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Update a planque.
	 * @param planque
	 */
	public async update(planque: Planque) : Promise<Planque>
	{
		const response =  await Axios.post("../src/backend/php/api/PlanqueAPI.php", {
			method: "update",
			planque: planque.jsonSerialize()
		});
		return new Deserializer(new Planque(), response.data.body).deserialize();
	}
}
