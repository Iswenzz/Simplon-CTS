import Axios from "axios";
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
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/CibleAPI.php", {
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
		const response = await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/CibleAPI.php", {
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
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/CibleAPI.php", {
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
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/CibleAPI.php", {
			method: "delete",
			cible: cible.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Update a cible.
	 * @param cible
	 */
	public async update(cible: Cible) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/CibleAPI.php", {
			method: "update",
			cible: cible.jsonSerialize()
		});
		return response.data.success;
	}
}
