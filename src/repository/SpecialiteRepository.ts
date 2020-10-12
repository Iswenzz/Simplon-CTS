import Axios from "axios";
import Repository from "./Repository";
import ResponseAPI from "./ResponseAPI";
import {TypeMission} from "./MissionRepository";

export interface Specialite extends ResponseAPI
{
	code: number,
	libelle: string,
	typeMission: TypeMission,
	description: string
}

export default class SpecialiteRepository implements Repository
{
	/**
	 * Get all specialite.
	 */
	public async getAll() : Promise<Specialite[]>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/SpecialiteAPI.php", {
			method: "getAll"
		});
		return response.data;
	}

	/**
	 * Get a specialite.
	 * @param model
	 */
	public async get(model: Specialite) : Promise<Specialite>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/SpecialiteAPI.php", {
			method: "get",
			code: model.code
		});
		return response.data;
	}

	/**
	 * Add a specialite.
	 * @param specialite
	 */
	public async add(specialite: Specialite) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/SpecialiteAPI.php", {
			method: "add",
			specialite: specialite
		});
		return response.data.success;
	}

	/**
	 * Delete a specialite.
	 * @param specialite
	 */
	public async delete(specialite: Specialite) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/SpecialiteAPI.php", {
			method: "delete",
			specialite: specialite
		});
		return response.data.success;
	}

	/**
	 * Update a specialite.
	 * @param specialite
	 */
	public async update(specialite: Specialite) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/SpecialiteAPI.php", {
			method: "update",
			specialite: specialite
		});
		return response.data.success;
	}
}