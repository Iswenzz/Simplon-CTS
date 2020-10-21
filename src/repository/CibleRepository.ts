import Axios, {AxiosResponse} from "axios";
import Repository from "./Repository";
import {Pays} from "./PaysRepository";
import ResponseAPI from "./ResponseAPI";
import Model from "./Model";

export interface Cible extends Model
{
	code: number,
	nom: string,
	prenom: string,
	dateNaissance: string,
	pays: Pays
}

export default class CibleRepository implements Repository<Cible>
{
	/**
	 * Get all cible.
	 */
	public async getAll() : Promise<Cible[]>
	{
		const response: AxiosResponse<ResponseAPI<Cible[]>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/CibleAPI.php`, {
			method: "getAll"
		});
		return response.data.body;
	}

	/**
	 * Get a cible.
	 * @param model
	 */
	public async get(model: Cible) : Promise<Cible>
	{
		const response: AxiosResponse<ResponseAPI<Cible>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/CibleAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data.body;
	}

	/**
	 * Add a cible.
	 * @param cible
	 */
	public async add(cible: Cible) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Cible>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/CibleAPI.php`, {
			method: "add",
			cible: cible
		});
		return response.data.success;
	}

	/**
	 * Delete a cible.
	 * @param cible
	 */
	public async delete(cible: Cible) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Cible>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/CibleAPI.php`, {
			method: "delete",
			cible: cible
		});
		return response.data.success;
	}

	/**
	 * Update a cible.
	 * @param cible
	 */
	public async update(cible: Cible) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Cible>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/CibleAPI.php`, {
			method: "update",
			cible: cible
		});
		return response.data.success;
	}
}
