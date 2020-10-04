import Axios from "axios";
import Deserializer from "../util/Deserializer";
import Mission from "../model/Mission";
import Repository from "./Repository";

export default class MissionRepository implements Repository
{
	/**
	 * Get all mission.
	 */
	public async getAll() : Promise<Mission[]>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/MissionAPI.php", {
			method: "getAll"
		});

		const res : Mission[] = [];
		for (const mission of response.data.body)
			res.push(new Deserializer(new Mission(), mission).deserialize());
		return res;
	}

	/**
	 * Get a mission.
	 * @param model
	 */
	public async get(model: Mission) : Promise<Mission>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/MissionAPI.php", {
			method: "get",
			code: model.getCode()
		});
		return new Deserializer(new Mission(), response.data.body).deserialize();
	}

	/**
	 * Add a mission.
	 * @param mission
	 */
	public async add(mission: Mission) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/MissionAPI.php", {
			method: "add",
			mission: mission.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Delete a mission.
	 * @param mission
	 */
	public async delete(mission: Mission) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/MissionAPI.php", {
			method: "delete",
			mission: mission.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Update a mission.
	 * @param mission
	 */
	public async update(mission: Mission) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/MissionAPI.php", {
			method: "update",
			mission: mission.jsonSerialize()
		});
		return response.data.success;
	}
}
