import Axios from "axios";
import Repository from "./Repository";
import {Pays} from "./PaysRepository";
import ResponseAPI from "./ResponseAPI";

export interface Planque extends ResponseAPI
{
	code: number,
	adresse: string,
	pays: Pays,
	typePlanque: TypePlanque
}

export interface TypePlanque
{
	code: number,
	libelle: string,
	description: string
}

export default class PlanqueRepository implements Repository
{
	/**
	 * Get all planque.
	 */
	public async getAll() : Promise<Planque[]>
	{
		const response = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
			method: "getAll"
		});
		return response.data.body;
	}

	/**
	 * Get a planque.
	 * @param model
	 */
	public async get(model: Planque) : Promise<Planque>
	{
		const response = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data.body;
	}

	/**
	 * Get all planque in a specific pays.
	 * @param pays
	 */
	public async getAllInCountry(pays: Pays) : Promise<Planque[]>
	{
		const response = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
			method: "getAllInCountry",
			code: pays.code
		});
		return response.data.body;
	}

	/**
	 * Add a planque.
	 * @param planque
	 */
	public async add(planque: Planque) : Promise<boolean>
	{
		const response = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
			method: "add",
			planque: planque
		});
		return response.data.success;
	}

	/**
	 * Delete a planque.
	 * @param planque
	 */
	public async delete(planque: Planque) : Promise<boolean>
	{
		const response = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
			method: "delete",
			planque: planque
		});
		return response.data.success;
	}

	/**
	 * Update a planque.
	 * @param planque
	 */
	public async update(planque: Planque) : Promise<boolean>
	{
		const response = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
			method: "update",
			planque: planque
		});
		return response.data.success;
	}
}
