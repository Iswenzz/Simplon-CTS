import Axios from "axios";
import Repository from "./Repository";
import {Pays} from "./PaysRepository";
import ResponseAPI from "./ResponseAPI";

export interface Cible extends ResponseAPI
{
	code: number,
	nom: string,
	prenom: string,
	dateNaissance: string,
	pays: Pays
}

export default class CibleRepository implements Repository
{
	/**
	 * Get all cible.
	 */
	public async getAll() : Promise<Cible[]>
	{
		const response = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/CibleAPI.php`, {
			method: "getAll"
		});
		return response.data;
	}

	/**
	 * Get a cible.
	 * @param model
	 */
	public async get(model: Cible) : Promise<Cible>
	{
		const response = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/CibleAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data;
	}

	/**
	 * Add a cible.
	 * @param cible
	 */
	public async add(cible: Cible) : Promise<boolean>
	{
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/CibleAPI.php`, {
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
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/CibleAPI.php`, {
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
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/CibleAPI.php`, {
			method: "update",
			cible: cible
		});
		return response.data.success;
	}
}
