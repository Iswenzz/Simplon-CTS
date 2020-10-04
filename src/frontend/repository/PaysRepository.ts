import Axios from "axios";
import Pays from "../model/Pays";
import Deserializer from "../util/Deserializer";
import Repository from "./Repository";

export default class PaysRepository implements Repository
{
	/**
	 * Get all pays.
	 */
	public async getAll(): Promise<Pays[]>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/PaysAPI.php", {
			method: "getAll"
		});

		const res : Pays[] = [];
		for (const pays of response.data.body)
			res.push(new Deserializer(new Pays(), pays).deserialize());
		return res;
	}

	/**
	 * Get a pays.
	 * @param model
	 */
	public async get(model: Pays): Promise<Pays>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/PaysAPI.php", {
			method: "get",
			code: model.getCode()
		});
		return new Deserializer(new Pays(), response.data.body).deserialize();
	}

	/**
	 * Add a pays.
	 * @param model
	 */
	add(model: Pays): Promise<boolean>
	{
		throw new Error("Method not implemented.");
	}

	/**
	 * Delete a pays.
	 * @param model
	 */
	delete(model: Pays): Promise<boolean>
	{
		throw new Error("Method not implemented.");
	}

	/**
	 * Update a pays.
	 * @param model
	 */
	update(model: Pays): Promise<Pays>
	{
		throw new Error("Method not implemented.");
	}
}
