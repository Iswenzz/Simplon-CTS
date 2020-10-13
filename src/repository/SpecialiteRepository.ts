import Axios, {AxiosResponse} from "axios";
import Repository from "./Repository";
import ResponseAPI from "./ResponseAPI";
import {TypeMission} from "./MissionRepository";
import Model from "./Model";

export interface Specialite extends Model
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
		const response: AxiosResponse<ResponseAPI<Specialite[]>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/SpecialiteAPI.php`, {
			method: "getAll"
		});
		return response.data.body;
	}

	/**
	 * Get a specialite.
	 * @param model
	 */
	public async get(model: Specialite) : Promise<Specialite>
	{
		const response: AxiosResponse<ResponseAPI<Specialite>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/SpecialiteAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data.body;
	}

	/**
	 * Add a specialite.
	 * @param specialite
	 */
	public async add(specialite: Specialite) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Specialite>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/SpecialiteAPI.php`, {
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
		const response: AxiosResponse<ResponseAPI<Specialite>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/SpecialiteAPI.php`, {
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
		const response: AxiosResponse<ResponseAPI<Specialite>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/SpecialiteAPI.php`, {
			method: "update",
			specialite: specialite
		});
		return response.data.success;
	}
}