import Axios from "axios";
import Repository from "./Repository";
import {Specialite} from "./SpecialiteRepository";
import ResponseAPI from "./ResponseAPI";

export interface Mission extends ResponseAPI
{
	code: number,
	titre: string,
	description: string,
	dateDebut: string,
	dateFin: string,
	statut: Statut,
	type: TypeMission,
	specialite: Specialite
}

export interface Statut
{
	code: number,
	libelle: string
}

export interface TypeMission
{
	code: number,
	libelle: string,
	description: string
}

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
		return response.data;
	}

	/**
	 * Get a mission.
	 * @param model
	 */
	public async get(model: Mission) : Promise<Mission>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/MissionAPI.php", {
			method: "get",
			code: model.code
		});
		return response.data;
	}

	/**
	 * Add a mission.
	 * @param mission
	 */
	public async add(mission: Mission) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/MissionAPI.php", {
			method: "add",
			mission: mission
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
			mission: mission
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
			mission: mission
		});
		return response.data.success;
	}
}
