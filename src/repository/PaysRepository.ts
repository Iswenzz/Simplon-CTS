import Axios, {AxiosResponse} from "axios";
import Repository from "./Repository";
import ResponseAPI from "./ResponseAPI";
import Model from "./Model";

export interface Pays extends Model
{
	code: number,
	libelle: string
}

export default class PaysRepository implements Repository
{
	/**
	 * Get all pays.
	 */
	public async getAll(): Promise<Pays[]>
	{
		const response: AxiosResponse<ResponseAPI<Pays[]>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PaysAPI.php`, {
			method: "getAll"
		});
		return response.data.body;
	}

	/**
	 * Get a pays.
	 * @param model
	 */
	public async get(model: Pays): Promise<Pays>
	{
		const response: AxiosResponse<ResponseAPI<Pays>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/PaysAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data.body;
	}

	/**
	 * Add a pays.
	 * @param model
	 */
	public add(model: Pays): Promise<boolean>
	{
		throw new Error("Method not implemented.");
	}

	/**
	 * Delete a pays.
	 * @param model
	 */
	public delete(model: Pays): Promise<boolean>
	{
		throw new Error("Method not implemented.");
	}

	/**
	 * Update a pays.
	 * @param model
	 */
	public update(model: Pays): Promise<boolean>
	{
		throw new Error("Method not implemented.");
	}
}
