import Axios from "axios";
import Deserializer from "../util/Deserializer";
import Contact from "../model/Contact";
import Repository from "./Repository";

export default class ContactRepository implements Repository
{
	/**
	 * Get all contact.
	 */
	public async getAll() : Promise<Contact[]>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/ContactAPI.php", {
			method: "getAll"
		});

		const res : Contact[] = [];
		for (const contact of response.data.body)
			res.push(new Deserializer(new Contact(), contact).deserialize());
		return res;
	}

	/**
	 * Get a contact.
	 * @param model
	 */
	public async get(model: Contact) : Promise<Contact>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/ContactAPI.php", {
			method: "get",
			code: model.getCode()
		});
		return new Deserializer(new Contact(), response.data.body).deserialize();
	}

	/**
	 * Add a contact.
	 * @param contact
	 */
	public async add(contact: Contact) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/ContactAPI.php", {
			method: "add",
			contact: contact.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Delete a contact.
	 * @param contact
	 */
	public async delete(contact: Contact) : Promise<boolean>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/ContactAPI.php", {
			method: "delete",
			contact: contact.jsonSerialize()
		});
		return response.data.success;
	}

	/**
	 * Update a contact.
	 * @param contact
	 */
	public async update(contact: Contact) : Promise<Contact>
	{
		const response =  await Axios.post("http://localhost:3000/simplon_php_sql/courses/tp1/src/backend/php/api/ContactAPI.php", {
			method: "update",
			contact: contact.jsonSerialize()
		});
		return new Deserializer(new Contact(), response.data.body).deserialize();
	}
}