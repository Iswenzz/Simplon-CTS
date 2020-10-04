import Axios from "axios";
import Deserializer from "../util/Deserializer";
import Agent from "../model/Agent";
import Repository from "./Repository";

export default class AgentRepository implements Repository
{
	/**
	 * Get all agent.
	 */
	public async getAll() : Promise<Agent[]>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/AgentAPI.php", {
			method: "getAll"
		});

		const res : Agent[] = [];
		for (const agent of response.data.body)
			res.push(new Deserializer(new Agent(), agent).deserialize());
		return res;
	}

	/**
	 * Get an agent.
	 * @param model
	 */
	public async get(model: Agent) : Promise<Agent>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/AgentAPI.php", {
			method: "get",
			code: model.getCode()
		});
		return new Deserializer(new Agent(), response.data.body).deserialize();
	}

	/**
	 * Add an agent.
	 * @param agent
	 */
	public async add(agent: Agent) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/AgentAPI.php", {
			method: "add",
			agent: agent.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Delete an agent.
	 * @param agent
	 */
	public async delete(agent: Agent) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/AgentAPI.php", {
			method: "delete",
			agent: agent.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Update an agent.
	 * @param agent
	 */
	public async update(agent: Agent) : Promise<Agent>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/AgentAPI.php", {
			method: "update",
			agent: agent.jsonSerialize()
		});
		return new Deserializer(new Agent(), response.data.body).deserialize();
	}
}
