import Axios, {AxiosResponse} from "axios";
import Repository from "./Repository";
import {Specialite} from "./SpecialiteRepository";
import ResponseAPI from "./ResponseAPI";
import Model from "./Model";
import {Contact} from "./ContactRepository";
import {Cible} from "./CibleRepository";
import {Agent} from "./AgentRepository";
import {Planque} from "./PlanqueRepository";

export interface Mission extends Model
{
	code: number,
	titre: string,
	description: string,
	dateDebut: string,
	dateFin: string,
	contacts: Contact[],
	cibles: Cible[],
	agents: Agent[],
	planques: Planque[],
	statut: Statut,
	type: TypeMission,
	specialite: Specialite
}

export interface Statut extends Model
{
	code: number,
	libelle: string
}

export interface TypeMission extends Model
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
		const response: AxiosResponse<ResponseAPI<Mission[]>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/MissionAPI.php`, {
			method: "getAll"
		});
		return response.data.body;
	}

	/**
	 * Get a mission.
	 * @param model
	 */
	public async get(model: Mission) : Promise<Mission>
	{
		const response: AxiosResponse<ResponseAPI<Mission>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/MissionAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data.body;
	}

	/**
	 * Add a mission.
	 * @param mission
	 */
	public async add(mission: Mission) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Mission>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/MissionAPI.php`, {
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
		const response: AxiosResponse<ResponseAPI<Mission>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/MissionAPI.php`, {
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
		const response: AxiosResponse<ResponseAPI<Mission>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/MissionAPI.php`, {
			method: "update",
			mission: mission
		});
		return response.data.success;
	}
}
