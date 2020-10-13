import Axios from "axios";
import Repository from "./Repository";
import ResponseAPI from "./ResponseAPI";
import {Pays} from "./PaysRepository";

export interface Agent extends ResponseAPI
{
	code: number,
	nom: string,
	prenom: string,
	dateNaissance: string,
	pays: Pays
}

export default class AgentRepository implements Repository
{
	/**
	 * Get all agent.
	 */
	public async getAll() : Promise<Agent[]>
	{
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/AgentAPI.php`, {
			method: "getAll"
		});
		return response.data;
	}

	/**
	 * Get an agent.
	 * @param model
	 */
	public async get(model: Agent) : Promise<Agent>
	{
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/AgentAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data;
	}

	/**
	 * Add an agent.
	 * @param agent
	 */
	public async add(agent: Agent) : Promise<boolean>
	{
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/AgentAPI.php`, {
			method: "add",
			agent: agent
		});
		return response.data;
	}

	/**
	 * Delete an agent.
	 * @param agent
	 */
	public async delete(agent: Agent) : Promise<boolean>
	{
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/AgentAPI.php`, {
			method: "delete",
			agent: agent
		});
		return response.data.sucess;
	}

	/**
	 * Update an agent.
	 * @param agent
	 */
	public async update(agent: Agent) : Promise<boolean>
	{
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/AgentAPI.php`, {
			method: "update",
			agent: agent
		});
		return response.data.success;
	}
}
