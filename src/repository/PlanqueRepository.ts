import Axios, {AxiosResponse} from "axios";
import Repository from "./Repository";
import {Pays} from "./PaysRepository";
import ResponseAPI from "./ResponseAPI";
import Model from "./Model";
import {TypePlanque} from "./TypePlanqueRepository";

export interface Planque extends Model
{
	code: number,
	adresse: string,
	pays: Pays,
	typePlanque: TypePlanque
}

export default class PlanqueRepository implements Repository<Planque>
{
	/**
	 * Get all planque.
	 */
	public async getAll() : Promise<Planque[]>
	{
		const response: AxiosResponse<ResponseAPI<Planque[]>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
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
		const response: AxiosResponse<ResponseAPI<Planque>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
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
		const response: AxiosResponse<ResponseAPI<Planque[]>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
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
		const response: AxiosResponse<ResponseAPI<Planque>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
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
		const response: AxiosResponse<ResponseAPI<Planque>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
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
		const response: AxiosResponse<ResponseAPI<Planque>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PlanqueAPI.php`, {
			method: "update",
			planque: planque
		});
		return response.data.success;
	}
}
