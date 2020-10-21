import Axios, {AxiosResponse} from "axios";
import Repository from "./Repository";
import ResponseAPI from "./ResponseAPI";
import {Pays} from "./PaysRepository";
import Model from "./Model";

export interface Agent extends Model
{
	code: number,
	nom: string,
	prenom: string,
	dateNaissance: string,
	pays: Pays
}

export default class AgentRepository implements Repository<Agent>
{
	/**
	 * Get all agent.
	 */
	public async getAll() : Promise<Agent[]>
	{
		const response: AxiosResponse<ResponseAPI<Agent[]>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/AgentAPI.php`, {
			method: "getAll"
		});
		return response.data.body;
	}

	/**
	 * Get an agent.
	 * @param model
	 */
	public async get(model: Agent) : Promise<Agent>
	{
		const response: AxiosResponse<ResponseAPI<Agent>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/AgentAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data.body;
	}

	/**
	 * Add an agent.
	 * @param agent
	 */
	public async add(agent: Agent) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Agent>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/AgentAPI.php`, {
			method: "add",
			agent: agent
		});
		return response.data.success;
	}

	/**
	 * Delete an agent.
	 * @param agent
	 */
	public async delete(agent: Agent) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Agent>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/AgentAPI.php`, {
			method: "delete",
			agent: agent
		});
		return response.data.success;
	}

	/**
	 * Update an agent.
	 * @param agent
	 */
	public async update(agent: Agent) : Promise<boolean>
	{
		const response: AxiosResponse<ResponseAPI<Agent>> = await Axios.post(`${process.env.BACKEND_URL}/server/src/api/AgentAPI.php`, {
			method: "update",
			agent: agent
		});
		return response.data.success;
	}
}
