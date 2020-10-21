import Axios, {AxiosResponse} from "axios";
import Repository from "./Repository";
import ResponseAPI from "./ResponseAPI";
import Model from "./Model";

export interface TypeMission extends Model
{
	libelle: string,
	description: string
}

export default class TypeMissionRepository implements Repository<TypeMission>
{
	/**
	 * Get all typeMission.
	 */
	public async getAll() : Promise<TypeMission[]>
	{
		const response: AxiosResponse<ResponseAPI<TypeMission[]>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/TypeMissionAPI.php`, {
			method: "getAll"
		});
		return response.data.body;
	}

	/**
	 * Get a typeMission.
	 * @param model
	 */
	public async get(model: TypeMission) : Promise<TypeMission>
	{
		const response: AxiosResponse<ResponseAPI<TypeMission>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/TypeMissionAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data.body;
	}

	/**
	 * Add a typeMission.
	 * @param typeMission
	 */
	public async add(typeMission: TypeMission) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<TypeMission>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/TypeMissionAPI.php`, {
			method: "add",
			typeMission: typeMission
		});
		return response.data.success;
	}

	/**
	 * Delete a typeMission.
	 * @param typeMission
	 */
	public async delete(typeMission: TypeMission) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<TypeMission>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/TypeMissionAPI.php`, {
			method: "delete",
			typeMission: typeMission
		});
		return response.data.success;
	}

	/**
	 * Update a typeMission.
	 * @param typeMission
	 */
	public async update(typeMission: TypeMission) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<TypeMission>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/TypeMissionAPI.php`, {
			method: "update",
			typeMission: typeMission
		});
		return response.data.success;
	}
}