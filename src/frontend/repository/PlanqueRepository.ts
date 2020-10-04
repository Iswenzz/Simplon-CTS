import Axios from "axios";
import Deserializer from "../util/Deserializer";
import Planque from "../model/Planque";
import Repository from "./Repository";
import Pays from "../model/Pays";
import TypePlanque from "../model/TypePlanque";

export default class PlanqueRepository implements Repository
{
	/**
	 * Get all planque.
	 */
	public async getAll() : Promise<Planque[]>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/PlanqueAPI.php", {
			method: "getAll"
		});

		const res : Planque[] = [];
		for (const planqueData of response.data.body)
		{
			const planque: Planque = new Deserializer(new Planque(), planqueData).deserialize();
			const typePlanque: TypePlanque = new Deserializer(new TypePlanque(), planqueData.typePlanque).deserialize();
			planque.setTypePlanque(typePlanque);
			res.push(planque);
		}
		return res;
	}

	/**
	 * Get a planque.
	 * @param model
	 */
	public async get(model: Planque) : Promise<Planque>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/PlanqueAPI.php", {
			method: "get",
			code: model.getCode()
		});

		const planque: Planque = new Deserializer(new Planque(), response.data.body).deserialize();
		const typePlanque: TypePlanque = new Deserializer(new TypePlanque(), response.data.body.typePlanque).deserialize();
		planque.setTypePlanque(typePlanque);
		return planque;
	}

	/**
	 * Get all planque in a specific pays.
	 * @param pays
	 */
	public async getAllInCountry(pays: Pays) : Promise<Planque[]>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/PlanqueAPI.php", {
			method: "getAllInCountry",
			code: pays.getCode()
		});

		const res : Planque[] = [];
		for (const planqueData of response.data.body)
		{
			const planque: Planque = new Deserializer(new Planque(), planqueData).deserialize();
			const typePlanque: TypePlanque = new Deserializer(new TypePlanque(), planqueData.typePlanque).deserialize();
			planque.setTypePlanque(typePlanque);
			res.push(planque);
		}
		return res;
	}

	/**
	 * Add a planque.
	 * @param planque
	 */
	public async add(planque: Planque) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/PlanqueAPI.php", {
			method: "add",
			planque: planque.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Delete a planque.
	 * @param planque
	 */
	public async delete(planque: Planque) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/PlanqueAPI.php", {
			method: "delete",
			planque: planque.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Update a planque.
	 * @param planque
	 */
	public async update(planque: Planque) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/PlanqueAPI.php", {
			method: "update",
			planque: planque.jsonSerialize()
		});
		return response.data.success;
	}
}
