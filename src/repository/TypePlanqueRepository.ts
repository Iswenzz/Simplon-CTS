import Axios, {AxiosResponse} from "axios";
import Repository from "./Repository";
import ResponseAPI from "./ResponseAPI";
import Model from "./Model";

export interface TypePlanque extends Model
{
	libelle: string,
	description: string
}

export default class TypePlanqueRepository implements Repository<TypePlanque>
{
	/**
	 * Get all typePlanque.
	 */
	public async getAll() : Promise<TypePlanque[]>
	{
		const response: AxiosResponse<ResponseAPI<TypePlanque[]>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/TypePlanqueAPI.php`, {
			method: "getAll"
		});
		return response.data.body;
	}

	/**
	 * Get a typePlanque.
	 * @param model
	 */
	public async get(model: TypePlanque) : Promise<TypePlanque>
	{
		const response: AxiosResponse<ResponseAPI<TypePlanque>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/TypePlanqueAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data.body;
	}

	/**
	 * Add a typePlanque.
	 * @param typePlanque
	 */
	public async add(typePlanque: TypePlanque) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<TypePlanque>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/TypePlanqueAPI.php`, {
			method: "add",
			typePlanque: typePlanque
		});
		return response.data.success;
	}

	/**
	 * Delete a typePlanque.
	 * @param typePlanque
	 */
	public async delete(typePlanque: TypePlanque) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<TypePlanque>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/TypePlanqueAPI.php`, {
			method: "delete",
			typePlanque: typePlanque
		});
		return response.data.success;
	}

	/**
	 * Update a typePlanque.
	 * @param typePlanque
	 */
	public async update(typePlanque: TypePlanque) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<TypePlanque>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/TypePlanqueAPI.php`, {
			method: "update",
			typePlanque: typePlanque
		});
		return response.data.success;
	}
}