import Axios, {AxiosResponse} from "axios";
import Repository from "./Repository";
import ResponseAPI from "./ResponseAPI";
import Model from "./Model";

export interface Statut extends Model
{
	libelle: string
}

export default class StatutRepository implements Repository<Statut>
{
	/**
	 * Get all statut.
	 */
	public async getAll() : Promise<Statut[]>
	{
		const response: AxiosResponse<ResponseAPI<Statut[]>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/StatutAPI.php`, {
			method: "getAll"
		});
		return response.data.body;
	}

	/**
	 * Get a statut.
	 * @param model
	 */
	public async get(model: Statut) : Promise<Statut>
	{
		const response: AxiosResponse<ResponseAPI<Statut>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/StatutAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data.body;
	}

	/**
	 * Add a statut.
	 * @param statut
	 */
	public async add(statut: Statut) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Statut>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/StatutAPI.php`, {
			method: "add",
			statut: statut
		});
		return response.data.success;
	}

	/**
	 * Delete a statut.
	 * @param statut
	 */
	public async delete(statut: Statut) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Statut>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/StatutAPI.php`, {
			method: "delete",
			statut: statut
		});
		return response.data.success;
	}

	/**
	 * Update a statut.
	 * @param statut
	 */
	public async update(statut: Statut) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Statut>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/StatutAPI.php`, {
			method: "update",
			statut: statut
		});
		return response.data.success;
	}
}